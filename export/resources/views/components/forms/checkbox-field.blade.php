@props([
    'id' => '',
    'label' => '',
    'required' => false,
    'readonly' => false,
    'live' => false,
])

@php
    $id = $id ?: 'id_' . Str::slug(Str::random(6));
@endphp

<div @class([
    'w-full relative flex-shrink-0 flex items-start gap-3',
    'opacity-60' => $readonly,
])>

    <input
        type="checkbox"
        @if ($readonly) disabled @endif
        {{ $attributes }}
        id="{{ $id }}"
        @class(['peer w-7 h-7 mt-1 appearance-none bg-white rounded-sm'])
    />

    <label
        for="{{ $id }}"
        @class([
            'leading-[1.2em] w-full min-w-6 peer-checked:font-bold',
            'pt-2.5 text-base font-headline',
        ])
    >
        <div>{!! $label !!}</div>
    </label>

    <i @class([
        'fa-solid fa-check opacity-0 peer-checked:opacity-100 absolute pointer-events-none text-anthrazit',
        'left-0 top-[-2px] text-3xl',
    ])></i>

</div>
