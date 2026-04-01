<?php

namespace App\View\Components\Shared;

use Illuminate\Contracts\View\View;
use Illuminate\View\Component;

class Hero extends Component
{
    public $page;
    public $bg;
    public $bgDesktop;

    public function __construct($page)
    {
        $this->page = $page;

        if (isset($page['hero'])) {
            $this->bg = $page['hero']['bg_medium']
                ?: $page['hero']['bg_medium_desktop'];

            $this->bgDesktop = $page['hero']['bg_medium_desktop']
                ?: $page['hero']['bg_medium'];
        }
    }

    public function render(): View
    {
        return view('components.shared.hero');
    }
}
