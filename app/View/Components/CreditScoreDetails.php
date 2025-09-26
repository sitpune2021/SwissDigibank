<?php

namespace App\View\Components;

use Closure;
use Illuminate\View\Component;
use Illuminate\Contracts\View\View;

class CreditScoreDetails extends Component
{
    public $scores;

    public function __construct($scores = [])
    {
        $this->scores = $scores;
    }

    /**
     * Get the view / contents that represent the component.
     */
    public function render(): View|Closure|string
    {
        return view('components.credit-score-details');
    }
}
