<div
    class="relative landscape:h-96 overflow-hidden"
    x-ref="hero"
>
    <div class="landscape:hidden w-full h-68">
        <s:asset url="{{ $bg }}">
            @if ($is_image->raw())
                <x-shared.hero.image
                    :file="$bg"
                    :$alt
                />
            @elseif ($is_video->raw())
                <x-shared.hero.video
                    :$url
                    :$mime_type
                    :$alt
                />
            @endif
        </s:asset>
    </div>

    <div class="portrait:hidden w-full h-84">
        <s:asset url="{{ $bgDesktop }}">
            @if ($is_image->raw())
                <x-shared.hero.image
                    :file="$bgDesktop"
                    :$alt
                />
            @elseif ($is_video->raw())
                <x-shared.hero.video
                    :$url
                    :$mime_type
                />
            @endif
        </s:asset>
    </div>

</div>
