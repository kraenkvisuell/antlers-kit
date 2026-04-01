<?php

namespace App\Providers;

use App\Listeners\GeocodeSupplierOnSave;
use Illuminate\Support\Facades\Event;
use Illuminate\Support\ServiceProvider;
use Statamic\Events\EntrySaved;
use Statamic\Facades\Form;
use Statamic\Fieldtypes\Html;
use Statamic\Statamic;

class AppServiceProvider extends ServiceProvider
{
    public function register(): void
    {
        //
    }

    public function boot(): void
    {
        Event::listen(EntrySaved::class, GeocodeSupplierOnSave::class);

        Statamic::booted(function () {
            app('statamic.fieldtypes')->put('link', \App\Fieldtypes\Link::class);
        });

        Html::makeSelectableInForms();

        Form::appendConfigFields('*', 'Texte', [
            'success_message' => [
                'type' => 'bard',
                'display' => 'Nachricht bei erfolgreichem Versand',
                'buttons' => ['h3', 'h4', 'h5', 'bold', 'italic', 'unorderedlist', 'orderedlist', 'anchor'],
                'toolbar_mode' => 'floating',
                'fullscreen' => false,
                'link_collections' => ['pages'],
                'remove_empty_nodes' => 'trim',
            ],
            'submit_button_text' => [
                'type' => 'text',
                'display' => 'Text für Versenden-Button',
            ],
        ]);
    }
}
