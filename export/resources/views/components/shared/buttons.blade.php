@props(['buttons'])

<div>
    @foreach ($buttons as $button)
        <div class="inline-block mr-2 mb-2">
            <x-forms.button
                :isLink="true"
                :href="$button->link"
                :target="is_string($button->link->value()) ? '_blank' : '_self'"
            >
                {{ $button->link_text }}
            </x-forms.button>
        </div>
    @endforeach
</div>
