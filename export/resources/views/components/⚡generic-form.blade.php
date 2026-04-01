<?php

use Illuminate\Support\Str;
use Livewire\Component;
use Statamic\Events\FormSubmitted;
use Statamic\Facades\Site;
use Statamic\Forms\SendEmails;
use Statamic\Fieldtypes\Bard\Augmentor;

new class extends Component {
    public $form;
    public $fields = [];
    public $isSubmitted = false;
    public $successMessage = '';

    public function mount()
    {
        foreach ($this->form['fields'] as $key => $field) {
            $this->fields[$key] = $field['default'] ?? '';
        }
    }

    public function rules()
    {
        $rules = [];

        foreach ($this->form['fields'] as $key => $field) {
            $rules['fields.' . $key] = $field['validate'] ?? [];
        }

        return $rules;
    }

    public function submit()
    {
        $validated = $this->validate();

        $form = new \Statamic\Forms\FormRepository()->find($this->form['handle']);

        $this->successMessage = new Augmentor(new \Statamic\Fieldtypes\Bard())->convertToHtml($form->success_message);
        $this->successMessage = trim(strip_tags($this->successMessage)) ? $this->successMessage : 'Vielen Dank für Ihre Nachricht';

        $fields = $form->blueprint()->fields();

        $submission = $form->makeSubmission();

        $submission->data($fields->addValues($validated['fields'])->process()->values());
        $submission->save();

        FormSubmitted::dispatch($submission);

        SendEmails::dispatch($submission, Site::default());

        $this->isSubmitted = true;
    }
};
?>

<div x-data="{
    init() {
        Livewire.hook('commit', ({ succeed }) => {
            succeed(() => {
                this.$nextTick(() => {
                    const firstErrorMessage = document.querySelector('.error-message')

                    if (firstErrorMessage !== null) {
                        firstErrorMessage.scrollIntoView({ block: 'center', inline: 'center', behavior: 'smooth', })
                    }

                    const successMessage = document.querySelector('.success-message')

                    if (successMessage !== null) {
                        successMessage.scrollIntoView({ block: 'center', inline: 'center', behavior: 'smooth', })
                    }
                })
            })
        })
    }
}">
    @if (!$this->isSubmitted)
        <form class="flex flex-col gap-12">
            <div class="grid gap-y-4 gap-x-6 grid-cols-12">
                @foreach ($this->form['fields'] ?? [] as $field)
                    @if ($field['type'] === 'spacer')
                        <div class="col-span-full h-12">

                        </div>
                    @else
                        @php
                            $element = 'input-field';
                            $inputType = $field['input_type'] ?? 'text';

                            if ($field['type'] === 'radio') {
                                $element = 'radios-field';
                            }

                            if ($field['type'] === 'textarea') {
                                $inputType = 'textarea';
                            }

                            $required = false;
                            if (isset($field['validate']) && is_array($field['validate'])) {
                                $required = in_array('required', $field['validate']);
                            }
                        @endphp

                        <div @class([
                            'col-span-full',
                            'md:col-span-9' => $field['width'] === 75,
                            'md:col-span-8' => $field['width'] === 66,
                            'md:col-span-6' => $field['width'] === 50,
                            'md:col-span-4' => $field['width'] === 33,
                            'md:col-span-3' => $field['width'] === 25,
                        ])>
                            <x-dynamic-component
                                :component="'forms.' . $element"
                                :wire:model="'fields.'.$field['handle']"
                                :label="$field['display'] ?? null"
                                :type="$inputType"
                                :options="$field['options'] ?? ''"
                                :placeholder="$field['placeholder'] ?? ''"
                                :inline="$field['inline'] ?? false"
                                :required="$required"
                            />
                        </div>
                    @endif
                @endforeach
            </div>

            <div class="w-full flex justify-center">

                <button
                    type="button"
                    wire:click="submit"
                >
                    <div
                        class="
                        cursor-pointer
                        block font-headline inline-flex items-center justify-center gap-3 px-20
                        pt-3.5 pb-3
                        bg-gradient-to-r from-base-400/90 via-base-200/90 to-base-400/90
                        hover:text-white hover:bg-base-800 hover:bg-none
                    ">
                        Absenden
                    </div>
                </button>

            </div>
        </form>
    @else
        <div class="success-message editor text-center">
            {!! $this->successMessage !!}
        </div>
    @endif
</div>
