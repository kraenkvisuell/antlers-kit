@props(['settings'])

<div class="fixed md:hidden inset-0 overflow-hidden pointer-events-none z-10">
    <div
        class="absolute w-full h-full transition-transform"
        x-cloak
        x-bind:class="{
            'translate-x-full': !menuIsVisible,
            'translate-x-0': menuIsVisible,
        }"
    >
        <div class="absolute top-0 right-0 bg-white dark:bg-base-950 w-full h-full">
            <div class="relative z-0 w-full h-full overflow-y-scroll overscroll-contain">
                <nav class="pt-32 pl-9 pointer-events-auto">
                    <ul class="nav font-headline">
                        <s:nav:main_navigation scope="navItem">
                            <li class="relative group px-4 text-xl">
                                @if (@$navItem['is_entry'])
                                    <a
                                        wire:navigate.hover
                                        href="{{ $navItem['url'] }}"
                                        @class([
                                            'block relative z-20 hover:underline py-1',
                                            'current' => $navItem['is_current'] || $navItem['is_parent'],
                                        ])
                                    >
                                        {{ $navItem['title'] }}
                                    </a>
                                @else
                                    <span @class([
                                        'block relative z-20 pointer-default py-1',
                                        'current' => $navItem['is_current'] || $navItem['is_parent'],
                                    ])>
                                        {{ $navItem['title'] }}
                                    </span>
                                @endif

                                @if (count($navItem['children']) > 0)
                                    <div class="pl-4 pb-3">
                                        <ul>
                                            @foreach ($navItem['children'] as $child)
                                                <li>
                                                    <a
                                                        wire:navigate.hover
                                                        href="{{ $child['url'] }}"
                                                        @class([
                                                            'block text-base py-1 hover:underline whitespace-nowrap',
                                                            'current' => $child['is_current'],
                                                        ])
                                                    >
                                                        {{ $child['title'] }}
                                                    </a>
                                                </li>
                                            @endforeach
                                        </ul>
                                    </div>
                                @endif
                            </li>
                        </s:nav:main_navigation>
                    </ul>
                </nav>
            </div>
        </div>
    </div>
</div>
