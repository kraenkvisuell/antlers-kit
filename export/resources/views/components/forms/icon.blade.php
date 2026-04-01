@props([
    'label' => '',
    'labelDirection' => 'top-left',
    'bubble' => '',
    'size' => 'normal',
    'level' => 'neutral',
    'isLink' => false,
    'disabled' => false,
    'faIcon' => 'fa-question',
    'faType' => 'fa-light',
])

<{{ $isLink ? 'a' : 'button' }}
    @if ($disabled) disabled @endif
    @class([
        'cursor-pointer relative group w-[30px] text-center',
        'opacity-30 pointer-events-none' => $disabled,
        'text-base-900 dark:text-base-100' => $level === 'neutral',
        'text-highlight' => $level === 'warning',
    ])
    {{ $attributes }}
>
    <i @class([
        'transition-transform',
        $faType,
        $faIcon,
        'group-hover:scale-125' => !$disabled,
        'text-icon-base' => $size === 'normal',
        'text-icon-sm' => $size === 'small',
        'text-icon-lg' => $size === 'large',
    ])></i>

    @if (trim($bubble))
        <div @class([
            'absolute top-[10px] right-[-2px] text-2xs whitespace-nowrap leading-none',
            'bg-white dark:bg-black border border-black dark:border-white',
            'transition-transform rounded-full flex items-center justify-center h-3 min-w-3 font-bold pt-[1px] px-[2px]',
            'group-hover:scale-125' => !$disabled,
        ])>
            <div>{!! $bubble !!}</div>
        </div>
    @endif

    @if (trim($label))
        <x-shared.tooltip
            :$label
            :$level
            :$labelDirection
            :$size
        />
    @endif
    </{{ $isLink ? 'a' : 'button' }}>
