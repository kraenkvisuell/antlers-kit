<x-layouts.default
    :$page
    :$settings
    :$site
>
    <div>
        @if ($page->has_hero)
            <x-shared.hero :$page />
        @endif

        <div @class([
            'flex flex-col gap-12',
            'pt-16' => $page->has_hero,
            'pt-28' => !$page->has_hero,
        ])>
            <x-shared.section>
                <div class="editor">
                    <h1>{{ $page->title }}</h1>
                </div>
            </x-shared.section>

            <div class="flex flex-col gap-24">
                @foreach ($page->content ?? [] as $set)
                    <x-dynamic-component
                        :component="'sets.' . $set->type"
                        :$set
                        :$page
                    />
                @endforeach
            </div>
        </div>
    </div>
</x-layouts.default>
