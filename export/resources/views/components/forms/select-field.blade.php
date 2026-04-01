@props([
    'withEmpty' => false,
    'isSelected' => false,
    'emptyLabel' => '',
    'id' => '',
    'label' => '',
    'align' => 'left',
    'textSize' => 'regular',
    'mode' => 'default',
    'live' => false,
    'name' => $attributes->whereStartsWith('wire:model')->first(),
    'options' => [],
    'required' => false,
])

@php
    $id = $id ?: 'id_' . Str::slug(Str::random(6));

    $isList = array_is_list($options);

    $cssClasses = [
        'rounded appearance-none w-full font-headline font-bold px-3 pt-2 pb-1.5',
        'text-heading-base' => $textSize === 'regular',
        'text-heading-xs xs:text-heading-base' => $textSize === 'small',
        'text-center' => $align === 'center',
        'outline-dashed outline-task2' => $errors->has($name),
    ];
@endphp

<x-forms.field-wrapper :$name>
    @if ($label)
        <x-forms.label
            :$required
            :$id
        >{{ $label }}</x-forms.label>
    @endif

    <div
        class="relative group"
        x-data="{
            currentModel: $wire.entangle('{{ $name }}')
        }"
    >
        <select
            id="{{ $id }}"
            {{ $attributes }}
            x-model="currentModel"
            @class($cssClasses)
            x-bind:class="{
                'bg-task4 text-white': currentModel,
                'bg-white dark:bg-base-700 dark:text-white': (!currentModel || currentModel === 'none' ||
                    currentModel === '0') && {{ $mode === 'default' ? '1' : '0' }},
                'bg-base-600 text-white': (!currentModel || currentModel === 'none' ||
                    currentModel === '0') && {{ $mode === 'forms' ? '1' : '0' }},
            }"
        >
            @if ($withEmpty)
                <option value="">{{ $emptyLabel ?: __('Bitte wählen') }}</option>
            @endif

            @foreach ($options as $optionKey => $optionValue)
                @php
                    $isGroup = isset($optionValue['groupOptions']) && isset($optionValue['groupLabel']);
                @endphp

                @if ($isGroup)
                    <optgroup label="{{ $optionValue['groupLabel'] }}">
                        @foreach ($optionValue['groupOptions'] as $groupOption)
                            <option value="{{ $groupOption['value'] }}">
                                {{ $groupOption['label'] }}
                            </option>
                        @endforeach
                    </optgroup>
                @else
                    @php
                        $value = $optionValue;
                        $label = $optionValue;
                        if (!$isList) {
                            $value = $optionKey;
                        } else {
                            if (isset($optionValue['value'])) {
                                $value = $optionValue['value'];
                            }
                            if (isset($optionValue['label'])) {
                                $label = $optionValue['label'];
                            }
                        }
                    @endphp
                    <option value="{{ $value }}">
                        {{ $label ?: '-' }}
                    </option>
                @endif
            @endforeach
        </select>

        <div
            @class([
                'pointer-events-none absolute flex flex-col text-[9px] top-[12px] right-[12px]',
            ])
            x-bind:class="{
                'text-white/90 group-hover:text-white': currentModel,
                'dark:text-white/90 dark:group-hover:text-white':
                    !currentModel || currentModel === 'none' || currentModel === '0',
            }"
        >
            <i class="fa-solid fa-chevron-up"></i>
            <i class="fa-solid fa-chevron-down mt-[-3px]"></i>
        </div>
    </div>

    @if ($errors->has($name))
        <x-forms.field-error :error="$errors->first($name)" />
    @endif
</x-forms.field-wrapper>
