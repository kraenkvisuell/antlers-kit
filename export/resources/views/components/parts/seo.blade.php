@props(['page', 'settings'])

@php
    $metaDescription = $page->meta_description ?: $settings->meta_description;
    $browserTitle = $page->browser_title ?: $page->title;
    $ogImage = $page->og_image ?: $settings->og_image;
    $twitterImage = $page->twitter_image ?: $settings->twitter_image;
@endphp

<title>{{ $browserTitle }} | {{ $settings->website_title }}</title>

@if ($metaDescription)
    <meta
        name="description"
        content="{{ $metaDescription }}"
    />
@endif

@if ($ogImage)
    <meta
        property="og:image"
        content="{{ cdnImage($ogImage) }}"
    />
@endif

@if ($twitterImage)
    <meta
        name="twitter:card"
        content="summary_large_image"
    >
    <meta
        name="twitter:image"
        content="{{ cdnImage($twitterImage) }}"
    >
@endif
