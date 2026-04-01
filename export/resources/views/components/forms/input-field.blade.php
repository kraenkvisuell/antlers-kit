@props([
    'align' => 'left',
    'id' => '',
    'label' => '',
    'help' => '',
    'name' => $attributes->whereStartsWith('wire:model')->first(),
    'required' => false,
    'type' => 'text',
])

@php
    $id = $id ?: 'id_' . Str::slug(Str::random(6));

    $cssClasses = [
        'w-full py-2 px-3 bg-white text-black border border-base-500',
        'text-center' => $align === 'center',
        'text-left' => $align === 'left',
        'outline-dashed outline-red-500 outline-offset-2' => $errors->has($name),
        'min-h-32 pt-1' => $type === 'textarea',
    ];

@endphp

<x-forms.field-wrapper :$name>
    @if ($label)
        <x-forms.label
            :$align
            :$required
            :$id
        >{{ $label }}</x-forms.label>
    @endif

    <div
        class="w-full relative"
        x-data="{
            inputValue: $wire.entangle('{{ $name }}'),
            get isNotEmpty() {
                return this.inputValue !== ''
            }
        }"
    >
        @if ($type === 'textarea')
            <textarea
                x-model="inputValue"
                id="{{ $id }}"
                name="{{ $name }}"
                {{ $attributes }}
                @class($cssClasses)
            ></textarea>
        @else
            <input
                x-model="inputValue"
                id="{{ $id }}"
                name="{{ $name }}"
                {{ $attributes }}
                type="{{ $type }}"
                @class($cssClasses)
            />
        @endif

    </div>

    @if ($help)
        <x-forms.field-help :text="$help" />
    @endif

    @if ($errors->has($name))
        <x-forms.field-error :error="$errors->first($name)" />
    @endif
</x-forms.field-wrapper>
