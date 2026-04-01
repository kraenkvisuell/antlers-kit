@php
    use Statamic\Facades\Entry;
    $page = Entry::query()->make([
        'browser_title' => 'Sitemap',
    ]);
@endphp

<x-layouts.default
    :$settings
    :$site
    :$page
>
    <div class="pt-28">
        <x-shared.section>
            <div class="editor">
                <h1>Sitemap</h1>
            </div>

            <nav class="editor">
                <ul>
                    <statamic:collection from="pages">
                        <li>
                            <a href="{{ $url }}">{{ $title }}</a>
                        </li>
                    </statamic:collection>
                </ul>
            </nav>
        </x-shared.section>
    </div>
</x-layouts.default>
