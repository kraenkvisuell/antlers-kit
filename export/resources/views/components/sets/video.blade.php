@props(['set', 'page'])

@php
    $ratioClasses = 'aspect-16/9';
    $imgRatio = 16 / 9;
    if ($set->force_ratio) {
        $ratioArr = explode(':', $set->ratio);
        $imgRatio = intval($ratioArr[0]) / intval($ratioArr[1]);
        $ratioClasses = "aspect-{$ratioArr[0]}/{$ratioArr[1]}";
    }

    $orientation = $imgRatio < 1 ? 'portrait' : 'landscape';

    $maxWidth = $orientation === 'landscape' ? '100%' : '500px';
@endphp

<div class="grid gap-9">
    <x-shared.section>
        <x-shared.headline :$set />
    </x-shared.section>

    <x-shared.section width="wide">
        <div class="flex justify-center">
            <div class="grid gap-1 w-full" style="max-width: {{ $maxWidth }}">
                <div class="w-full {{ $ratioClasses }}">
                    <div class="video-container">
                        {!! $set->embed_code !!}
                    </div>
                </div>

                <x-sets.image.captions :$set />
            </div>
        </div>
    </x-shared.section>
</div>
