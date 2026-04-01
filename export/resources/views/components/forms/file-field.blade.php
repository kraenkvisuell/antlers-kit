@props([
    'required' => false,
    'label' => '',
    'live' => false,
    'multiple' => false,
    'inscription' => '',
    'help' => '',
    'accept' => null,
    'id' => '',
    'clearOnEvent' => '',
    'name' => $attributes->whereStartsWith('wire:model')->first(),
])

@php
    $id = $id ?: 'id_' . Str::slug(Str::random(6));

    $cssClasses = [
        'w-full py-2 px-3 rounded-sm bg-white/90 text-anthrazit font-headline text-center',
        'outline-dashed outline-red-500' => $errors->has($name),
    ];
@endphp

<x-forms.field-wrapper :$name>
    @if ($label)
        <x-forms.label
            :$required
            :$id
        >{{ $label }}</x-forms.label>
    @endif

    <div
        class="grid gap-3"
        x-data="{
            file: {},
            thumbnail: '',
            updateFile(newFiles) {
                this.thumbnail = ''
                this.icon = ''
                if (Object.values(newFiles).length) {
                    this.file = Object.values(newFiles)[0]
        
                    if (this.file.type.indexOf('pdf') > -1) {
                        this.icon = 'fa-file-pdf'
                    }
        
                    if (this.file.type.indexOf('zip') > -1) {
                        this.icon = 'fa-file-zip'
                    }
        
                    if (this.file.type.startsWith('image/') && this.file.size < 10000000) {
                        const reader = new FileReader();
        
                        reader.addEventListener('load', () => this.thumbnail = reader.result, false);
        
                        reader.readAsDataURL(this.file)
                    }
                }
            },
            removeFile() {
                this.file = {}
                this.thumbnail = ''
                this.$refs.fileinput.value = null;
            }
        }"
    >
        <div class="relative">
            <div @class($cssClasses)>{{ $inscription ?: __('Datei auswählen') }}</div>

            <input
                x-ref="fileinput"
                x-on:change="updateFile($event.target.files)"
                @if ($clearOnEvent) x-on:{{ $clearOnEvent }}.window="removeFile" @endif
                @if ($accept) accept="{{ $accept }}" @endif
                {{ $attributes }}
                type="file"
                class="absolute inset-0 opacity-0 bg-warning"
            />

            @if ($help)
                <x-forms.field-help :text="$help" />
            @endif
        </div>

        <template x-if="file.name">
            <div class="border rounded-sm px-2 py-2 flex justify-between items-center gap-2">
                <div class="flex gap-2">
                    <template x-if="thumbnail">
                        <div class="w-24 h-24 p-2 bg-white dark:bg-base-900 rounded-xs inset-shadow-xs">
                            <img
                                x-bind:src="thumbnail"
                                class="w-full h-full object-contain"
                            />
                        </div>
                    </template>

                    <template x-if="icon">
                        <div class="">
                            <i
                                x-bind:class="[
                                    'fa-solid text-xl',
                                    icon,
                                ]"></i>
                        </div>
                    </template>

                    <div class="">
                        <span x-text="file.name">
                        </span>

                        (<span
                            class="text-xs"
                            x-text="filesize(file.size, {locale: 'de', round: 1})"
                        >
                        </span>)
                    </div>
                </div>

                <div class="flex justify-end pr-1 pt-1 z-10">
                    <x-forms.remove-button x-on:click="removeFile()" />
                </div>
            </div>

        </template>
    </div>

    @if ($errors->has($name))
        <x-forms.field-error :error="$errors->first($name)" />
    @endif
</x-forms.field-wrapper>
