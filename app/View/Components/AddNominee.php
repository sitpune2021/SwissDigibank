<?php

namespace App\View\Components;

use Illuminate\View\Component;

class AddNominee extends Component
{
    public $rdAccount;
    public $savingAccount;
    public $member;
    public $submitText;
    public $backText;
    public $type;
    public $isUpdate;

    public function __construct($rdAccount = null,  $type = 'rd',  $savingAccount = null, $member = null, $submitText = 'Save', $backText = 'Back', $isUpdate = false)
    {
        $this->rdAccount = $rdAccount;
        $this->savingAccount = $savingAccount;
        $this->type = $type;
        $this->member = $member;
        $this->submitText = $submitText;
        $this->backText = $backText;
        $this->isUpdate = $isUpdate;
    }

    public function render()
    {
        return view('components.add-nominee');
    }
}
