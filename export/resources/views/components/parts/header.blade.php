@props(['settings'])

<header class="z-20 w-full h-20 px-8 py-4 bg-white dark:bg-base-950 fixed top-0 left-0 flex justify-start gap-12">
    <a href="/"><x-parts.logo :$settings /></a>

    <div class="hidden md:block">
        <x-parts.nav />
    </div>
</header>
