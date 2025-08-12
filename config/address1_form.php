<?php

return [
// Step 1: Basic Info
    '' => [
        [
            'label' => 'Branch',
            'name' => 'branch_id',
            'id' => 'branchDropdown',
            'type' => 'select',
            'required' => true,
            'dynamic' => true,
            'options_key' => 'branches',
        ],
        [
            'label' => 'Enrollment Date',
            'name' => 'enrollment_date',
            'id' => 'date',
            'type' => 'text',
            'default' => now()->format('D M d Y'),
            'required' => true,
        ],
    ],

    // Step 2: Promotor Info
    'promoter_info' => [
        ['label'=>'Title','name'=>'title','id'=>'title','type'=>'select','required'=>true,'options'=>['MD'=>'MD','Mr'=>'Mr','Ms'=>'Ms','Mrs'=>'Mrs']],
        ['label'=>'Gender','name'=>'gender','id'=>'gender','type'=>'radio','required'=>true,'options'=>['Male'=>'Male','Female'=>'Female','Other'=>'Other']],
        ['label'=>'First Name','name'=>'first_name','id'=>'first_name','type'=>'text','required'=>true],
        ['label'=>'Middle Name','name'=>'middle_name','id'=>'middle_name','type'=>'text','required'=>false],
        ['label'=>'Last Name','name'=>'last_name','id'=>'last_name','type'=>'text','required'=>true],
        ['label'=>'Date of Birth','name'=>'date_of_birth','id'=>'date2','type'=>'text','required'=>true],
        ['label'=>'Occupation','name'=>'occupation','id'=>'occupation','type'=>'text','required'=>false],
        ['label'=>'Father Name','name'=>'father_name','id'=>'father_name','type'=>'text','required'=>false],
        ['label'=>'Mother Name','name'=>'mother_name','id'=>'mother_name','type'=>'text','required'=>false],
        ['label'=>'Marital Status','name'=>'marital_statuses_id','id'=>'marital_statuses_id','type'=>'select','required'=>false,'dynamic'=>true,'options_key'=>'marital_statuses'],
        ['label'=>'Member Religion','name'=>'religions_id','id'=>'religions_id','type'=>'select','required'=>false,'dynamic'=>true,'options_key'=>'religions'],
        ['label'=>'Spouse Name','name'=>'husband_wife_name','id'=>'spouse','type'=>'text','required'=>false],
        ['label'=>'Email','name'=>'email','id'=>'email','type'=>'email','required'=>false],
        ['label'=>'Mobile No.','name'=>'mobile','id'=>'mobile','type'=>'text','required'=>true],
    ],

    // Step 3: KYC Info
    'KYC' => [
        ['label'=>'Aadhaar No.','name'=>'aadhaar_no','id'=>'aadhaar_no','type'=>'text','required'=>true],
        ['label'=>'Voter ID No.','name'=>'voter_id_no','id'=>'voter_id_no','type'=>'text','required'=>false],
        ['label'=>'PAN.','name'=>'pan_no','id'=>'pan_no','type'=>'text','required'=>true],
        ['label'=>'Ration Card No.','name'=>'ration_card_no','id'=>'ration_card_no','type'=>'text','required'=>false],
        ['label'=>'Meter No.','name'=>'meter_no','id'=>'meter_no','type'=>'text','required'=>false],
        ['label'=>'CI No.','name'=>'ci_no','id'=>'ci_no','type'=>'text','required'=>false],
        ['label'=>'CI Relation','name'=>'ci_relation','id'=>'ci_relation','type'=>'text','required'=>false],
        ['label'=>'DL No.','name'=>'dl_no','id'=>'dl_no','type'=>'text','required'=>false],
    ],

    // Step 4: Nominee Info
    'nominee_info' => [
        ['label'=>'Nominee Name','name'=>'nominee_name','id'=>'nominee_name','type'=>'text','required'=>false],
        ['label'=>'Nominee Relation','name'=>'nominee_relation','id'=>'nominee_relation','type'=>'text','required'=>false],
        ['label'=>'Nominee Mobile','name'=>'nominee_mobile_no','id'=>'nominee_mobile_no','type'=>'text','required'=>false],
        ['label'=>'Nominee Aadhar No.','name'=>'nominee_aadhaar_no','id'=>'nominee_aadhaar_no','type'=>'text','required'=>false],
        ['label'=>'Nominee Voter ID No.','name'=>'nominee_voter_id_no','id'=>'nominee_voter_id_no','type'=>'text','required'=>false],
        ['label'=>'Nominee PAN No.','name'=>'nominee_pan_no','id'=>'nominee_pan_no','type'=>'text','required'=>false],
        ['label'=>'Nominee Address','name'=>'nominee_address','id'=>'nominee_address','type'=>'text','required'=>false],
    ],


];
