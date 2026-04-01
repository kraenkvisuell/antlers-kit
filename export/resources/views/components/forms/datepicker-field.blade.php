@props([
    'id' => '',
    'align' => 'left',
    'label' => '',
    'help' => '',
    'name' => $attributes->whereStartsWith('wire:model')->first(),
    'required' => false,
])

@php
    $id = $id ?: 'id_' . Str::slug(Str::random(6));

    $cssClasses = [
        'rounded bg-white dark:bg-base-700 w-full px-3 text-md h-9 dark:text-white dark:scheme-dark',
        'outline-dashed outline-task2' => $errors->has($name),
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

        <input
            x-model="inputValue"
            id="{{ $id }}"
            name="{{ $name }}"
            {{ $attributes }}
            type="date"
            @class($cssClasses)
        />

    </div>

    @if ($help)
        <x-forms.field-help :text="$help" />
    @endif

    @if ($errors->has($name))
        <x-forms.field-error :error="$errors->first($name)" />
    @endif
</x-forms.field-wrapper>
