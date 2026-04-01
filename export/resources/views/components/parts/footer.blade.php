@props(['settings'])

<footer class="w-full px-8 py-4 bg-base-600 text-white flex justify-between gap-12">
    <div class="flex flex-col sm:flex-row justify-start gap-24">
        <nav>
            <ul class="nav font-headline">
                <s:nav:main_navigation scope="navItem">
                    <li class="relative group">
                        @if (@$navItem['is_entry'])
                            <a
                                wire:navigate.hover
                                href="{{ $navItem['url'] }}"
                                @class([
                                    'relative hover:underline block py-1',
                                    'current' => $navItem['is_current'] || $navItem['is_parent'],
                                ])
                            >
                                {{ $navItem['title'] }}
                            </a>
                        @else
                            <span @class([
                                'relative pointer-default block py-1',
                                'current' => $navItem['is_current'] || $navItem['is_parent'],
                            ])>
                                {{ $navItem['title'] }}
                            </span>
                        @endif
                        @if (count($navItem['children']) > 0)
                            <ul>
                                @foreach ($navItem['children'] as $child)
                                    <li>
                                        <a
                                            wire:navigate.hover
                                            href="{{ $child['url'] }}"
                                            @class([
                                                'block text-xs py-1 pl-3 hover:underline whitespace-nowrap',
                                                'current' => $child['is_current'],
                                            ])
                                        >
                                            {{ $child['title'] }}
                                        </a>
                                    </li>
                                @endforeach
                            </ul>
                        @endif
                    </li>
                </s:nav:main_navigation>
            </ul>
        </nav>

        <nav>
            <ul class="nav font-headline text-xs">
                <s:nav:secondary_navigation scope="navItem">
                    <li>
                        @if (@$navItem['is_entry'])
                            <a
                                wire:navigate.hover
                                href="{{ $navItem['url'] }}"
                                @class([
                                    'hover:underline block py-1',
                                    'current' => $navItem['is_current'] || $navItem['is_parent'],
                                ])
                            >
                                {{ $navItem['title'] }}
                            </a>
                        @else
                            <span @class([
                                'relative pointer-default block py-1',
                                'current' => $navItem['is_current'] || $navItem['is_parent'],
                            ])>
                                {{ $navItem['title'] }}
                            </span>
                        @endif
                    </li>
                </s:nav:secondary_navigation>

                <li>

                    <a
                        href="/sitemap"
                        @class(['hover:underline block py-1'])
                    >
                        Sitemap
                    </a>
            </ul>
        </nav>
    </div>

    <div>
        <x-parts.social-media :$settings />
    </div>
</footer>
