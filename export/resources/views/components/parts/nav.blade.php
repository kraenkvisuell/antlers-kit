@props(['page'])

<nav class="h-full flex items-center">
    <ul class="nav font-headline flex">
        <s:nav:main_navigation scope="navItem">
            <li class="relative group px-4">
                @if (@$navItem['is_entry'])
                    <a
                        wire:navigate.hover
                        href="{{ $navItem['url'] }}"
                        @class([
                            'relative z-20 hover:underline',
                            'current' => $navItem['is_current'] || $navItem['is_parent'],
                        ])
                    >
                        {{ $navItem['title'] }}
                    </a>
                @else
                    <span @class([
                        'relative z-20 pointer-default',
                        'current' => $navItem['is_current'] || $navItem['is_parent'],
                    ])>
                        {{ $navItem['title'] }}
                    </span>
                @endif

                @if (count($navItem['children']) > 0)
                    <div
                        class="z-10 min-w-full absolute top-0 left-0 px-4 pt-8 pb-4 bg-white dark:bg-base-950 
                            opacity-0  group-hover:opacity-100 transition-opacity pointer-events-none 
                            group-hover:pointer-events-auto leading-1">
                        <ul>
                            @foreach ($navItem['children'] as $child)
                                <li>
                                    <a
                                        wire:navigate.hover
                                        href="{{ $child['url'] }}"
                                        @class([
                                            'block text-sm py-1 hover:underline whitespace-nowrap',
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
