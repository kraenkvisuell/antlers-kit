@props([
    'id' => '',
    'label' => '',
    'sublabel' => '',
    'live' => false,
    'required' => false,
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

    @if ($sublabel)
        <div class="font-headline text-sm">{{ $sublabel }}</div>
    @endif

    <div @class(['flex gap-2 flex-col @sm:flex-row'])>
        @foreach ($options as $option)
            @php
                $optionId = $id . '_' . Str::slug(Str::random(6));
            @endphp

            <x-forms.checkbox-field
                :label="$option['label']"
                :value="$option['value']"
                {{ $attributes }}
                :$optionId
            />
        @endforeach
    </div>

</x-forms.field-wrapper>
