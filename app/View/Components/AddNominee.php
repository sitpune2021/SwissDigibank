<?php

namespace App\View\Components;

use Illuminate\View\Component;

class AddNominee extends Component
{
    public $account;     // <-- single variable for all account types
    public $member;
    public $submitText;
    public $backText;
    public $type;
    public $isUpdate;

    public function __construct(
        $account = null,
        $member = null,
        $type = 'saving-account',
        $submitText = 'Save',
        $backText = 'Back',
        $isUpdate = false
    ) {
        $this->account = $account;
        $this->member = $member;
        $this->type = $type;
        $this->submitText = $submitText;
        $this->backText = $backText;
        $this->isUpdate = $isUpdate;
    }

    public function render()
    {
        return view('components.add-nominee');
    }
}
