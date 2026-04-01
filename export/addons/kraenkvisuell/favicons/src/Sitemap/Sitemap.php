<?php

namespace Kraenkvisuell\Favicons\Sitemap;

use Illuminate\Support\Collection as IlluminateCollection;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\LazyCollection;
use Illuminate\Support\Str;
use Statamic\Contracts\Entries\Entry;
use Statamic\Contracts\Query\Builder;
use Statamic\Contracts\Taxonomies\Term;
use Statamic\Facades\Blink;
use Statamic\Facades\Collection;
use Statamic\Facades\Entry as EntryFacade;
use Statamic\Facades\Site as SiteFacade;
use Statamic\Facades\Taxonomy;
use Kraenkvisuell\Favicons\Cascade;
use Kraenkvisuell\Favicons\GetsSectionDefaults;
use Kraenkvisuell\Favicons\SiteDefaults\SiteDefaults;
use Statamic\Sites\Site;
use Statamic\Support\Traits\Hookable;

class Sitemap
{
    use GetsSectionDefaults, Hookable;

    const CACHE_KEY = 'favicons.sitemap';

    public static function invalidateCache(): void
    {
        foreach (Cache::get(self::CACHE_KEY . '.keys', []) as $key) {
            Cache::forget($key);
        }

        Cache::forget(self::CACHE_KEY . '.keys');
    }

    public static function trackCacheKey(string $key): void
    {
        $keys = Cache::get(self::CACHE_KEY . '.keys', []);

        if (! in_array($key, $keys)) {
            Cache::forever(self::CACHE_KEY . '.keys', [...$keys, $key]);
        }
    }

    public function pages(): array
    {
        return collect()
            ->merge($this->publishedEntries())
            ->merge($this->publishedTerms())
            ->merge($this->publishedCollectionTerms())
            ->merge($this->additionalItems())
            ->pipe(fn($pages) => $this->getPages($pages))
            ->sortBy(fn($page) => substr_count(rtrim($page->path(), '/'), '/'))
            ->values()
            ->map
            ->toArray()
            ->all();
    }

    public function paginatedPages(int $page): array
    {
        $perPage = config('statamic.favicons.sitemap.pagination.limit', 100);
        $offset = ($page - 1) * $perPage;
        $remaining = $perPage;

        $pages = collect();

        $entryCount = $this->publishedEntriesCount() - 1;

        if ($offset < $entryCount) {
            $entries = $this->publishedEntriesForPage($page, $perPage);

            if ($entries->count() < $remaining) {
                $remaining -= $entries->count();
            }

            $pages = $pages->merge($entries);
        }

        if ($remaining > 0) {
            $offset = max($offset - $entryCount, 0);

            $pages = $pages->merge(
                collect()
                    ->merge($this->publishedTerms())
                    ->merge($this->publishedCollectionTerms())
                    ->merge($this->additionalItems())
                    ->skip($offset)
                    ->take($remaining)
            );
        }

        if ($pages->isEmpty()) {
            return [];
        }

        return $this
            ->getPages($pages)
            ->values()
            ->map
            ->toArray()
            ->all();
    }

    public function paginatedSitemaps(): array
    {
        // would be nice to make terms a count query rather than getting the count from the terms collection
        $count = $this->publishedEntriesCount() + $this->publishedTerms()->count() + $this->publishedCollectionTerms()->count();

        $sitemapCount = ceil($count / config('statamic.favicons.sitemap.pagination.limit', 100));

        return collect(range(1, $sitemapCount))
            ->map(fn($page) => ['url' => route('statamic.favicons.sitemap.page.show', ['page' => $page])])
            ->all();
    }

    public function sites(): IlluminateCollection
    {
        $sites = SiteFacade::all()->filter(fn($site) => Str::of($site->absoluteUrl())->startsWith(request()->schemeAndHttpHost()));

        return $this->runHooks('sites', $sites);
    }

    protected function getPages($items)
    {
        return $items
            ->map(function ($content) {
                if ($content instanceof Page) {
                    return $content;
                }

                $cascade = $content->value('favicons');

                if ($cascade === false || collect($cascade)->get('sitemap') === false) {
                    return;
                }

                $data = (new Cascade)
                    ->withSiteDefaults($this->getSiteDefaults($content->locale()))
                    ->withSectionDefaults($this->getSectionDefaults($content))
                    ->with($cascade ?: [])
                    ->withCurrent($content)
                    ->get();

                $data['hreflangs'] = $this->hrefLangs($content);

                return (new Page)->with($data);
            })
            ->filter();
    }

    protected function publishedEntriesQuery()
    {
        $collections = Collection::all()
            ->map(function ($collection) {
                return $collection->cascade('favicons') !== false
                    ? $collection->handle()
                    : false;
            })
            ->filter()
            ->values()
            ->all();

        return EntryFacade::query()
            ->when(
                $this->sites()->isNotEmpty(),
                fn(Builder $query) => $query->whereIn('site', $this->sites()->map->handle()->all())
            )
            ->whereIn('collection', $collections)
            ->whereNotNull('uri')
            ->whereStatus('published')
            ->orderBy('uri');
    }

    protected function publishedEntries(): LazyCollection
    {
        return $this->publishedEntriesQuery()->lazy();
    }

    protected function publishedEntriesForPage(int $page, int $perPage): IlluminateCollection
    {
        $offset = ($page - 1) * $perPage;

        return $this
            ->publishedEntriesQuery()
            ->offset($offset)
            ->limit($perPage)
            ->get();
    }

    protected function publishedEntriesCount(): int
    {
        return $this->publishedEntriesQuery()->count();
    }

    protected function publishedTerms()
    {
        return Taxonomy::all()
            ->flatMap(function ($taxonomy) {
                return $taxonomy->cascade('favicons') !== false
                    ? $taxonomy
                    ->queryTerms()
                    ->when($this->sites()->isNotEmpty(), fn(Builder $query) => $query->whereIn('site', $this->sites()->map->handle()->all()))
                    ->get()
                    : collect();
            })
            ->filter
            ->published()
            ->filter(function ($term) {
                return view()->exists($term->template());
            });
    }

    protected function publishedCollectionTerms()
    {
        return Collection::all()
            ->flatMap(function ($collection) {
                return $collection->cascade('favicons') !== false
                    ? $collection->taxonomies()->map->collection($collection)
                    : collect();
            })
            ->flatMap(function ($taxonomy) {
                return $taxonomy->cascade('favicons') !== false
                    ? $taxonomy
                    ->queryTerms()
                    ->when($this->sites()->isNotEmpty(), fn(Builder $query) => $query->whereIn('site', $this->sites()->map->handle()->all()))
                    ->get()->map->collection($taxonomy->collection())
                    : collect();
            })
            ->filter
            ->published()
            ->filter(function ($term) {
                return view()->exists($term->template());
            });
    }

    protected function additionalItems(): IlluminateCollection
    {
        $response = $this->runHooksWith('additional', ['items' => collect()]);

        $items = $response->items ?? [];

        return $items instanceof IlluminateCollection ? $items : collect();
    }

    protected function getSiteDefaults(string $site): array
    {
        return Blink::once("favicons.site-defaults.{$site}", fn() => SiteDefaults::in($site)->all());
    }

    protected function hrefLangs($content): array
    {
        if (
            config('statamic.favicons.alternate_locales') === false
            || config('statamic.favicons.alternate_locales.enabled') === false
        ) {
            return [];
        }

        return match (true) {
            $content instanceof Entry => $this->hrefLangsForEntry($content),
            $content instanceof Term => $this->hrefLangsForTerm($content),
            default => [],
        };
    }

    private function hrefLangsForEntry(Entry $entry): array
    {
        return SiteFacade::all()
            ->values()
            ->filter(fn(Site $site) => $entry->in($site->handle()))
            ->filter(fn(Site $site) => $entry->in($site->handle())->published())
            ->reject(fn(Site $site) => collect(config('statamic.favicons.alternate_locales.excluded_sites'))->contains($site->handle()))
            ->map(fn(Site $site) => [
                'href' => $this->sanitizeUrl($entry->in($site->handle())->absoluteUrl()),
                'hreflang' => strtolower(str_replace('_', '-', $site->locale())),
            ])
            ->push([
                'href' => $this->sanitizeUrl($entry->root()->absoluteUrl()),
                'hreflang' => 'x-default',
            ])
            ->all();
    }

    private function hrefLangsForTerm(Term $term): array
    {
        return SiteFacade::all()
            ->values()
            ->reject(fn(Site $site) => collect(config('statamic.favicons.alternate_locales.excluded_sites'))->contains($site->handle()))
            ->map(fn(Site $site) => [
                'href' => $this->sanitizeUrl($term->in($site->handle())->absoluteUrl()),
                'hreflang' => strtolower(str_replace('_', '-', $site->locale())),
            ])
            ->push([
                'href' => $this->sanitizeUrl($term->inDefaultLocale()->absoluteUrl()),
                'hreflang' => 'x-default',
            ])
            ->all();
    }

    private function sanitizeUrl(string $url): string
    {
        return htmlspecialchars($url, ENT_QUOTES | ENT_XML1, 'UTF-8');
    }
}
