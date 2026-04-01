@props(['settings'])

<div class="text-[30px] flex items-center gap-4">
    @php
        $knownSites = collect([
            'facebook' => 'facebook-f',
            'instagram' => 'instagram',
            'linkedin' => 'linkedin-in',
            'threads' => 'threads',
            'tiktok' => 'tiktok',
            'twitch' => 'twitch',
            'twitter' => 'twitter',
            'x' => 'x-twitter',
            'youtube' => 'youtube',
        ]);
    @endphp

    @foreach ($settings->social_media_links as $link)
        @php
            $icon = $knownSites->firstWhere(fn($site, $siteKey) => stristr($link->link . '.', $siteKey));
        @endphp

        <a
            href="{{ ensureUrl($link->link) }}"
            title="{{ $link->link_text ?: $icon }}"
            target="_blank"
        >
            @if ($icon)
                <i class="fa-brands fa-{{ $icon }}"></i>
            @endif
        </a>
    @endforeach
</div>
