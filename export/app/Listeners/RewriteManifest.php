<?php

namespace App\Listeners;

use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;
use Statamic\Events\GlobalSetSaved;
use Statamic\Facades\GlobalSet;

class RewriteManifest
{
    public function handle(GlobalSetSaved $event): void
    {
        if ($event->globals?->handle() === 'settings') {
            $globalSet = GlobalSet::findByHandle('settings')->inDefaultSite();
            $name = $globalSet->get('website_title') ?: $globalSet->get('browser_title');

            $data = [
                'name' => $name,
                'short_name' => Str::limit($name, 15),
                'start_url' => '/',
                'display' => 'standalone',
                'icons' => [],
            ];

            foreach (config('site.favicon_sizes') as $size) {
                $key = 'favicon_' . $size . 'x' . $size;

                if ($path = $globalSet->get($key)) {
                    $data['icons'][] = [
                        'sizes' => $size . 'x' . $size,
                        'type' => 'image/' . Str::afterLast($path, '.'),
                        'src' => config('app.image_cdn') . '/' . config('filesystems.disks.assets.root') . '/' . $path,
                    ];
                }
            }

            Storage::disk('public_folder')->put('manifest.json', json_encode($data, JSON_PRETTY_PRINT | JSON_UNESCAPED_SLASHES));
        }
    }
}
