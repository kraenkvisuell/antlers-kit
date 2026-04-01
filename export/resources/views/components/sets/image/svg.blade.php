@props(['set', 'ratio', 'url', 'alt'])

@php
    $imgRatio = $ratio->raw();

    $orientation = $imgRatio < 1 ? 'portrait' : 'landscape';

    $maxWidth = $orientation === 'landscape' ? '' : 'max-w-screen-md';
@endphp

<div class="flex justify-center">
    <div class="grid gap-1 w-full {{ $maxWidth }}">
        <img src="{{ $url }}" alt="{{ $alt }}" class="w-full" />

        <x-sets.image.captions :$set />
    </div>
</div>
