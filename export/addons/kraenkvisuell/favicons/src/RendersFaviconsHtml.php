<?php

namespace Kraenkvisuell\Favicons;

trait RendersFaviconsHtml
{
    /**
     * Render normalized meta view HTML.
     *
     * @param  array  $data
     * @param  bool  $withLineBreaks
     * @return string
     */
    protected function renderFaviconsHtml($data, $withLineBreaks = false)
    {
        // Render view.
        $html = view('favicons::favicons', $data)->render();

        // Remove new lines.
        $html = str_replace(["\n", "\r"], '', $html);

        // Remove whitespace between elements.
        $html = preg_replace('/(>)\s*(<)/', '$1$2', $html);

        // Add cleaner line breaks.
        if ($withLineBreaks) {
            $html = preg_replace('/(<[^\/])/', "\n$1", $html);
        }

        return trim($html);
    }
}
