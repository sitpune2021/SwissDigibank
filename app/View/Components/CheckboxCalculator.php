<?php

namespace App\View\Components;

use Closure;
use Illuminate\View\Component;
use Illuminate\Contracts\View\View;

class CheckboxCalculator extends Component
{
     public $id;
    public $name;
    public $label;
    public $sublabel;
    public function __construct($id, $name, $label, $sublabel = null)
    {
       $this->id = $id;
        $this->name = $name;
        $this->label = $label;
        $this->sublabel = $sublabel;
    }

    /**
     * Get the view / contents that represent the component.
     */
    public function render(): View|Closure|string
    {
        return view('components.checkbox-calculator');
    }
}
