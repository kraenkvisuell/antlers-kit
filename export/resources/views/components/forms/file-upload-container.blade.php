@props(['oldFile', 'name', 'help' => '', 'model' => $attributes->whereStartsWith('wire:model')->first()])

<div class="grid gap-3">
    @if ($oldFile['file'])
        <div class="w-full px-4 pt-4 pb-2 bg-base-100 dark:bg-base-900 rounded-xs inset-shadow-xs grid gap-2">
            <div class="w-full h-32">
                <img
                    src="{{ $oldFile['file']->publicUrl() }}"
                    class="w-full h-full object-contain"
                />
            </div>

            <div class="flex justify-center">
                <button
                    type="button"
                    class="underline text-sm dark:text-base-100/85"
                    wire:click="deleteUploadFile('{{ $model }}')"
                >
                    {{ __('Entfernen') }}
                </button>
            </div>
        </div>
    @endif

    <x-forms.file-field
        {{ $attributes }}
        clearOnEvent="account-updated"
        :$help
        :inscription="$oldFile['file'] ? __('Neue Datei auswählen') : __('Datei auswählen')"
        accept="image/*"
    />
</div>
