@props(['set', 'ratio', 'url', 'alt'])

@php
    $aspectRatioClass = '';
    if ($set->force_ratio) {
        $ratioArr = explode(':', $set->ratio);
        $imgRatio = intval($ratioArr[0]) / intval($ratioArr[1]);
        $aspectRatioClass = 'aspect-' . implode('/', $ratioArr);
    } else {
        $imgRatio = $ratio->raw();
    }

    $dimensions = [
        'lg' => [
            'width' => 1600,
            'height' => 1600,
        ],
        'md' => [
            'width' => 1200,
            'height' => 1200,
        ],
        'default' => [
            'width' => 800,
            'height' => 800,
        ],
    ];

    $orientation = $imgRatio < 1.2 ? 'portrait' : 'landscape';

    $maxWidth = $orientation === 'landscape' ? '' : 'max-w-screen-md';

    if ($set->force_ratio) {
        foreach ($dimensions as $key => $values) {
            if ($imgRatio < 1) {
                $dimensions[$key]['width'] = $imgRatio * $dimensions[$key]['width'];
            } else {
                $dimensions[$key]['height'] = (1 / $imgRatio) * $dimensions[$key]['height'];
            }
        }
    }

    $crop = $set->force_ratio ? true : false;
    $file = $set->file;

    $hasFocus = $file->has_focus;
    $focus = $file->focus_css;
@endphp

<div class="flex justify-center">
    <div class="w-full grid gap-1 {{ $maxWidth }}">
        <picture>
            <source media="(min-width:800px)"
                srcset="{{ cdnImage($set->file, [
                    'crop' => $crop,
                    'hasFocus' => $hasFocus,
                    'focus' => $focus,
                    'fit' => [$dimensions['lg']['width'], $dimensions['lg']['height']],
                    'width' => $dimensions['lg']['width'],
                    'height' => $dimensions['lg']['height'],
                ]) }}">

            <source media="(min-width:600px)"
                srcset="{{ cdnImage($set->file, [
                    'crop' => $crop,
                    'hasFocus' => $hasFocus,
                    'focus' => $focus,
                    'fit' => [$dimensions['md']['width'], $dimensions['md']['height']],
                    'width' => $dimensions['md']['width'],
                    'height' => $dimensions['md']['height'],
                ]) }}">

            <img src="{{ cdnImage($set->file, [
                'crop' => $crop,
                'hasFocus' => $hasFocus,
                'focus' => $focus,
                'fit' => [$dimensions['default']['width'], $dimensions['default']['height']],
                'width' => $dimensions['default']['width'],
                'height' => $dimensions['default']['height'],
            ]) }}"
                loading="lazy" alt="{{ $alt }}" class="w-full {{ $aspectRatioClass }}" />
        </picture>

        <x-sets.image.captions :$set />
    </div>
</div>
