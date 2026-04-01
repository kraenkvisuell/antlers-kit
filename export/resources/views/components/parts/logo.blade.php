@props(['settings'])

<picture>
    <source srcset="{{ cdnImage($settings->main_logo_dark, ['height' => 100]) }}" media="(prefers-color-scheme: dark)" />
    <source srcset="{{ cdnImage($settings->main_logo, ['height' => 100]) }}" media="(prefers-color-scheme: light)" />

    <img src="{{ cdnImage($settings->main_logo, ['height' => 100]) }}" class="h-full"
        alt="{{ $settings->website_title }} Logo" />
</picture>
