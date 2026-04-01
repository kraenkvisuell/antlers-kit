@props(['set', 'ratio', 'url', 'mime_type'])

@php
    $ratioClasses = '';
    if ($set->force_ratio) {
        $ratioArr = explode(':', $set->ratio);
        $imgRatio = intval($ratioArr[0]) / intval($ratioArr[1]);
        $ratioClasses = "aspect-{$ratioArr[0]}/{$ratioArr[1]}";
    } else {
        $imgRatio = $ratio->raw();
    }

    $orientation = $imgRatio < 1 ? 'portrait' : 'landscape';
    $maxWidth = $orientation === 'landscape' ? '' : 'max-w-screen-md';
@endphp

<div class="flex justify-center">
    <div class="w-full grid gap-1 {{ $maxWidth }}">
        <div class="w-full {{ $ratioClasses }}">
            <video class="h-full w-full object-cover" playsinline muted autoplay loop>
                <source src="{{ $url }}" type="{{ $mime_type }}" />
            </video>
        </div>

        <x-sets.image.captions :$set />
    </div>
</div>
