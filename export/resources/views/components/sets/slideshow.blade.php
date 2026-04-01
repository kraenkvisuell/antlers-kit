@props(['set', 'page'])

@php
    $id = Str::random(8);

    $aspectRatioClass = 'aspect-1/1';

    if ($set->force_ratio) {
        $ratioArr = explode(':', $set->ratio);
        $imgRatio = intval($ratioArr[0]) / intval($ratioArr[1]);
        $aspectRatioClass = 'aspect-' . implode('/', $ratioArr);
    } else {
        $imgRatio = $ratio->raw();
    }
@endphp
<x-shared.section width="wide">
    <div class="flex flex-col gap-9">
        <x-shared.headline :$set />

        <div class="relative">
            <div
                class="swiper"
                id="swiper_{{ $id }}"
            >
                <div class="swiper-wrapper">
                    @foreach ($set->slides as $slide)
                        <div class="swiper-slide">
                            <s:asset url="{{ $slide->file }}">
                                @if ($is_svg->raw())
                                    <x-sets.slideshow.svg
                                        :$slide
                                        :$aspectRatioClass
                                        :$imgRatio
                                        :$url
                                        :$alt
                                    />
                                @elseif ($is_image->raw())
                                    <x-sets.slideshow.image
                                        :$slide
                                        :$aspectRatioClass
                                        :$imgRatio
                                        :$url
                                        :$alt
                                    />
                                @elseif ($is_video->raw())
                                    <x-sets.slideshow.video
                                        :$aspectRatioClass
                                        :$url
                                        :$mime_type
                                    />
                                @endif
                            </s:asset>

                            <div class="mt-1">
                                <x-sets.image.captions :set="$slide" />
                            </div>
                        </div>
                    @endforeach
                </div>

                <x-slideshow.arrow direction="prev" />
                <x-slideshow.arrow direction="next" />
            </div>
        </div>
    </div>

    <script>
        const swiper = new Swiper('#swiper_{{ $id }}', {
            loop: false,
            width: null,

            navigation: {
                nextEl: '.slide-next',
                prevEl: '.slide-prev',
            },
        });
    </script>
</x-shared.section>
