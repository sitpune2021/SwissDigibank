<?php

return [
    // Step 1: Basic Info
    '' => [
        [
            'label' => 'BRANCH',
            'name' => 'branch_id',
            'id' => 'branchDropdown',
            'type' => 'select',
            'required' => true,
            'dynamic' => true,
            'options_key' => 'branches',
        ],
        [
            'label' => 'ENROLLMENT DATE',
            'name' => 'enrollment_date',
            'id' => 'date2',
            'type' => 'text',
            'default' => now()->format('d-m-Y'),
            'required' => true,
        ],
    ],

    // Step 2: Promotor Info
    'PROMOTER_INFO' => [
        ['label' => 'TITLE', 'name' => 'title', 'id' => 'title', 'type' => 'select', 'required' => true, 'options' => ['MD' => 'MD', 'Mr' => 'Mr', 'Ms' => 'Ms', 'Mrs' => 'Mrs']],
        ['label' => 'GENDER', 'name' => 'gender', 'id' => 'gender', 'type' => 'radio', 'required' => true, 'options' => ['Male' => 'Male', 'Female' => 'Female', 'Other' => 'Other']],
        ['label' => 'FIRST NAME', 'name' => 'first_name', 'id' => 'first_name', 'type' => 'text', 'required' => true],
        ['label' => 'MIDDLE NAME', 'name' => 'middle_name', 'id' => 'middle_name', 'type' => 'text', 'required' => false],
        ['label' => 'LAST NAME', 'name' => 'last_name', 'id' => 'last_name', 'type' => 'text', 'required' => true],
        ['label' => 'DATE OF BIRTH', 'name' => 'date_of_birth', 'id' => 'datep', 'type' => 'text', 'required' => true],
        ['label' => 'OCCUPATION', 'name' => 'occupation', 'id' => 'occupation', 'type' => 'text', 'required' => false],
        ['label' => 'FATHER NAME', 'name' => 'father_name', 'id' => 'father_name', 'type' => 'text', 'required' => false],
        ['label' => 'MOTHER NAME', 'name' => 'mother_name', 'id' => 'mother_name', 'type' => 'text', 'required' => false],
        ['label' => 'MARITAL STATUS', 'name' => 'marital_statuses_id', 'id' => 'marital_statuses_id', 'type' => 'select', 'required' => false, 'dynamic' => true, 'options_key' => 'marital_statuses'],
        ['label' => 'PROMOTER RELIGION', 'name' => 'religions_id', 'id' => 'religions_id', 'type' => 'select', 'required' => false, 'dynamic' => true, 'options_key' => 'religions'],
        ['label' => 'SPOUSE NAME', 'name' => 'husband_wife_name', 'id' => 'spouse', 'type' => 'text', 'required' => false],
        ['label' => 'EMAIL', 'name' => 'email', 'id' => 'email', 'type' => 'email', 'required' => false],
        [
            'label' => 'MOBILE NO.',
            'name' => 'mobile',
            'id' => 'mobile',
            'type' => 'number',
            'required' => true,
            'maxlength' => '10',
            'minlength' => '10',
            'pattern' => '[0-9]{10}',
        ],
    ],
    // Step 3: KYC Info
    'KYC' => [
        [
            'label' => 'AADHAR NO.',
            'name' => 'aadhaar_no',
            'id' => 'aadhaar_no',
            'type' => 'text',
            'required' => true,
        ],
        ['label' => 'VOTER ID NO.', 'name' => 'voter_id_no', 'id' => 'voter_id_no', 'type' => 'text', 'required' => false],
        [
            'label' => 'PAN.',
            'name' => 'pan_no',
            'id' => 'pan_no',
            'type' => 'text',
            'required' => true,
        ],
        ['label' => 'RATION CARD NO.', 'name' => 'ration_card_no', 'id' => 'ration_card_no', 'type' => 'text', 'required' => false],
        ['label' => 'METER NO.', 'name' => 'meter_no', 'id' => 'meter_no', 'type' => 'text', 'required' => false],
        ['label' => 'CI NO.', 'name' => 'ci_no', 'id' => 'ci_no', 'type' => 'text', 'required' => false],
        ['label' => 'CI RELATION', 'name' => 'ci_relation', 'id' => 'ci_relation', 'type' => 'text', 'required' => false],
        ['label' => 'DL NO.', 'name' => 'dl_no', 'id' => 'dl_no', 'type' => 'text', 'required' => false],
    ],

    // Step 4: Nominee Info
    'NOMINEE_INFO' => [
        ['label' => 'NOMINEE NAME', 'name' => 'nominee_name', 'id' => 'nominee_name', 'type' => 'text', 'required' => false],
        // ['label'=>'Nominee Relation','name'=>'nominee_relation','id'=>'nominee_relation','type'=>'text','required'=>false],
        [
            'label' => 'NOMINEE RELATION',
            'name' => 'nominee_relation',
            'id' => 'nominee_relation',
            'type' => 'select',
            'required' => false,
            'options' => [
                '' => 'Select Relation',
                'father' => 'Father',
                'mother' => 'Mother',
                'son' => 'Son',
                'daughter' => 'Daughter',
                'spouse' => 'Spouse (Husband/ Wife)',
                'husband' => 'Husband',
                'wife' => 'Wife',
                'brother' => 'Brother',
                'sister' => 'Sister',
                'daughter_in_law' => 'Daughter in Law',
                'brother_in_law' => 'Brother in Law',
                'grand_daughter' => 'Grand Daughter',
                'grand_son' => 'Grand Son',
                'nephew' => 'Nephew',
                'niece' => 'Niece',
                'other' => 'Other'
            ]
        ],
        [
            'label' => 'NOMINEE MOBILE',
            'name' => 'nominee_mobile_no',
            'id' => 'nominee_mobile_no',
            'type' => 'number',
            'required' => false,
            'maxlength' => '10',
            'minlength' => '10',
            'pattern' => '[0-9]{10}',
        ],

        [
            'label' => 'NOMINEE AADHAR NO.',
            'name' => 'nominee_aadhaar_no',
            'id' => 'nominee_aadhaar_no',
            'type' => 'text',
            'required' => false,
        ],
        ['label' => 'NOMINEE VOTER ID NO.', 'name' => 'nominee_voter_id_no', 'id' => 'nominee_voter_id_no', 'type' => 'text', 'required' => false],
        [
            'label' => 'NOMINEE PAN No.',
            'name' => 'nominee_pan_no',
            'id' => 'nominee_pan_no',
            'type' => 'text',
            'required' => false,
        ],
        ['label' => 'NOMINEE ADDRESS', 'name' => 'nominee_address', 'id' => 'nominee_address', 'type' => 'text', 'required' => false],
    ],

    'EXTRA_SETTINGS' => [
        [
            'label' => 'SMS',
            'name' => 'extra_sms',
            'id' => 'sms',
            'type' => 'checkbox',
            'required' => false,
            'default' => 0,
        ],
    ],

];
