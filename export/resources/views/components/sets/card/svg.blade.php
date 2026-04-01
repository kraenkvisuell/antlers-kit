@props(['ratio', 'url', 'alt', 'card'])

@php
    $aspectRatioClass = '';

    if ($card->force_ratio) {
        $ratioArr = explode(':', $card->ratio);
        $imgRatio = intval($ratioArr[0]) / intval($ratioArr[1]);
        $aspectRatioClass = 'aspect-' . implode('/', $ratioArr);
    } else {
        $imgRatio = $ratio->raw();
    }

    $orientation = $imgRatio < 1 ? 'portrait' : 'landscape';

    $maxWidth = $orientation === 'landscape' ? '' : 'max-w-screen-md';
@endphp

<div class="flex justify-center">
    <div class="grid gap-1 w-full {{ $maxWidth }}">
        <div class="{{ $aspectRatioClass }}">
            <img
                src="{{ $url }}"
                alt="{{ $alt }}"
                class="w-full h-full object-contain"
            />
        </div>
    </div>
</div>
