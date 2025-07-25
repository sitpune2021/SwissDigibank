<?php

return [
    [
        'label' => 'Branch Name',
        'name' => 'branch_name',
        'id' => 'branch_name',
        'type' => 'text',
        'required' => true,
    ],
    [
        'label' => 'Branch Code',
        'name' => 'branch_code',
        'id' => 'branch_code',
        'type' => 'text',
        'required' => true,
    ],
    [
        'label' => 'Open Date',
        'name' => 'open_date',
        'id' => 'date',
        'type' => 'text',
        'required' => true,
    ],
    [
        'label' => 'IFSC Code',
        'name' => 'ifsc_code',
        'id' => 'ifsc_code',
        'type' => 'text',
        'required' => true,
    ],
    [
        'label' => 'Address Line 1',
        'name' => 'address_line1',
        'id' => 'address_line1',
        'type' => 'text',
        'required' => true,
    ],
    [
        'label' => 'Address Line 2',
        'name' => 'address_line2',
        'id' => 'address_line2',
        'type' => 'text',
        'required' => false,
    ],
    [
        'label' => 'Country',
        'name' => 'country',
        'id' => 'country',
        'type' => 'text',
        'required' => true,
    ],
    [
        'label' => 'State',
        'name' => 'state',
        'id' => 'stateDropdown',
        'type' => 'select',
        'required' => true,
        'dynamic' => true,
        'options_key' => 'states', // 👈 used to match controller data
    ],
    [
        'label' => 'City',
        'name' => 'city',
        'id' => 'city',
        'type' => 'text',
        'required' => true,
    ],
    [
        'label' => 'Pincode',
        'name' => 'pincode',
        'id' => 'pincode',
        'type' => 'text',
        'required' => true,
    ],
    [
        'label' => 'Email Id',
        'name' => 'contact_email',
        'id' => 'contact_email',
        'type' => 'email',
        'required' => true,
    ],
    [
        'label' => 'Contact No.',
        'name' => 'mobile_no',
        'id' => 'mobile_no',
        'type' => 'text',
        'required' => true,
    ],
    [
        'label' => 'Landline No.',
        'name' => 'landline_no',
        'id' => 'landline_no',
        'type' => 'text',
        'required' => false,
    ],
    [
        'label' => 'GST No.',
        'name' => 'gst_no',
        'id' => 'gst_no',
        'type' => 'text',
        'required' => false,
    ],
    [
        'label' => 'Disable Recharge / Bill Payment',
        'name' => 'disable_recharge',
        'id' => 'disable_recharge',
        'type' => 'radio',
        'required' => true,
        'default' => 'yes', // 👈 Default set to 'no'
        'options' => [
            'yes' => 'Yes',
            'no' => 'No',
        ],
    ],
    [
        'label' => 'Disable NEFT',
        'name' => 'disable_neft',
        'type' => 'radio',
        'id' => 'disable_neft',
        'required' => true,
        'default' => 'no', // 👈 Default set to 'no'
        'options' => [
            'yes' => 'Yes',
            'no' => 'No',
        ],
    ],
];
