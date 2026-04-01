<?php

namespace Kraenkvisuell\Favicons\Http\Controllers;

use Illuminate\Routing\Controller;
use Statamic\Facades\Site;
use Kraenkvisuell\Favicons\Cascade;
use Kraenkvisuell\Favicons\SiteDefaults\SiteDefaults;

class HumansController extends Controller
{
    public function show()
    {
        abort_unless(config('statamic.favicons.humans.enabled'), 404);

        $cascade = (new Cascade)
            ->withSiteDefaults(SiteDefaults::in(Site::current()->handle())->all())
            ->get();

        $contents = view('favicons::humans', $cascade);

        return response()
            ->make($contents)
            ->header('Content-Type', 'text/plain');
    }
}
