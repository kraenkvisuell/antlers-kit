@props(['width' => 'narrow'])

<div @class([
    'flex justify-center w-full sm:px-9 lg:px-12',
    'px-6' => $width === 'narrow',
])>
    <div @class([
        'mx-auto w-full',
        'max-w-screen-md' => $width === 'narrow',
        'max-w-screen-lg' => $width === 'wide',
    ])>
        {{ $slot }}
    </div>
</div>
