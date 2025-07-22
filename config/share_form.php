<?php
return [
    [
        'label' => 'Promoter',
        'required' => true,
        'type' => 'select',
        'name' => 'promoter_id',
        'id' => 'promoter_id',
        'dynamic' => true,
        'objectKey' => 'promoter'
    ],
    [
        'label' => 'Allotment Date',
        'required' => true,
        'type' => 'text',
        'name' => 'allotment_date',
        'id' => 'date',
        'html' => '<i class="las la-calendar absolute ltr:right-4 rtl:left-4 top-1/2 -translate-y-1/2 cursor-pointer"></i>'
    ],
    [
        'label' => 'First Distinctive No',
        'required' => true,
        'type' => 'text',
        'name' => 'first_share',
        'id' => 'first_share',
    ],
    [
        'label' => 'Pay Mode',
        'required' => true,
        'type' => 'radio',
        'name' => 'pay_mode',
        'id' => 'pay_mode',
        'option' => [
            'cash' => 'Cash',
            'online_tr' => 'Online Tr.',
        ]
    ]

];