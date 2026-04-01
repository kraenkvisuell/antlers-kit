<?php

namespace Kraenkvisuell\Favicons\Http\Controllers;

use Carbon\Carbon;
use Illuminate\Routing\Controller;
use Illuminate\Support\Facades\Cache;
use Kraenkvisuell\Favicons\Sitemap\Sitemap;

class SitemapController extends Controller
{
    public function __construct(public Sitemap $sitemap) {}

    public function index()
    {
        abort_unless(config('statamic.favicons.sitemap.enabled'), 404);

        $cacheUntil = Carbon::now()->addMinutes(config('statamic.favicons.sitemap.expire'));
        $cacheKey = $this->cacheKey();

        if (config('statamic.favicons.sitemap.pagination.enabled', false)) {
            $content = Cache::remember("{$cacheKey}_index", $cacheUntil, function () {
                return view('favicons::sitemap_index', [
                    'xml_header' => '<?xml version="1.0" encoding="UTF-8"?>',
                    'sitemaps' => $this->sitemap->paginatedSitemaps(),
                ])->render();
            });
        } else {
            $content = Cache::remember($cacheKey, $cacheUntil, function () {
                return view('favicons::sitemap', [
                    'xml_header' => '<?xml version="1.0" encoding="UTF-8"?>',
                    'pages' => $this->sitemap->pages(),
                ])->render();
            });
        }

        return response($content)->header('Content-Type', 'text/xml');
    }

    public function show($page)
    {
        abort_unless(config('statamic.favicons.sitemap.enabled'), 404);
        abort_unless(config('statamic.favicons.sitemap.pagination.enabled'), 404);
        abort_unless(filter_var($page, FILTER_VALIDATE_INT), 404);

        $cacheUntil = Carbon::now()->addMinutes(config('statamic.favicons.sitemap.expire'));
        $cacheKey = $this->cacheKey($page);

        $content = Cache::remember($cacheKey, $cacheUntil, function () use ($page) {
            abort_if(empty($pages = $this->sitemap->paginatedPages($page)), 404);

            return view('favicons::sitemap', [
                'xml_header' => '<?xml version="1.0" encoding="UTF-8"?>',
                'pages' => $pages,
            ])->render();
        });

        return response($content)->header('Content-Type', 'text/xml');
    }

    protected function cacheKey(string $suffix = ''): string
    {
        $key = collect([
            Sitemap::CACHE_KEY,
            request()->getHttpHost(),
            $this->sitemap->sites()->map->handle()->join(''),
            $suffix,
        ])->filter()->implode('_');

        Sitemap::trackCacheKey($key);

        return $key;
    }
}
