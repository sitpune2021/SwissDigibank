<?php

return [
    [
        'label' => 'Promoter',
        'required' => true,
        'type' => 'select',
        'name' => 'promoter',
        'id' => 'promoterDropdown',
        'dynamic' => true,
        'objectKey' => 'promoter'
    ],
    [
        'label' => 'Allotment Date',
        'required' => true,
        'type' => 'text',
        'name' => 'allotment_date',
        'id' => 'date2',
        'html' => '<i class="las la-calendar absolute right-3 top-1/2 transform -translate-y-1/2 text-gray-500 pointer-events-none"></i>'
    ],
    [
        'label' => 'First Distinctive No.',
        'required' => true,
        'type' => 'text',
        'name' => 'first_share',
        'id' => 'first_share',
    ],
    [
        'label' => 'Last Distinctive No.',
        'required' => true,
        'type' => 'text',
        'name' => 'share_no',
        'id' => 'share_no',
    ],
    [
        'label' => 'Share Nominal Value',
        'required' => false,
        'type' => 'text',
        'name' => 'share_nominal',
        'id' => 'share_nominal',
        'readonly' => true,
        'default' => '10.0',
    ],
    [
        'label' => 'Total Share Held',
        'required' => false,
        'type' => 'text',
        'name' => 'total_share_held',
        'id' => 'total_share_held',
    ],
    [
        'label' => 'Total Share Value',
        'required' => true,
        'type' => 'text',
        'name' => 'total_share_value',
        'id' => 'total_share_value',
    ],
    [
        'label' => 'Certificate No',
        'required' => false,
        'type' => 'text',
        'name' => 'certificate_no',
        'id' => 'certificate_no',
    ],
    [
        'label' => 'Transaction Date',
        'required' => true,
        'type' => 'text',
        'name' => 'transaction_date',
        'id' => 'date',
        'html' => '<i class="las la-calendar absolute right-3 top-1/2 transform -translate-y-1/2 text-gray-500 pointer-events-none" style="top:30px"></i>'
    ],
    [
        'label' => 'Amount',
        'required' => true,
        'type' => 'text',
        'name' => 'amount',
        'id' => 'amount',
    ],
    [
        'label' => 'Remarks',
        'required' => false,
        'type' => 'text',
        'name' => 'remarks',
        'id' => 'remarks',
    ],
    [
        'label' => 'Pay Mode',
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
