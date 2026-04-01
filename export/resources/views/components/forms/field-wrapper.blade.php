@props(['name' => 'empty'])

<div
    @class(['w-full flex flex-col items-stretch scroll-m-20 gap-1'])
    x-ref="{{ $name }}"
>
    {{ $slot }}
</div>
