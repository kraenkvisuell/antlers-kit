@props(['set'])

@if ($set->headline)
    <hgroup class="grid gap-1">
        @if ($set->has_topline)
            <p class="font-headline text-sm">{!! $set->topline !!}</p>
        @endif

        <h2 class="font-headline text-3xl font-semibold">
            {!! $set->headline !!}
        </h2>

        @if ($set->has_subline)
            <p class="font-headline text-sm">{!! $set->subline !!}</p>
        @endif
    </hgroup>
@endif
