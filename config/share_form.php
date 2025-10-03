<?php

return [
    [
        'label' => 'PROMOTER',
        'required' => true,
        'type' => 'select',
        'name' => 'promotor_id',
        'id' => 'promotor_id',
        'dynamic' => true,
        'options_key' => 'promoter'
    ],
    [
        'label' => 'ALLOTMENT DATE',
        'required' => true,
        'type' => 'text',
        'name' => 'allotment_date',
        'id' => 'date2',
        'html' => '<i class="las la-calendar absolute right-3 top-1/2 transform -translate-y-1/2 text-gray-500 pointer-events-none"></i>'
    ],
    [
        'label' => 'FIRST DISTINCTIVE NO.',
        'required' => true,
        'type' => 'text',
        'name' => 'first_share',
        'id' => 'first_share',
    ],
    [
        'label' => 'LAST DISTINCTIVE NO.',
        'required' => true,
        'type' => 'text',
        'name' => 'share_no',
        'id' => 'share_no',
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
        'id' => 'date',
        'html' => '<i class="las la-calendar absolute right-3 top-1/2 transform -translate-y-1/2 text-gray-500 pointer-events-none" style="top:30px"></i>'
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
            'saving_ac' => 'Saving Ac.'
        ]
    ],
];
