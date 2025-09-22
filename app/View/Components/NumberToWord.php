<?php

namespace App\View\Components;

use Closure;
use Illuminate\View\Component;
use Illuminate\Contracts\View\View;

class NumberToWord extends Component
{
    /**
     * Create a new component instance.
     */
   public $for;
    public function __construct($for)
    {
        $this->for = $for; // this is the ID of the input field
    }

    /**
     * Get the view / contents that represent the component.
     */
    public function render(): View|Closure|string
    {
        return view('components.number-to-word');
    }
}
