<?php

return [
    'basic_details' => [
          [
            'label' => 'Transferor',
            'name' => 'transferor',
            'id' => 'transferor',
            'type' => 'text',
            'required' => true,
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
            'required' => true
        ],
        [
            'label' => 'Shares',
            'name' => 'shares',
            'id' => 'shares',
            'type' => 'number',
            'required' => true
        ],
        [
            'label' => 'Face Value',
            'name' => 'face_value',
            'id' => 'face_value',
            'type' => 'number',
            'required' => false
        ],
        [
            'label' => 'Total Consideration',
            'name' => 'total_consideration',
            'id' => 'total_consideration',
            'type' => 'number',
            'required' => false
        ],
    ],
];

