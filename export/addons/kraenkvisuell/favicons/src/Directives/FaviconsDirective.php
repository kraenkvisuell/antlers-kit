<?php

namespace Kraenkvisuell\Favicons\Directives;

use Facades\Statamic\View\Cascade;
use Kraenkvisuell\Favicons\Tags\FaviconsTags;

class FaviconsDirective extends FaviconsTags
{
    public function renderTag($tag, $context)
    {
        if ($this->isMissingContext($context)) {
            $context = array_merge(
                $this->getContextFromCurrentRouteData(),
                $this->getContextFromCascade()
            );
        }

        return $this
            ->setContext($context)
            ->setParameters([])
            ->$tag();
    }

    protected function isMissingContext($context)
    {
        return ! isset($context['current_template']);
    }

    protected function getContextFromCascade()
    {
        $cascade = Cascade::instance();

        // If the cascade has not yet been hydrated, ensure it is hydrated.
        // This is important for people using custom route/controller/view implementations.
        if (empty($cascade->toArray())) {
            $cascade->hydrate();
        }

        return $cascade->toArray();
    }

    protected function getContextFromCurrentRouteData()
    {
        return app('router')->current()?->parameter('data') ?? [];
    }
}
