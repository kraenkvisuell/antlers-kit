@props(['page', 'settings'])

@php
    $favicons = [
        'light' => [],
        'dark' => [],
        'apple-touch' => '',
    ];

    foreach (config('site.favicon_sizes') as $size) {
        $darkKey = 'favicon_dark_' . $size . 'x' . $size;
        $favicons['dark'][$size] = $settings->{$darkKey} ?: $page->{$darkKey};

        $lightKey = 'favicon_' . $size . 'x' . $size;
        $lightIcon = $settings->{$lightKey} ?: $page->{$lightKey};
        $favicons['light'][$size] = $lightIcon;

        if ($lightIcon && $size >= 192) {
            $favicons['apple-touch'] = $lightIcon;
        }
    }
@endphp

@foreach (config('site.favicon_sizes') as $size)
    @if ($favicons['light'][$size])
        <link rel="icon" href="{{ asset($favicons['light'][$size]) }}" sizes="{{ $size . 'x' . $size }}"
            media="(prefers-color-scheme: light)" />
    @endif

    @if ($favicons['dark'][$size])
        <link rel="icon" href="{{ asset($favicons['dark'][$size]) }}" sizes="{{ $size . 'x' . $size }}"
            media="(prefers-color-scheme: dark)" />
    @endif
@endforeach

@if ($favicons['apple-touch'])
    <link rel="apple-touch-icon" href="{{ asset($favicons['apple-touch']) }}" />
@endif
