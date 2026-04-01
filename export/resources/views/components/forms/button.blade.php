@props([
    'isLink' => false,
    'isDiv' => false,
    'disabled' => false,
    'type' => 'button',
])

<{{ $isLink ? 'a' : ($isDiv ? 'div' : 'button') }}
    @if (!$isLink && !$isDiv) type="{{ $type }}" wire:loading.attr="disabled" @endif
    {{ $attributes }}
    @class([
        'w-full block px-3 py-1 text-white text-lg bg-black uppercase',
        'cursor-pointer' => !$disabled,
    ])
>
    {!! $slot !!}

    </{{ $isLink ? 'a' : ($isDiv ? 'div' : 'button') }}>
