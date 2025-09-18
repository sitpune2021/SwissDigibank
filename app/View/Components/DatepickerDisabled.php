<?php

namespace App\View\Components;

use Closure;
use Illuminate\View\Component;
use Illuminate\Contracts\View\View;

class DatepickerDisabled extends Component
{
    public $label;
    public $name;
    public $value;
    public $inputId;
    public $wrapperId;

    public function __construct($label = null, $name = null, $value = null, $inputId = null, $wrapperId = null)
    {
        $this->label = $label;
        $this->name = $name;
        $this->value = $value;
        $this->inputId = $inputId;
        $this->wrapperId = $wrapperId;
    }

    public function render(): View|Closure|string
    {
        return view('components.datepicker-disabled');
    }
}
