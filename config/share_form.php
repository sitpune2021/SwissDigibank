<?php

return [
    // 🔹 Basic Shareholding Info
    [
        'label' => 'PROMOTER',
        'required' => true,
        'type' => 'select',
        'name' => 'promotor_id',
        'id' => 'promotor_id',
        'dynamic' => true,
        'options_key' => 'promoter',
    ],
    [
        'label' => 'ALLOTMENT DATE',
        'required' => true,
        'type' => 'text',
        'name' => 'allotment_date',
        'id' => 'date',
        'html' => '<i class="las la-calendar absolute right-3 top-1/2 transform -translate-y-1/2 text-gray-500 pointer-events-none"></i>',
    ],
    [
        'label' => 'FIRST DISTINCTIVE NO.',
        'required' => true,
        'type' => 'text',
        'name' => 'first_share',
        'id' => 'first_share',
        'min' => 1,
        'max' => 50000,

    ],
    [
        'label' => 'LAST DISTINCTIVE NO.',
        'required' => true,
        'type' => 'text',
        'name' => 'share_no',
        'id' => 'share_no',
        'min' => 1,
        'max' => 50000,

    ],
    [
        'label' => 'SHARE NOMINAL VALUE',
        'required' => false,
        'type' => 'text',
        'name' => 'nominal_value',
        'id' => 'share_nominal',
        'readonly' => true,
        'default' => '100.0',
    ],
    [
        'label' => 'TOTAL SHARES HELD',
        'required' => false,
        'type' => 'text',
        'name' => 'total_share_held',
        'id' => 'total_share_held',
    ],
    [
        'label' => 'TOTAL SHARES VALUE',
        'required' => true,
        'type' => 'text',
        'name' => 'total_share_value',
        'id' => 'total_share_value',
    ],
    [
        'label' => 'CERTIFICATE NO.',
        'required' => false,
        'type' => 'text',
        'name' => 'certificate_no',
        'id' => 'certificate_no',
    ],
    [
        'label' => 'TRANSACTION DATE',
        'required' => true,
        'type' => 'text',
        'name' => 'transaction_date',
        'id' => 'date5',
        'html' => '<i class="las la-calendar absolute right-3 top-1/2 transform -translate-y-1/2 text-gray-500 pointer-events-none"></i>',
    ],
    [
        'label' => 'AMOUNT',
        'required' => true,
        'type' => 'text',
        'name' => 'amount',
        'id' => 'amount',
    ],
    [
        'label' => 'REMARKS',
        'required' => false,
        'type' => 'text',
        'name' => 'remarks',
        'id' => 'remarks',
    ],

    // 🔹 PAY MODE
    [
        'label' => 'PAY MODE',
        'required' => true,
        'type' => 'radio',
        'name' => 'pay_mode',
        'id' => 'pay_mode',
        'options' => [
            'cash' => 'Cash',
            'online_tr' => 'Online Tr.',
            'cheque' => 'Cheque',
            'saving_ac' => 'Saving Ac.',
        ],
    ],

    // 🔹 Online Transfer Fields
    'online_tr' => [
        [
            'label' => 'TRANSFER DATE',
            'name' => 'transfer_date',
            'id' => 'date6',
            'type' => 'text',
            'required' => true,
        ],

        [
            'label' => 'UTR / TRANSACTION NO.',
            'name' => 'utr_no',
            'id' => 'utr_no',
            'type' => 'text',
            'required' => true,
        ],
        [
            'label' => 'TRANSFER MODE',
            'name' => 'transfer_mode',
            'id' => 'transfer_mode',
            'type' => 'select',
            'options' => [
                'IMPS' => 'IMPS',
                'VPA' => 'VPA',
                'NEFT/RTGS' => 'NEFT/RTGS',
            ],
            'required' => true,
        ],
    ],

    // 🔹 Cheque Fields
    'cheque' => [
        [
            'label' => 'BANK NAME',
            'name' => 'bank_name',
            'id' => 'cheque_bank_name',
            'type' => 'text',
            'required' => true,
        ],
        [
            'label' => 'CHEQUE NO.',
            'name' => 'cheque_no',
            'id' => 'cheque_no',
            'type' => 'text',
            'required' => true,
        ],
        [
            'label' => 'CHEQUE DATE',
            'name' => 'cheque_date',
            'id' => 'date7',
            'type' => 'text',
            'required' => true,
        ],
    ],

    // 🔹 Saving Account Fields
    'saving_ac' => [
        [
            'label' => 'SELECT SAVING ACCOUNT',
            'name' => 'saving_account_id',
            'id' => 'saving_account_id',
            'type' => 'select',
            'options_key' => 'savingAccounts', // pass from controller
            'required' => true,
        ],

    ],
];
