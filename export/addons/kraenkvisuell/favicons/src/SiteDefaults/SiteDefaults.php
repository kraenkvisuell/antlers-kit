<?php

namespace Kraenkvisuell\Favicons\SiteDefaults;

use Illuminate\Support\Arr;
use Illuminate\Support\Collection;
use Statamic\Facades\Addon;
use Statamic\Facades\Blink;
use Statamic\Facades\Site;

class SiteDefaults
{
    public static function get(): Collection
    {
        return Blink::once('favicons::site-defaults', function () {
            $data = Addon::get('kraenkvisuell/favicons')->settings()->get('site_defaults', []);

            return Site::all()->map(function ($site) use ($data) {
                $values = Arr::get($data, Site::multiEnabled() ? $site->handle() : null);

                // When there are no values set, and it's a root localization, use defaults
                // from the blueprint as initial values.
                if (empty($values) && self::origins()->get($site->handle()) === null) {
                    $values = self::defaultValues();
                }

                return new LocalizedSiteDefaults($site->handle(), collect($values));
            });
        });
    }

    public static function origins($origins = null): Collection|bool
    {
        if (func_num_args() === 0) {
            return Site::all()
                ->mapWithKeys(fn($site) => [$site->handle() => null])
                ->merge(Addon::get('kraenkvisuell/favicons')->settings()->get('site_defaults_sites', []))
                ->map(fn($origin) => empty($origin) ? null : $origin);
        }

        Addon::get('kraenkvisuell/favicons')->settings()->set('site_defaults_sites', $origins)->save();

        Blink::forget('favicons::site-defaults');

        return true;
    }

    public static function in(string $locale): ?LocalizedSiteDefaults
    {
        if (! self::get()->has($locale)) {
            return null;
        }

        return self::get()->get($locale);
    }

    public static function save(LocalizedSiteDefaults $localized): bool
    {
        $data = Addon::get('kraenkvisuell/favicons')->settings()->get('site_defaults', []);

        if (Site::multiEnabled()) {
            $data[$localized->locale()] = $localized->all();
        } else {
            $data = $localized->all();
        }

        Addon::get('kraenkvisuell/favicons')->settings()->set('site_defaults', $data)->save();

        Blink::forget('favicons::site-defaults');

        return true;
    }

    public static function blueprint(): \Statamic\Fields\Blueprint
    {
        return Blueprint::get();
    }

    private static function defaultValues(): array
    {
        return [
            'site_name' => '{{ config:app:name }}',
            'site_name_position' => 'after',
            'site_name_separator' => '|',
            'title' => '@favicons:title',
            'description' => '@favicons:content',
            'canonical_url' => '@favicons:permalink',
            'priority' => 0.5,
            'change_frequency' => 'monthly',
        ];
    }
}
