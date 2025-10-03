<?php
return [

    'company' => [
        'heading' => 'COMPANY ',
        'fields' => [
            [
                'label' => 'COMPANY WEBSITE',
                'name' => 'company_website',
                'id' => 'company_website',
                'type' => 'text',
                'required' => false,
            ],
            [
                'label' => 'COMPANY NAME',
                'name' => 'company_name',
                'id' => 'company_name',
                'type' => 'text',
                'required' => true,
            ],
            [
                'label' => 'SHORT NAME',
                'name' => 'short_name',
                'id' => 'short_name',
                'type' => 'text',
                'required' => true,
            ],
            [
                'label' => 'ABOUT COMPANY',
                'name' => 'about_company',
                'id' => 'about_company',
                'type' => 'textarea',
                'required' => false,
            ],
            [
                'label' => 'COMPANY CATEGORY',
                'name' => 'company_category',
                'id' => 'company_category',
                'type' => 'text',
                'required' => false,
            ],
            [
                'label' => 'COMPANY CLASS',
                'name' => 'company_class',
                'id' => 'company_class',
                'type' => 'text',
                'required' => false,
            ],
        ],
    ],
    'registered_office' => [
        'heading' => 'REGISTERED OFFICE DETAILS',
        'fields' => [
            [
                'label' => 'REG. OFFICE ADDRESS LINE 1',
                'name' => 'address_line1',
                'id' => 'address_line1',
                'type' => 'text',
                'required' => true,
            ],
            [
                'label' => 'REG. OFFICE ADDRESS LINE 2',
                'name' => 'address_line2',
                'id' => 'address_line2',
                'type' => 'text',
                'required' => false,
            ],
            [
                'label' => 'CITY',
                'name' => 'city',
                'id' => 'city',
                'type' => 'text',
                'required' => true,
            ],
            [
                'label' => 'STATE',
                'name' => 'state',
                'id' => 'state',
                'type' => 'select',
                'required' => true,
                'dynamic' => true,
                'options_key' => 'state',

            ],
            [
                'label' => 'PINCODE',
                'name' => 'pincode',
                'id' => 'pincode',
                'type' => 'text',
                'required' => true,
            ],
            [
                'label' => 'COUNTRY',
                'name' => 'country',
                'id' => 'country',
                'type' => 'text',
                'required' => true,
            ],
            [
                'label' => 'MOBILE NO.',
                'name' => 'mobile_no',
                'id' => 'mobile_no',
                'type' => 'number',
                'maxlength' => '10',
                'minlength' => '10',
                'pattern' => '[0-9]{10}',
                'required' => true,
            ],
            [
                'label' => 'LANDLINE NO.',
                'name' => 'landline_no',
                'id' => 'landline_no',
                'type' => 'text',
                'required' => false,
            ],
            [
                'label' => 'CONTACT EMAIL',
                'name' => 'contact_email',
                'id' => 'contact_email',
                'type' => 'email',
                'required' => false,
            ],
        ],
    ],

    'legal_info' => [
        'heading' => 'LEGAL & INCORPORATION DETAILS',
        'fields' => [
            [
                'label' => 'CIN NO.',
                'name' => 'cin_no',
                'id' => 'cin_no',
                'type' => 'text',
                'required' => false,
            ],
            [
                'label' => 'UPLOAD CIN CERTIFICATE',
                'name' => 'cin_certificate_path',
                'id' => 'cin_certificate_path',
                'type' => 'file',
                'required' => false,
            ],
            [
                'label' => 'PAN NO.',
                'name' => 'pan_no',
                'id' => 'pan_no',
                'type' => 'text',
                'required' => false,
            ],
            [
                'label' => 'UPLOAD PAN CERTIFICATE',
                'name' => 'pan_certificate_path',
                'id' => 'pan_certificate_path',
                'type' => 'file',
                'required' => false,
            ],

            [
                'label' => 'TAN NO.',
                'name' => 'tan_no',
                'id' => 'tan_no',
                'type' => 'text',
                'required' => false,
            ],
            [
                'label' => 'UPLOAD TAN CERTIFICATE',
                'name' => 'tan_certificate_path',  
                'id' => 'tan_certificate_path',
                'type' => 'file',
                'required' => false,
            ],
            [
                'label' => 'GST NO.',
                'name' => 'gst_no',
                'id' => 'gst_no',
                'type' => 'text',
                'required' => false,
            ],
            [
                'label' => 'UPLOAD GST CERTIFICATE',
                'name' => 'gst_certificate_path',  // updated here
                'id' => 'gst_certificate_path',
                'type' => 'file',
                'required' => false,
            ],


            [
                'label' => 'ISO CERTIFICATION',
                'name' => 'iso_certification',
                'id' => 'iso_certification',
                'type' => 'text',
                'required' => false,
            ],
            [
                'label' => 'UPLOAD ISO CERTIFICATE',
                'name' => 'iso_certificate_path',  // updated here
                'id' => 'iso_certificate_path',
                'type' => 'file',
                'required' => false,
            ],

            [
                'label' => 'BIS CERTIFICATION',
                'name' => 'bis_certification',
                'id' => 'bis_certification',
                'type' => 'text',
                'required' => false,
            ],
            [
                'label' => 'UPLOAD BIS CERTIFICATE',
                'name' => 'bis_certificate_path',  // updated here
                'id' => 'bis_certificate_path',
                'type' => 'file',
                'required' => false,
            ],

            [
                'label' => 'PF NUMBER',
                'name' => 'pf_number',
                'id' => 'pf_number',
                'type' => 'text',
                'required' => false,
            ],
            [
                'label' => 'UPLOAD PF CERTIFICATE',
                'name' => 'pf_certificate_path',  // updated here
                'id' => 'pf_certificate_path',
                'type' => 'file',
                'required' => false,
            ],
            [
                'label' => 'ESIC NUMBER',
                'name' => 'esic_number',
                'id' => 'esic_number',
                'type' => 'text',
                'required' => false,
            ],
            [
                'label' => 'UPLOAD ESIC CERTIFICATE',
                'name' => 'esic_certificate_path',  // updated here
                'id' => 'esic_certificate_path',
                'type' => 'file',
                'required' => false,
            ],
            [
                'label' => 'INCORPORATION DATE',
                'name' => 'incorporation_date',
                'id' => 'date2',
                // 'default' => now()->format('d-m-Y'),
                'type' => 'text',
                'required' => false,
            ],
            [
                'label' => 'INCORPORATION STATE',
                'name' => 'incorporation_state',
                'id' => 'incorporation_state',
                'type' => 'select',
                'required' => false,
                'dynamic' => true,
                'options_key' => 'state',
            ],
            [
                'label' => 'INCORPORATION COUNTRY',
                'name' => 'incorporation_country',
                'id' => 'incorporation_country',
                'type' => 'text',
                'required' => false,
            ],
            [
                'label' => 'AUTHORIZED CAPITAL',
                'name' => 'authorized_capital',
                'id' => 'authorized_capital',
                'type' => 'number',
                'required' => false,
            ],
            [
                'label' => 'PAID UP CAPITAL',
                'name' => 'paid_up_capital',
                'id' => 'paid_up_capital',
                'type' => 'number',
                'required' => false,
            ],
        ],
    ],
];
