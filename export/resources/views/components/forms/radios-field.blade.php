@props([
    'id' => '',
    'label' => '',
    'labelIsVisible' => false,
    'live' => false,
    'required' => false,
    'inline' => false,
    'name' => $attributes->whereStartsWith('wire:model')->first(),
    'options' => [],
])

@php
    $id = $id ?: 'id_' . Str::slug(Str::random(6));
@endphp

<x-forms.field-wrapper :$name>
    @if ($label)
        <x-forms.label
            :$required
            :$id
        >{{ $label }}</x-forms.label>
    @endif

    <div @class(['flex gap-6', 'flex-col' => !$inline])>
        @foreach ($options as $option)
            @php
                $optionId = $id . '_' . Str::slug(Str::random(6));
            @endphp

            <x-forms.radio-option
                :label="$option['value']"
                :value="$option['key']"
                {{ $attributes }}
                :$optionId
            />
        @endforeach
    </div>

</x-forms.field-wrapper>
