@props(['set', 'page'])

<x-shared.section width="wide">
    <div class="grid gap-9">
        <x-shared.headline :$set />

        <x-shared.cards>
            @foreach ($set->cards as $card)
                <x-shared.card>
                    <div class="p-3 flex flex-col gap-4">
                        <div class="relative overflow-visible">
                            <s:asset url="{{ $card->file }}">
                                @if ($is_svg->raw())
                                    <x-sets.card.svg
                                        :$card
                                        :$ratio
                                        :$url
                                        :$alt
                                    />
                                @elseif ($is_image->raw())
                                    <x-sets.card.image
                                        :$card
                                        :$ratio
                                        :$url
                                        :$alt
                                    />
                                @elseif ($is_video->raw())
                                    <x-sets.card.video
                                        :$card
                                        :$ratio
                                        :$url
                                        :$mime_type
                                    />
                                @endif
                            </s:asset>

                        </div>
                        @if ($card->text)
                            <div class="editor text-sm">
                                {!! transformText($card->text) !!}
                            </div>
                        @endif

                        @if ($card->buttons)
                            <div>
                                <x-shared.buttons :buttons="$card->buttons" />
                            </div>
                        @endif
                    </div>
                </x-shared.card>
            @endforeach
        </x-shared.cards>
    </div>
</x-shared.section>
