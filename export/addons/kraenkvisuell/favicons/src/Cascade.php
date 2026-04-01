<?php

namespace Kraenkvisuell\Favicons;

use Illuminate\Support\Collection;
use Statamic\Contracts\Query\Builder;
use Statamic\Facades\Antlers;
use Statamic\Facades\Config;
use Statamic\Facades\Entry;
use Statamic\Facades\Site;
use Statamic\Fields\Value;
use Statamic\Fieldtypes\Bard;
use Statamic\Statamic;
use Statamic\Support\Arr;
use Statamic\Support\Str;
use Statamic\View\Antlers\Language\Exceptions\RuntimeException;
use Statamic\View\Cascade as ViewCascade;

class Cascade
{
    protected $data;
    protected $siteDefaults;
    protected $sectionDefaults;
    protected $current;
    protected $explicitUrl;
    protected $model;

    public function __construct()
    {
        $this->data = collect();

        $this->model = new NullModel;
    }

    public function with($array)
    {
        $this->data = $this->data->merge($array);

        return $this;
    }

    public function withSiteDefaults($data)
    {
        $this->with($data);

        $this->siteDefaults = $data;

        return $this;
    }

    public function withSectionDefaults($data)
    {
        $this->with($data);

        $this->sectionDefaults = $data;

        return $this;
    }

    public function withCurrent($data)
    {
        if (is_null($data)) {
            return $this;
        }

        $this->current = $this->augmentData($data);

        $this->model = $data ?? new NullModel;

        return $this;
    }

    public function withExplicitUrl($url)
    {
        $this->explicitUrl = $url;

        return $this;
    }

    public function get()
    {
        $this->hydrateCascade();

        if (! $this->current) {
            $this->withCurrent(Entry::findByUri('/'));
            $this->withExplicitUrl(request()->url());
        }

        if (Arr::get($this->data, 'response_code') === 404) {
            $this->current['title'] = '404 Page Not Found';
        }

        $this->data = $this->data->map(function ($item, $key) {
            return $this->parse($key, $item);
        });

        return $this->data->merge([
            'sizes' => [16, 32, 48, 96, 144, 192, 256, 512],
            'site' => $this->site(),
            'is_default_site' => $this->site()->isDefault(),
        ])->all();
    }

    public function value($key)
    {
        return $this->get()[$key] ?? null;
    }

    protected function parse(
        string $key,
        mixed $item,
        bool $hasAttemptedToFallbackToSection = false
    ) {
        $original = $item;

        if (is_array($item)) {
            return array_map(function ($item) use ($key) {
                return $this->parse($key, $item);
            }, $item);
        }

        // Get raw value for string checks.
        $raw = $item instanceof Value
            ? $item->raw()
            : $item;

        // If they have antlers in the string, they are on their own.
        if (is_string($raw) && Str::contains($raw, '{{')) {
            return $this->parseAntlers($raw);
        }

        // For source-based strings, we should get the value from the source.
        if (is_string($raw) && Str::startsWith($raw, '@favicons:')) {
            $field = explode('@favicons:', $raw)[1];

            if (Str::contains($field, '/')) {
                $field = explode('/', $field)[1];
            }

            $item = Arr::get($this->current, $field);

            if ($item instanceof Value) {
                if ($item->fieldtype() instanceof Bard) {
                    $item = (string) Statamic::modify($item)->bardText();
                } else {
                    $item = $item->value();
                }
            }

            // When the field is empty, attempt to fall back to the section or site defaults.
            if (! $item) {
                if (
                    ! $hasAttemptedToFallbackToSection
                    && isset($this->sectionDefaults[$key])
                    && $this->sectionDefaults[$key] !== $original
                ) {
                    return $this->parse($key, $this->sectionDefaults[$key], hasAttemptedToFallbackToSection: true);
                }

                if (isset($this->siteDefaults[$key]) && $this->siteDefaults[$key] !== $original) {
                    return $this->parse($key, $this->siteDefaults[$key], $hasAttemptedToFallbackToSection);
                }
            }
        }

        // If we have a method here to perform additional parsing, do that now.
        // eg. Limit a string to n characters.
        if (method_exists($this, $method = 'parse' . ucfirst($key) . 'Field')) {
            $item = $this->$method($item);
        }

        return $item;
    }



    protected function site()
    {
        return method_exists($this->model, 'site')
            ? $this->model->site()
            : Site::default();
    }

    protected function alternateLocales()
    {
        if (config('statamic.favicons.alternate_locales') === false) {
            return [];
        } elseif (config('statamic.favicons.alternate_locales.enabled') === false) {
            return [];
        } elseif (! $this->model) {
            return [];
        }

        $alternateLocales = collect(Config::getOtherLocales($this->model->locale()))
            ->filter(fn($locale) => $this->model->in($locale))
            ->filter(fn($locale) => $this->model->in($locale)->status() === 'published')
            ->reject(fn($locale) => collect(config('statamic.favicons.alternate_locales.excluded_sites'))->contains($locale))
            ->map(function ($locale) {
                return [
                    'site' => $site = Site::get($locale),
                    'is_default_site' => $site->isDefault(),
                    'url' => $this->model->in($locale)->absoluteUrl(),
                ];
            });

        $duplicates = $alternateLocales
            ->merge([['site' => $this->site()]])
            ->groupBy(fn($locale) => $locale['site']->shortLocale())
            ->filter(fn($locales) => $locales->count() > 1)
            ->keys();

        $alternateLocales->transform(function ($locale) use ($duplicates) {
            return array_merge($locale, [
                'hreflang' => $duplicates->contains($locale['site']->shortLocale())
                    ? $this->formatHreflangLocale($locale['site']->locale())
                    : $locale['site']->shortLocale(),
            ]);
        });

        return $alternateLocales->all();
    }

    protected function currentHreflang($alternateLocales)
    {
        $currentShortLocale = $this->site()->shortLocale();

        $alternateShortLocales = collect($alternateLocales)
            ->map(fn($locale) => $locale['site']->shortLocale());

        if ($alternateShortLocales->contains($currentShortLocale)) {
            return $this->formatHreflangLocale($this->site()->locale());
        }

        return $currentShortLocale;
    }

    protected function formatHreflangLocale($locale)
    {
        return strtolower(str_replace('_', '-', $locale));
    }

    /** @noinspection PhpUnused */
    protected function parseTitleField($value)
    {
        if ($value instanceof Value) {
            $value = $value->value();
        }

        return trim($value);
    }

    /** @noinspection PhpUnused */
    protected function parseDescriptionField($value)
    {
        if ($value instanceof Value) {
            $value = $value->value();
        }

        if (! is_string($value)) {
            return null;
        }

        $value = trim(strip_tags($value));

        if (strlen($value) > 320) {
            $value = substr($value, 0, 320) . '...';
        }

        return iconv('UTF-8', 'UTF-8//IGNORE', $value);
    }

    /** @noinspection PhpUnused */
    protected function parseImageField($value)
    {
        return $value instanceof Collection || $value instanceof Builder
            ? $value->first()
            : $value;
    }

    protected function parseAntlers($item)
    {
        try {
            return (string) Antlers::parse($item, array_merge(
                app(ViewCascade::class)->toArray(),
                $this->current ?? [],
            ));
        } catch (RuntimeException $e) {
            return $item;
        }
    }

    private function hydrateCascade()
    {
        $cascade = app(ViewCascade::class);

        // Hydrate if not already hydrated.
        // Determine if it's already hydrated by seeing if there's an arbitrary value already in there.
        if (! $cascade->get('now')) {
            $cascade->hydrate();
        }
    }



    protected function augmentData($data)
    {
        return $data->toAugmentedArray();
    }
}
