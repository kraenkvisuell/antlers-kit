@props(['id', 'required' => false, 'align' => 'left'])

<label
    @class([
        'font-headline text-base uppercase flex items-center',
        'text-center justify-center' => $align === 'center',
        'text-left' => $align === 'left',
    ])
    for="{{ $id }}"
>
    <div>{{ $slot }}{{ $required ? '*' : '' }}</div>
</label>
