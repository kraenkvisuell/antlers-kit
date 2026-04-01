<?php

namespace Kraenkvisuell\Favicons;

use Statamic\Contracts\Entries\Entry;
use Statamic\Contracts\Taxonomies\Term;
use Statamic\Facades\Blink;
use Statamic\Facades\Blueprint;
use Statamic\Taxonomies\LocalizedTerm;

trait GetsSectionDefaults
{
    public function getSectionDefaults($current)
    {
        if (! $parent = $this->getSectionParent($current)) {
            return [];
        }

        return Blink::once($this->getCacheKey($parent), function () use ($parent) {
            return $parent->cascade('favicons');
        });
    }

    public function getAugmentedSectionDefaults($current)
    {
        if (! $parent = $this->getSectionParent($current)) {
            return [];
        }

        return Blink::once($this->getCacheKey($parent) . '.augmented', function () use ($parent) {
            return Blueprint::make()
                ->setContents([
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
                ])
                ->fields()
                ->addValues($favicons = $parent->cascade('favicons') ?: [])
                ->augment()
                ->values()
                ->only(array_keys($favicons));
        });
    }

    protected function getCacheKey($parent)
    {
        return 'favicons.section-defaults.' . get_class($parent) . '::' . $parent->handle();
    }

    protected function getSectionParent($current)
    {
        if ($current instanceof Entry) {
            return $current->collection();
        } elseif ($current instanceof Term || $current instanceof LocalizedTerm) {
            return $current->taxonomy();
        }

        return null;
    }
}
