@props(['set', 'page'])

<div class="grid gap-9">
    <x-shared.section>
        <x-shared.headline :$set />
    </x-shared.section>

    <x-shared.section width="wide">
        <div>
            <s:asset url="{{ $set->file }}">
                @if ($is_svg->raw())
                    <x-sets.image.svg :$set :$ratio :$url :$alt />
                @elseif ($is_image->raw())
                    <x-sets.image.image :$set :$ratio :$url :$alt />
                @elseif ($is_video->raw())
                    <x-sets.image.video :$set :$ratio :$url :$mime_type />
                @endif
            </s:asset>
        </div>
    </x-shared.section>
</div>
