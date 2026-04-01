<?php

namespace Kraenkvisuell\Favicons;

trait HasAssetField
{
    /**
     * Get asset field config.
     *
     * @return array
     */
    protected static function getAssetFieldConfig()
    {
        if (! $container = config('statamic.favicons.assets.container')) {
            return static::getAssetFieldContainerError();
        }

        return [
            'type' => 'assets',
            'container' => $container,
            'folder' => config('statamic.favicons.assets.folder'),
            'max_files' => 1,
        ];
    }

    /**
     * Show helpful asset field config error.
     *
     * @return array
     */
    protected static function getAssetFieldContainerError()
    {
        return [
            'type' => 'html',
            'html' => <<<'HTML'
<div class="mt-2 text-sm text-red-500">
    Asset container not configured.
</div>
HTML,
        ];
    }
}
