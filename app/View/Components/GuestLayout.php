<?php

namespace App\View\Components;

use Illuminate\Contracts\View\View;
use Illuminate\View\Component;

class GuestLayout extends Component
{
    public function render(): View|\Closure|string
    {
        return view('layouts.guest');
    }
}
