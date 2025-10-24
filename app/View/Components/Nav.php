<?php

namespace App\View\Components;

use Closure;
use Illuminate\Contracts\View\View;
use Illuminate\View\Component;
use Illuminate\Support\Facades\Route;

class Nav extends Component
{

    public $items;
    public $active;

    public function __construct($context = "side")
    {
        $this->items = config('nav');
        $this->active = Route::currentRouteName();
    }

    public function render(): View|Closure|string
    {
        return view('components.nav');
    }
}
