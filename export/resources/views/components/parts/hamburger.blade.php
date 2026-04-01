<button
    class="fixed block md:hidden top-[21px] right-7 w-10 h-10 p-1 z-50 pointer-events-auto"
    x-bind:disabled="hamburgerIsDisabled"
    x-on:click="toggleMenu"
>
    <div
        @class([
            'absolute top-[6px] left-1 rounded-xs h-[2px] w-[34px] transition-transform bg-black dark:bg-base-200',
        ])
        x-bind:class="{
            'translate-y-3': menuIsVisible,
            'rotate-45': hamburgerIsCross,
        }"
    ></div>

    <div
        @class([
            'absolute top-[18px] left-1 rounded-xs h-[2px] w-[34px] transition-opacity bg-black dark:bg-base-200',
        ])
        x-bind:class="{
            'opacity-100': !menuIsVisible,
            'opacity-0': menuIsVisible,
        }"
    >

    </div>

    <div
        @class([
            'absolute top-[30px] left-1 rounded-xs h-[2px] w-[34px] transition-transform bg-black dark:bg-base-200',
        ])
        x-bind:class="{
            '-translate-y-3': menuIsVisible,
            '-rotate-45': hamburgerIsCross,
        }"
    ></div>
</button>
