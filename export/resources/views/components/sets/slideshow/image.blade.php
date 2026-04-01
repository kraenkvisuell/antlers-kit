@props(['slide', 'aspectRatioClass', 'imgRatio', 'url', 'alt'])

@php

    $dimensions = [
        'width' => 1100,
        'height' => 1100,
    ];

    $crop = $aspectRatioClass ? true : false;
    $file = $slide->file;

    if ($aspectRatioClass) {
        if ($imgRatio < 1) {
            $dimensions['width'] = $imgRatio * $dimensions['width'];
        } else {
            $dimensions['height'] = (1 / $imgRatio) * $dimensions['height'];
        }
    }

    $hasFocus = $file->has_focus;
    $focus = $file->focus_css;
@endphp

<div class="w-full {{ $aspectRatioClass }}">
    <img
        src="{{ cdnImage($slide->file, [
            'crop' => $crop,
            'hasFocus' => $hasFocus,
            'focus' => $focus,
            'fit' => [$dimensions['width'], $dimensions['height']],
        ]) }}"
        loading="lazy"
        alt="{{ $alt }}"
        class="w-full h-full object-cover"
    />
</div>
