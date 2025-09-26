<?php

namespace App\View\Components;

use Closure;
use Illuminate\View\Component;
use Illuminate\Contracts\View\View;

class Paymode extends Component
{
    public $amount;
    public $banks;
    public $showSaving;
    public $id;
    public $readonly;
    public $amountClass;

    public $bgColor;
    public $hiddenheading;
    public $hiddensubhead; 
    public function __construct($amount = null, $banks = [], $showSaving = false, $id = null, $readonly = false ,$amountClass=true ,$bgColor=true ,$hiddenheading = true ,$hiddensubhead  = true)
    {
        $this->amount = $amount;
        $this->banks = $banks;
        $this->showSaving = $showSaving;
        $this->id = $id;
        $this->readonly = $readonly;
        $this->amountClass =$amountClass;
        $this->bgColor=$bgColor;
        $this->hiddenheading =$hiddenheading;
        $this->hiddensubhead =$hiddensubhead;
    }

    /**
     * Get the view / contents that represent the component.
     */
    public function render(): View|Closure|string
    {
        return view('components.paymode');
    }
}
