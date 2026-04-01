<?php

namespace Kraenkvisuell\Favicons\Widgets;

use Illuminate\Support\Facades\File;
use Kraenkvisuell\Favicons\Reporting\Report;
use Statamic\Widgets\VueComponent;
use Statamic\Widgets\Widget;

class FaviconsWidget extends Widget
{
    public function component()
    {
        return VueComponent::render('favicons-widget', [
            'icon' => File::get(__DIR__ . '/../../resources/svg/nav-icon.svg'),
            'reportsUrl' => cp_route('favicons.reports.index'),
            'createUrl' => cp_route('favicons.reports.create'),
            'report' => Report::latestGenerated(),
        ]);
    }
}
