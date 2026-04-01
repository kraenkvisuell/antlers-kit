<?php

namespace Kraenkvisuell\Favicons\Tags;

use Statamic\Facades\Image;
use Statamic\Facades\Site;
use Kraenkvisuell\Favicons\Cascade;
use Kraenkvisuell\Favicons\GetsSectionDefaults;
use Kraenkvisuell\Favicons\RendersFaviconsHtml;
use Kraenkvisuell\Favicons\SiteDefaults\SiteDefaults;
use Statamic\Tags\Tags;

class FaviconsTags extends Tags
{
    use GetsSectionDefaults,
        RendersFaviconsHtml;

    protected static $handle = 'favicons';

    /**
     * The {{ favicons:favicons }} tag.
     *
     * @return string
     */
    public function favicons()
    {
        if ($this->context->value('favicons') === false) {
            return;
        }

        $data = $this->faviconsData();

        $html = '';

        foreach ($data['sizes'] as $size) {
            foreach (['light', 'dark'] as $mode) {
                $key = $mode . '_' . $size;

                if (!isset($data[$key]) || !$data[$key]) {
                    $key = ($mode === 'light' ? 'dark' : 'light') . '_' . $size;
                }

                if (isset($data[$key]) && $data[$key]) {
                    $html .= '<link rel="icon" href="'
                        . $data[$key]->url()
                        . '" sizes="'
                        . $size . 'x' . $size . '" 
                media="(prefers-color-scheme: ' . $mode . ')" />
                ';
                }
            }
        }

        return $html;
    }

    public function faviconsData()
    {
        $current = optional($this->context->get('favicons'))->augmentable();

        $faviconsData = (new Cascade)
            ->withSiteDefaults(SiteDefaults::in($current?->locale() ?? Site::current()->handle())->augmented())
            ->withSectionDefaults($this->getAugmentedSectionDefaults($current))
            ->with($this->context->value('favicons'))
            ->with($current ? [] : $this->context->except('template_content'))
            ->withCurrent($current)
            ->get();

        return $this->aliasedResult($faviconsData);
    }
}
