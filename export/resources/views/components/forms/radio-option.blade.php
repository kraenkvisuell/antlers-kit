@props(['optionId', 'label', 'value', 'labelSize' => 'regular'])

<div @class(['flex items-start gap-2'])>
    <div class="w-7 h-7 relative flex-shrink-0 flex-grow-0">
        <input
            type="radio"
            {{ $attributes }}
            value="{{ $value }}"
            id="{{ $optionId }}"
            class="peer w-full h-full opacity-0"
        />

        <div
            class="
                absolute pointer-events-none top-0 inset-0 rounded-full
                bg-white outline outline-base-800
                peer-checked:border-8 peer-checked:border-base-800
            ">

        </div>
    </div>

    <label
        for="{{ $optionId }}"
        @class([
            'text-sm font-semibold mt-1' => $labelSize === 'regular',
            'leading-[1.1em] text-heading-sm mt-[10px]' => $labelSize === 'small',
        ])
    >{{ $label }}</label>
</div>
