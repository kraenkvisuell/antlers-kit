@props([
    'isChecked' => false,
])

<div
    class="group relative cursor-pointer w-5 h-5 text-icon-base"
    {{ $attributes }}
>
    <i @class([
        'absolute top-0 left-0 fa-light group-hover:opacity-0',
        'fa-circle' => !$isChecked,
        'fa-circle-check' => $isChecked,
    ])></i>

    <i @class([
        'absolute top-0 left-0 scale-125 fa-light opacity-0 group-hover:opacity-100',
        'fa-circle' => $isChecked,
        'fa-circle-check' => !$isChecked,
    ])></i>
</div>
