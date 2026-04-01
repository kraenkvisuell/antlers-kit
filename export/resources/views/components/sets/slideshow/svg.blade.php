@props(['aspectRatioClass', 'imgRatio', 'url', 'alt', 'card'])

<div class="flex justify-center">
    <div class="grid gap-1 w-full">
        <div class="{{ $aspectRatioClass }}">
            <img
                src="{{ $url }}"
                alt="{{ $alt }}"
                class="w-full h-full object-contain"
            />
        </div>
    </div>
</div>
