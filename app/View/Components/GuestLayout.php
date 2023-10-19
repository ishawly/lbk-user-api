<?php

namespace App\View\Components;

use Illuminate\Contracts\View\View;
use Illuminate\View\Component;

class GuestLayout extends Component
{
    public function render(): \Closure|string|View
    {
        return view('layouts.guest');
    }
}
