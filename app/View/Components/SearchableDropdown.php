<?php

namespace App\View\Components;

use Closure;
use Illuminate\View\Component;
use Illuminate\Contracts\View\View;

class SearchableDropdown extends Component
{
    public $items;
    public $label;
    public $name;
    public $displayField;
    public $valueField;
    public $event;
    public $selected; 

    public function __construct(
        $items = [],
        $label = "Select",
        $name = "dropdown",
        $displayField = "name",
        $valueField = "id",
        $event = null,
        $selected = null
    ) {
        $this->items = $items;
        $this->label = $label;
        $this->name = $name;
        $this->displayField = $displayField;
        $this->valueField = $valueField;
        $this->event = $event;
        $this->selected = $selected;

        // dd($event);

    }
    public function render()
    {
        return view('components.searchable-dropdown');
    }
}
