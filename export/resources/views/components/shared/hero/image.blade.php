@props(['file'])

<img
    src="{{ cdnImage($file, [
        'crop' => false,
        'fit' => [1200, 1200],
    ]) }}"
    loading="lazy"
    {{ $attributes }}
    class="w-full h-full object-cover"
/>
