<?php

return [

    'member_KYC_documents' => [
        [
            'label' => 'Photo',
            'name' => 'member_kyc_photo',
            'id' => 'photo',
            'type' => 'file',
            'required' => false,
            'accept' => 'image/*',
            'category' => 'photo',
            'types' => [], // no subtypes
        ],
        [
            'label' => 'Signature',
            'name' => 'member_kyc_signature',
            'id' => 'signature',
            'type' => 'file',
            'required' => false,
            'accept' => 'image/*',
            'category' => 'signature',
            'types' => [], // no subtypes
        ],
        [
            'label' => 'ID Proof',
            'name' => 'member_kyc_id_proof',
            'id' => 'id_proof',
            'type' => 'file',
            'required' => false,
            'accept' => 'image/*,.pdf',
            'category' => 'id_proof',
            'types' => ['Aadhaar Card', 'Passport', 'Driving License', 'Voter ID'],
        ],
        [
            'label' => 'ID Proof Back',
            'name' => 'member_kyc_id_proof_back',
            'id' => 'id_proof_back',
            'type' => 'file',
            'required' => false,
            'accept' => 'image/*,.pdf',
            'category' => 'id_proof_back',
            'types' => ['Aadhaar Card', 'Passport', 'Driving License', 'Voter ID'],
        ],
        [
            'label' => 'Address Proof',
            'name' => 'member_kyc_address_proof',
            'id' => 'address_proof',
            'type' => 'file',
            'required' => false,
            'accept' => 'image/*,.pdf',
            'category' => 'address_proof',
            'types' => ['Aadhaar Card', 'Passport', 'Driving License', 'Utility Bill'],
        ],
        [
            'label' => 'Address Proof Back',
            'name' => 'member_kyc_address_proof_back',
            'id' => 'address_proof_back',
            'type' => 'file',
            'required' => false,
            'accept' => 'image/*,.pdf',
            'category' => 'address_proof_back',
            'types' => ['Aadhaar Card', 'Passport', 'Driving License', 'Utility Bill'],
        ],
        [
            'label' => 'PAN',
            'name' => 'member_kyc_pan_number',
            'id' => 'pan_number',
            'type' => 'file',
            'required' => false,
            'accept' => 'image/*,.pdf',
            'category' => 'pan_number',
            'types' => ['PAN', 'ePAN'],
        ],
    ],

];
