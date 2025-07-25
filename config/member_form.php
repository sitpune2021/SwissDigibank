<?php

return [

    // Membership Type (unnamed section)
    [
        [
            'label' => 'Membership Type',
            'name' => 'membership_type',
            'id' => 'membership_type',
            'type' => 'select',
            'required' => true,
            'default' => 'nominal',
            'options' => [
                'nominal' => 'Nominal Membership',
                'regular' => 'Regular Membership',
            ],
        ],
    // ],

    // // // General Info
    // ' ' => 
    // [
        [
            'label' => 'Advisor/Staff',
            'name' => 'general_advisor_staff',
            'id' => 'advisor_staff',
            'type' => 'text',
            'required' => false,
        ],
        [
            'label' => 'Group',
            'name' => 'general_group',
            'id' => 'group',
            'type' => 'select',
            'required' => false,
            'options' => [
                'group1' => 'Group 1',
                'group2' => 'Group 2',
            ],
        ],
        [
            'label' => 'Branch',
            'name' => 'general_branch',
            'id' => 'branch',
            'type' => 'select',
            'required' => true,
               'dynamic' => true,
            'options_key' => 'branch',
        ],
        [
            'label' => 'Enrollment Date',
            'name' => 'general_enrollment_date',
            'id' => 'date',
            'type' => 'text',
            'required' => true,
        ],
    ],

    // Member Info
    'members_info' => [
        [
            'label' => 'Title',
            'name' => 'member_info_title',
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
            'name' => 'member_info_gender',
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
            'name' => 'member_info_first_name',
            'id' => 'first_name',
            'type' => 'text',
            'required' => true,
        ],
        [
            'label' => 'Middle Name',
            'name' => 'member_info_middle_name',
            'id' => 'middle_name',
            'type' => 'text',
            'required' => false,
        ],
        [
            'label' => 'Last Name',
            'name' => 'member_info_last_name',
            'id' => 'last_name',
            'type' => 'text',
            'required' => true,
        ],
        [
            'label' => 'Date of Birth',
            'name' => 'member_info_dob',
            'id' => 'date2',
            'type' => 'text',
            'required' => true,
        ],
        [
            'label' => 'Qualification',
            'name' => 'member_info_qualification',
            'id' => 'qualification',
            'type' => 'text',
            'required' => false,
        ],
        [
            'label' => 'Occupation',
            'name' => 'member_info_occupation',
            'id' => 'occupation',
            'type' => 'text',
            'required' => false,
        ],
        [
            'label' => 'Monthly Income',
            'name' => 'member_info_monthly_income',
            'id' => 'monthly_income',
            'type' => 'number',
            'required' => false,
        ],
        [
            'label' => 'Old Member No (if any)',
            'name' => 'member_info_old_member_no',
            'id' => 'old_member_no',
            'type' => 'text',
            'required' => false,
        ],
        [
            'label' => 'Father Name',
            'name' => 'member_info_father_name',
            'id' => 'father_name',
            'type' => 'text',
            'required' => false,
        ],
        [
            'label' => 'Mother Name',
            'name' => 'member_info_mother_name',
            'id' => 'mother_name',
            'type' => 'text',
            'required' => false,
        ],
        [
            'label' => 'Husband/ Wife Name',
            'name' => 'member_info_spouse_name',
            'id' => 'spouse_name',
            'type' => 'text',
            'required' => false,
        ],
        [
            'label' => 'Husband/ Wife DOB',
            'name' => 'member_info_spouse_dob',
            'id' => 'date3',
            'type' => 'text',
            'required' => false,
        ],
        [
            'label' => 'Mobile No.',
            'name' => 'member_info_mobile_no',
            'id' => 'mobile_no',
            'type' => 'text',
            'required' => true,
        ],
        [
            'label' => 'Collection Time',
            'name' => 'member_info_collection_time',
            'id' => 'collection_time',
            'type' => 'text',
            'required' => false,
        ],
        [
            'label' => 'Marital Status',
            'name' => 'member_info_marital_status',
            'id' => 'marital_status',
            'type' => 'select',
            'required' => false,
            'options' => [
                'single' => 'Single',
                'married' => 'Married',
                'divorced' => 'Divorced',
                'widowed' => 'Widowed',
                'separated' => 'Separated',
            ],
        ],
        [
            'label' => 'Member Religion',
            'name' => 'member_info_religion',
            'id' => 'religion',
            'type' => 'select',
            'required' => false,
            'dynamic' => true,
            'options_key' => 'religion',
        ],
        [
            'label' => 'Email',
            'name' => 'member_info_email',
            'id' => 'email',
            'type' => 'email',
            'required' => false,
        ],
    ],

    // Member Address
    'Members_Correspondence_Address' => [
        [
            'label' => 'Address Line 1',
            'name' => 'member_address_line_1',
            'id' => 'address_line_1',
            'type' => 'text',
            'required' => false,
        ],
        [
            'label' => 'Address Line 2',
            'name' => 'member_address_line_2',
            'id' => 'address_line_2',
            'type' => 'text',
            'required' => false,
        ],
        [
            'label' => 'Para',
            'name' => 'member_address_para',
            'id' => 'para',
            'type' => 'text',
            'required' => false,
        ],
        [
            'label' => 'Ward',
            'name' => 'member_address_ward',
            'id' => 'ward',
            'type' => 'text',
            'required' => false,
        ],
        [
            'label' => 'Panchayat',
            'name' => 'member_address_panchayat',
            'id' => 'panchayat',
            'type' => 'text',
            'required' => false,
        ],
        [
            'label' => 'Area',
            'name' => 'member_address_area',
            'id' => 'area',
            'type' => 'text',
            'required' => false,
        ],
        [
            'label' => 'Landmark',
            'name' => 'member_address_landmark',
            'id' => 'landmark',
            'type' => 'text',
            'required' => false,
        ],
        [
            'label' => 'City / District',
            'name' => 'member_address_city_district',
            'id' => 'city_district',
            'type' => 'text',
            'required' => false,
        ],
        [
            'label' => 'State',
            'name' => 'member_address_state',
            'id' => 'stateDropdown',
            'type' => 'select',
            'required' => true,
            'dynamic' => true,
            'options_key' => 'states',
        ],
        [
            'label' => 'Pincode',
            'name' => 'member_address_pincode',
            'id' => 'pincode',
            'type' => 'number',
            'required' => true,
        ],
        [
            'label' => 'Country',
            'name' => 'member_address_country',
            'id' => 'country',
            'type' => 'text',
            'required' => true,
        ],
       
    ],

    // Permanent Address
    'members_permanent_address' => [
         [
            'label' => 'Address',
            'name' => 'member_address_address',
            'id' => 'address',
            'type' => 'text',
            'required' => false,
        ],
        [
            'label' => 'City',
            'name' => 'member_perm_address_city',
            'id' => 'city',
            'type' => 'text',
            'required' => false,
        ],
        [
            'label' => 'State',
            'name' => 'member_perm_address_state',
            'id' => 'state',
            'type' => 'select',
            'required' => false,
            'dynamic' => true,
            'options_key' => 'states',
        ],
        [
            'label' => 'Pincode',
            'name' => 'member_perm_address_pincode',
            'id' => 'pincode',
            'type' => 'number',
            'required' => false,
        ],
    ],

    // GPS Location
    'members_address_gps_location' => [
        [
            'label' => 'Location Latitude',
            'name' => 'member_gps_location_latitude',
            'id' => 'location_latitude',
            'type' => 'text',
            'required' => false,
        ],
        [
            'label' => 'Location Longitude',
            'name' => 'member_gps_location_longitude',
            'id' => 'location_longitude',
            'type' => 'number',
            'required' => false,
        ],
    ],

    // KYC Info
    'members_kyc' => [
        [
            'label' => 'Aadhaar No',
            'name' => 'member_kyc_aadhaar_no',
            'id' => 'aadhaar_no',
            'type' => 'text',
            'required' => false,
        ],
        [
            'label' => 'Voter ID No',
            'name' => 'member_kyc_voter_id_no',
            'id' => 'voter_id_no',
            'type' => 'text',
            'required' => false,
        ],
        [
            'label' => 'Pan No',
            'name' => 'member_kyc_pan_no',
            'id' => 'pan_no',
            'type' => 'text',
            'required' => false,
        ],
        [
            'label' => 'Ration Card No',
            'name' => 'member_kyc_ration_card_no',
            'id' => 'ration_card_no',
            'type' => 'text',
            'required' => false,
        ],
        [
            'label' => 'Meter No',
            'name' => 'member_kyc_meter_no',
            'id' => 'meter_no',
            'type' => 'text',
            'required' => false,
        ],
        [
            'label' => 'CI No',
            'name' => 'member_kyc_ci_no',
            'id' => 'ci_no',
            'type' => 'text',
            'required' => false,
        ],
        [
            'label' => 'CI Relation',
            'name' => 'member_kyc_ci_relation',
            'id' => 'ci_relation',
            'type' => 'text',
            'required' => false,
        ],
        [
            'label' => 'DL No',
            'name' => 'member_kyc_dl_no',
            'id' => 'dl_no',
            'type' => 'text',
            'required' => false,
        ],
        [
            'label' => 'Passport No',
            'name' => 'member_kyc_passport_no',
            'id' => 'passport_no',
            'type' => 'text',
            'required' => false,
        ],
    ],

    // KYC Documents
    'members_kyc_documents' => [
        [
            'label' => 'Photo',
            'name' => 'member_kyc_photo',
            'id' => 'photo',
            'type' => 'file',
            'required' => false,
            'accept' => 'image/*',
        ],
        [
            'label' => 'Signature',
            'name' => 'member_kyc_signature',
            'id' => 'signature',
            'type' => 'file',
            'required' => false,
            'accept' => 'image/*',
        ],
        [
            'label' => 'Id Proof',
            'name' => 'member_kyc_id_proof',
            'id' => 'id_proof',
            'type' => 'file',
            'required' => false,
            'accept' => 'image/*,.pdf',
        ],
        [
            'label' => 'Id Proof Back',
            'name' => 'member_kyc_id_proof_back',
            'id' => 'id_proof_back',
            'type' => 'file',
            'required' => false,
            'accept' => 'image/*,.pdf',
        ],
        [
            'label' => 'Address Proof',
            'name' => 'member_kyc_address_proof',
            'id' => 'address_proof',
            'type' => 'file',
            'required' => false,
            'accept' => 'image/*,.pdf',
        ],
        [
            'label' => 'Address Proof Back',
            'name' => 'member_kyc_address_proof_back',
            'id' => 'address_proof_back',
            'type' => 'file',
            'required' => false,
            'accept' => 'image/*,.pdf',
        ],
        [
            'label' => 'Pan Number',
            'name' => 'member_kyc_pan_number',
            'id' => 'pan_number',
            'type' => 'file',
            'required' => false,
            'accept' => 'image/*,.pdf',
        ],
    ],

    // Nominee Info
    'nominee_info' => [
        [
            'label' => 'Nominee Name',
            'name' => 'nominee_name',
            'id' => 'nominee_name',
            'type' => 'text',
            'required' => false,
        ],
        [
            'label' => 'Nominee Relation',
            'name' => 'nominee_relation',
            'id' => 'nominee_relation',
            'type' => 'text',
            'required' => false,
        ],
        [
            'label' => 'Nominee Mobile No.',
            'name' => 'nominee_mobile_no',
            'id' => 'nominee_mobile_no',
            'type' => 'text',
            'required' => false,
        ],
        [
            'label' => 'Gender',
            'name' => 'nominee_gender',
            'id' => 'nominee_gender',
            'type' => 'radio',
            'required' => false,
            'options' => ['Male', 'Female', 'Other'],
        ],
        [
            'label' => 'Nominee DOB',
            'name' => 'nominee_dob',
            'id' => 'date4',
            'type' => 'text',
            'required' => false,
        ],
        [
            'label' => 'Nominee Aadhaar No.',
            'name' => 'nominee_aadhaar_no',
            'id' => 'nominee_aadhaar_no',
            'type' => 'text',
            'required' => false,
        ],
        [
            'label' => 'Nominee Voter ID No.',
            'name' => 'nominee_voter_id_no',
            'id' => 'nominee_voter_id_no',
            'type' => 'text',
            'required' => false,
        ],
        [
            'label' => 'Nominee Pan No.',
            'name' => 'nominee_pan_no',
            'id' => 'nominee_pan_no',
            'type' => 'text',
            'required' => false,
        ],
        [
            'label' => 'Nominee Ration Card No.',
            'name' => 'nominee_ration_card_no',
            'id' => 'nominee_ration_card_no',
            'type' => 'text',
            'required' => false,
        ],
        [
            'label' => 'Nominee Address',
            'name' => 'nominee_address',
            'id' => 'nominee_address',
            'type' => 'text',
            'required' => false,
        ],
    ],
    // Extra Settings
    'extra_settings' => [
        [
            'label' => 'SMS',
            'name' => 'extra_sms',
            'id' => 'sms',
            'type' => 'checkbox',
            'required' => false,
            'default' => 0,
        ],
    ],

    // Membership Charges
    'membership_charges_ (if any) ' => [
        [
            'label' => 'Transaction Date',
            'name' => 'charges_transaction_date',
            'id' => 'transaction_date',
            'type' => 'date5',
            'required' => true,
        ],
        [
            'label' => 'Membership Fee',
            'name' => 'charges_membership_fee',
            'id' => 'membership_fee',
            'type' => 'number',
            'required' => false,
        ],
        [
            'label' => 'Net Fee to Collect',
            'name' => 'charges_net_fee',
            'id' => 'net_fee',
            'type' => 'number',
            'required' => true,
        ],
        [
            'label' => 'Remarks(if any) ',
            'name' => 'charges_remarks',
            'id' => 'remarks',
            'type' => 'text',
            'required' => false,
        ],
        [
            'label' => 'Payment Mode',
            'name' => 'charges_pay_mode',
            'id' => 'pay_mode',
            'type' => 'radio',
            'required' => false,
            'options' => [
                'cash' => 'Cash',
                'online' => 'Online Tr.',
                'cheque' => 'Cheque',
            ],
        ],
    ],
];
