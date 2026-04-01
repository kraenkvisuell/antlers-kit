<?php

namespace Kraenkvisuell\Favicons\Fieldtypes;

use Illuminate\Support\Str;
use Statamic\Contracts\Entries\Entry;
use Statamic\Contracts\Taxonomies\Term;
use Statamic\Facades\Blueprint;
use Statamic\Facades\File;
use Statamic\Fields\Fields as BlueprintFields;
use Statamic\Fields\Fieldtype;
use Kraenkvisuell\Favicons\Cascade;
use Kraenkvisuell\Favicons\Fields as FaviconsFields;
use Kraenkvisuell\Favicons\GetsSectionDefaults;
use Kraenkvisuell\Favicons\SiteDefaults\SiteDefaults;
use Statamic\Statamic;
use Statamic\Support\Arr;

class FaviconsFieldtype extends Fieldtype
{
    use GetsSectionDefaults;

    protected $selectable = true;

    public function icon()
    {
        return File::get(__DIR__ . '/../../resources/svg/nav-icon.svg');
    }

    public function preProcess($data)
    {
        if ($data === false) {
            $data = [];
        }

        return $this->fields()->addValues($data ?? [])->preProcess()->values()->all();
    }

    public function preload()
    {
        return [
            'fields' => $this->fields()->toPublishArray(),
            'meta' => $this->fields()->addValues($this->field->value())->meta(),
        ];
    }

    public function process($data)
    {
        $values = Arr::removeNullValues(
            $this->fields()->addValues($data)->process()->values()->all()
        );

        return $values;
    }

    protected function fields()
    {
        // FaviconsFields includes actual sections. However, fieldtypes can't span across multiple
        // sections, so we're mapping through the sections and adding the section fieldtype where necessary.
        $fields = collect($this->fieldConfig())
            ->map(function ($section) {
                return [
                    isset($section['display'])
                        ? [
                            'handle' => Str::slug($section['display'] . '_section'),
                            'field' => [
                                'type' => 'section',
                                'display' => $section['display'],
                                'instructions' => $section['instructions'] ?? null,
                            ],
                        ]
                        : null,
                    ...$section['fields'],
                ];
            })
            ->flatten(1)
            ->filter()
            ->values()
            ->all();

        return new BlueprintFields($fields);
    }

    protected function fieldConfig()
    {
        $parent = $this->field()->parent();

        if (! ($parent instanceof Entry || $parent instanceof Term)) {
            $parent = null;
        }

        return FaviconsFields::new($parent ?? null)->getConfig();
    }

    public function extraRules(): array
    {
        $rules = $this
            ->fields()
            ->addValues((array) $this->field->value())
            ->validator()
            ->rules();

        return collect($rules)->mapWithKeys(function ($rules, $handle) {
            return [$this->field->handle() . '.' . $handle => $rules];
        })->all();
    }

    public function augment($data)
    {
        if (empty($data) || ! is_iterable($data)) {
            return $data;
        }

        $augmented = Blueprint::make()
            ->setContents([
                'tabs' => [
                    'main' => [
                        'sections' => $this->fieldConfig(),
                    ],
                ],
            ])
            ->fields()
            ->addValues($data)
            ->augment()
            ->values()
            ->only(array_keys($data))
            ->all();

        if (Statamic::isApiRoute()) {
            $content = $this->field()->parent();

            return (new Cascade)
                ->withSiteDefaults(SiteDefaults::in($content->locale())->augmented())
                ->withSectionDefaults($this->getAugmentedSectionDefaults($content))
                ->with($augmented)
                ->withCurrent($content)
                ->get();
        }

        return $augmented;
    }
}
