<?php

return [
    'basic_details' => [
          [
            'label' => 'Transferor',
            'name' => 'transferor',
            'id' => 'transferor',
            'type' => 'text',
            'required' => true,
            'dynamic' => true,
        ],
        [
        'label' => 'Member',
        'name' => 'member_id',
        'id' => 'member',
        'type' => 'select',
        'required' => false,
        'dynamic' => true,
        'options_key' => 'member',
        'create' => true
    ],
        [
            'label' => 'Business Type',
            'name' => 'business_type',
            'id' => 'business_type',
            'type' => 'select',
            'required' => true,
            'options' => [
                'fd/mis'=> 'FD/MIS' ,
              'rd/dd'=>  'RD/DD'  ,
               'saving' =>'Saving'  ,
               'loan' => 'Loan' ,
            ],
        ],
        [
            'label' => 'Transfer Date',
            'name' => 'transfer_date',
            'id' => 'date',
            'type' => 'text',
            'required' => true,
            'default' => \Carbon\Carbon::now()->format('Y-m-d')  // ✅ आजची तारीख
        ],

        [
            'label' => 'Shares',
            'name' => 'shares',
            'id' => 'shares',
            'type' => 'text',
            'required' => true,  
            'readonly' => true,
            'default' => '100',

        ],
        [
            'label' => 'Face Value',
            'name' => 'nominal_value',
            'id' => 'face_value',
            'type' => 'text',
            'readonly' => true,
            'default' => '10.0',
            'required' => false,
        ],

        [
            'label' => 'Total Consideration',
            'name' => 'total_consideration',
            'id' => 'total_consideration',
            'required' => false,
            'type' => 'text',
            'readonly' => true,
            'default' => '1000',
        ],
    ],
];

