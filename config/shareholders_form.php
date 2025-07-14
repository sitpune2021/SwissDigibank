<?php

return [
    [
        'label' => 'Member',
        'name' => 'member',
        'id' => 'member',
        'type' => 'text',
        'required' => true,
    ],
    [
        'label' => 'Business Type',
        'name' => 'business_type',
        'id' => 'business_type',
        'type' => 'select', // assuming dropdown
        'required' => true,
        'options' => [ // Optional: define options here if static
            'Private Limited',
            'Public Limited',
            'LLP',
            'Proprietorship',
        ],
    ],
    [
        'label' => 'Transfer Date',
        'name' => 'transfer_date',
        'id' => 'transfer_date',
        'type' => 'date',
        'required' => true,
    ],
    [
        'label' => 'Shares',
        'name' => 'shares',
        'id' => 'shares',
        'type' => 'number',
        'required' => true,
    ],
    [
        'label' => 'Face Value',
        'name' => 'face_value',
        'id' => 'face_value',
        'type' => 'number',
        'required' => false,
    ],
    [
        'label' => 'Total Consideration',
        'name' => 'total_consideration',
        'id' => 'total_consideration',
        'type' => 'number',
        'required' => false,
    ],
];
