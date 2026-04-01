@props(['card', 'ratio', 'url', 'alt'])

@php
    $aspectRatioClass = '';
    if ($card->force_ratio) {
        $ratioArr = explode(':', $card->ratio);
        $imgRatio = intval($ratioArr[0]) / intval($ratioArr[1]);
        $aspectRatioClass = 'aspect-' . implode('/', $ratioArr);
    } else {
        $imgRatio = $ratio->raw();
    }

    $dimensions = [
        'width' => 1100,
        'height' => 1100,
    ];

    $crop = $card->force_ratio ? true : false;
    $file = $card->file;

    if ($card->force_ratio) {
        if ($imgRatio < 1) {
            $dimensions['width'] = $imgRatio * $dimensions['width'];
        } else {
            $dimensions['height'] = (1 / $imgRatio) * $dimensions['height'];
        }
    }

    $hasFocus = $file->has_focus;
    $focus = $file->focus_css;
@endphp

<div class="flex justify-center">
    <div class="w-full">
        <img
            src="{{ cdnImage($card->file, [
                'crop' => $crop,
                'hasFocus' => $hasFocus,
                'focus' => $focus,
                'fit' => [$dimensions['width'], $dimensions['height']],
            ]) }}"
            loading="lazy"
            alt="{{ $alt }}"
            class="w-full {{ $aspectRatioClass }}"
        />
    </div>
</div>
