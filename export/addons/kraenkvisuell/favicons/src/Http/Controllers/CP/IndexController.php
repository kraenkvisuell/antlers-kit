<?php

namespace Kraenkvisuell\Favicons\Http\Controllers\CP;

use Inertia\Inertia;
use Statamic\Facades\File;

class IndexController
{
    public function __invoke()
    {
        return Inertia::render('favicons::Index', [
            'icon' => File::get(__DIR__ . '/../../../../resources/svg/nav-icon.svg'),
            'canViewReports' => auth()->user()->can('view favicons reports'),
            'canEditSiteDefaults' => auth()->user()->can('edit favicons site defaults'),
            'canEditSectionDefaults' => auth()->user()->can('edit favicons section defaults'),
        ]);
    }
}
