@props(['aspectRatioClass', 'url', 'mime_type'])

<div class="flex justify-center">
    <div class="w-full grid gap-1">
        <div class="w-full {{ $aspectRatioClass }}">
            <video
                class="h-full w-full object-cover"
                playsinline
                muted
                autoplay
                loop
            >
                <source
                    src="{{ $url }}"
                    type="{{ $mime_type }}"
                />
            </video>
        </div>
    </div>
</div>
