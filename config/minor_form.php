<?php

return 
[
    [
        'label' => 'Enrollment Date',
        'name' => 'enrollment_date',
        'id' => 'date',
        'type' => 'text', // or 'date' if using a date picker
        'required' => true,
    ],
    [
        'label' => 'Title',
        'name' => 'title',
        'id' => 'title',
        'type' => 'radio',
        'required' => true,
        'options' => [
            'md' => 'Md.',
            'mr' => 'Mr.',
            'ms' => 'Ms.',
            'mrs' => 'Mrs.',
        ],
    ],
    [
        'label' => 'Gender',
        'name' => 'gender',
        'id' => 'gender',
        'type' => 'radio',
        'required' => true,
        'options' => [
            'male' => 'Male',
            'female' => 'Female',
            'other' => 'Other',
        ],
    ],
    [
        'label' => 'First Name',
        'name' => 'first_name',
        'id' => 'first_name',
        'type' => 'text',
        'required' => true,
        'placeholder' => 'Enter First Name',
    ],
    [
        'label' => 'Last Name',
        'name' => 'last_name',
        'id' => 'last_name',
        'type' => 'text',
        'required' => false,
        'placeholder' => 'Enter Last Name',
    ],
    [
        'label' => 'Date of Birth',
        'name' => 'dob',
        'id' => 'date2',
        'type' => 'text', // or 'date'
        'required' => true,
        'placeholder' => 'DD/MM/YYYY',
    ],
    [
        'label' => 'Father Name',
        'name' => 'father_name',
        'id' => 'father_name',
        'type' => 'text',
        'required' => true,
        'placeholder' => 'Enter Father Name',
    ],
    [
        'label' => 'Aadhaar No.',
        'name' => 'aadhaar_no',
        'id' => 'aadhaar_no',
        'type' => 'text',
        'required' => false,
        'placeholder' => 'Enter Aadhaar No.',
    ],
    [
        'label' => 'Address',
        'name' => 'address',
        'id' => 'address',
        'type' => 'text',
        'required' => true,
        'placeholder' => 'Enter Address',
    ],
];
