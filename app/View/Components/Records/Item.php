<?php

namespace App\View\Components\Records;

use App\Models\Record;
use Illuminate\Contracts\View\View;
use Illuminate\View\Component;

class Item extends Component
{
    public function __construct(
        public Record $record
    ) {
    }

    /**
     * Get the view / contents that represent the component.
     */
    public function render(): View|\Closure|string
    {
        return view('components.records.item');
    }
}
