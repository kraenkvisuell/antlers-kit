@props(['direction' => 'prev'])

<div @class([
    'absolute top-[calc(50%-40px)] z-10 cursor-pointer rounded-full w-9 h-9 bg-white/50',
    'flex justify-center items-center font-headline text-xl',
    'slide-prev left-4' => $direction === 'prev',
    'slide-next right-4' => $direction === 'next',
])>
    {!! $direction === 'prev' ? '&lt;' : '&gt;' !!}
</div>
