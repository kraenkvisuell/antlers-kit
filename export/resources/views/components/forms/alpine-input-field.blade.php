@props([
    'id' => '',
    'label' => '',
    'help' => '',
    'name' => '',
    'required' => false,
    'type' => 'text',
])

@php
    $id = $id ?: 'id_' . Str::slug(Str::random(6));
    $cssClasses = [
        'text-md px-3 h-9 rounded-xs inset-shadow-xs text-base-900 dark:text-base-100',
        'bg-base-100 dark:bg-base-900 w-full',
    ];
@endphp

<x-forms.field-wrapper :$name>
    @if ($label)
        <x-forms.label
            :$required
            :$id
        >{{ $label }}</x-forms.label>
    @endif

    <div class="w-full relative">
        @if ($type === 'textarea')
            <textarea
                x-model="inputValue"
                id="{{ $id }}"
                {{ $attributes }}
                @class($cssClasses)
            ></textarea>
        @else
            <input
                id="{{ $id }}"
                {{ $attributes }}
                type="{{ $type }}"
                @class($cssClasses)
            />
        @endif
    </div>

    @if ($help)
        <x-forms.field-help :text="$help" />
    @endif
</x-forms.field-wrapper>
