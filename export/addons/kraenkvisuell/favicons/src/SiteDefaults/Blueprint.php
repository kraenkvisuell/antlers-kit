<?php

namespace Kraenkvisuell\Favicons\SiteDefaults;

use Kraenkvisuell\Favicons\Fields;
use Kraenkvisuell\Favicons\HasAssetField;

class Blueprint
{
    use HasAssetField;

    public static function get(): \Statamic\Fields\Blueprint
    {
        return \Statamic\Facades\Blueprint::make()->setContents([
            'tabs' => [
                'favicons' => [
                    'display' => __('favicons::fieldsets/content.icons_section'),
                    'sections' => [
                        [
                            'display' => __('favicons::fieldsets/content.icons_section'),
                            'instructions' => __('favicons::fieldsets/content.explain_website_cascade'),
                            'fields' => (new Fields)->getFields(),
                        ],

                    ],
                ],
            ],
        ]);
    }
}
