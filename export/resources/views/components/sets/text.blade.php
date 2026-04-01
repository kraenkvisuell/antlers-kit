@props(['set', 'page'])

<x-shared.section>
    <div class="grid gap-9">
        <x-shared.headline :$set />

        <div class="editor">
            {!! $set->text !!}
        </div>

        @if ($set->buttons)
            <div>
                <x-shared.buttons :buttons="$set->buttons" />
            </div>
        @endif
    </div>
</x-shared.section>
