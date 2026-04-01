@props(['set'])

@if ($set->caption || $set->credits)
    <div @class(['flex justify-between gap-12 text-sm px-2 md:px-0'])>
        <div>
            {!! $set->caption !!}
        </div>

        <div class="text-right">
            {!! $set->credits !!}
        </div>
    </div>
@endif
