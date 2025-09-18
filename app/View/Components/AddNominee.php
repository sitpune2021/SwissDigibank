<?php
namespace App\View\Components;

use Illuminate\View\Component;

class AddNominee extends Component
{
    public $rdAccount;
    public $member;
    public $submitText;
    public $backText;

    public function __construct($rdAccount = null, $member = null, $submitText = 'Save', $backText = 'Back')
    {
        $this->rdAccount = $rdAccount;
        $this->member = $member;
        $this->submitText = $submitText;
        $this->backText = $backText;
    }

    public function render()
    {
        return view('components.add-nominee');
    }
}
