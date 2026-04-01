@props(['url', 'mime_type'])

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
        {{ $attributes }}
    />
</video>
