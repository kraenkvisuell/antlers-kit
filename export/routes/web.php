<?php

use Statamic\Facades\Entry;
use Illuminate\Support\Facades\Route;

Route::statamic('sitemap', 'sitemap')->name('sitemap');

Route::get('/sitemap.xml', function () {
    return response()->view('xml.sitemap', [
        'pages' => Entry::query()->where('collection', 'pages')->get(),
    ])->header('Content-Type', 'text/xml');
})->name('xml.sitemap');
