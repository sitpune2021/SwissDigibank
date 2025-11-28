<?php

return [


    [
        [
            'label'    => 'SCHEME NAME',
            'name'     => 'scheme_name',
            'id'       => 'scheme_name',
            'type'     => 'text',
            'required' => true
        ],
        [
            'label'    => 'SCHEME CODE',
            'name'     => 'scheme_code',
            'id'       => 'scheme_code',
            'type'     => 'text',
            'required' => true
        ],

        [
            'label'    => 'MIN. OPENING BALANCE',
            'name'     => 'min_opening_balance',
            'id'       => 'min_opening_balance',
            'type'     => 'number',
            'required' => true,

        ],
        [
            'label'    => 'MIN. MONTHLY AVG. BALANCE',
            'name'     => 'min_monthly_avg_balance',
            'id'       => 'min_monthly_avg_balance',
            'type'     => 'number',
            'required' => true,

        ],

        [
            'label'    => 'ANNUAL INTEREST RATE (%)',
            'name'     => 'annual_int_rate',
            'id'       => 'annual_interest_rate',
            'type'     => 'number',
            'required' => true,

        ],
        [
            'label'    => 'SR. CITIZEN ADD-ON INTEREST RATE (%)',
            'name'     => 'sr_citizen_add_on_int_rate',
            'id'       => 'sr_citizen_add_on_interest_rate',
            // 'type'     => 'number',
            'step'     => 'any',
            'min'      => '0',
            'default'  => '0.0',
            'required' => true,
        ],


        [
            'label'         => 'INTEREST PAYOUT',
            'name'          => 'interest_pay_cycle',
            'id'            => 'interestpayoutDropdown',
            'type'          => 'select',
            'required'      => true,
            'options'     => [
                'Monthly'     => 'Monthly',
                'Quarterly'   => 'Quarterly',
                'Half-Yearly' => 'Half-Yearly',
                'Annually'      => 'Yearly',
            ]
        ],

        [
            'label'    => 'LOCK IN AMOUNT',
            'name'     => 'lock_in_amount',
            'id'       => 'lock_in_amount',
            'type'     => 'number',
            'required' => true,
        ],
        [
            'label'    => 'MIN. MONTHLY AVG. BALANCE CHARGE',
            'name'     => 'min_monthly_avg_bal_charge',
            'id'       => 'min_monthly_avg_bal_charge',
            'type'     => 'number',
            'required' => true,
        ],

    ],
    'SERVICE CHARGES' => [
        [
            'label'        => 'CHARGE FREQUENCY',
            'name'         => 'service_charge_freq',
            'id'           => 'charge_frequency',
            'type'         => 'select',
            'required'     => false,
            'dynamic'      => true,
            'options_key'  => 'charge_frequencies',
            'options'      => [
                ''                     => 'Select Frequency',
                'beginning_of_month'   => 'Beginning of Month',
                'end_of_month'         => 'End of Month',
                'beginning_of_quarter' => 'Beginning of Quarter',
                'end_of_quarter'       => 'End of Quarter',
                'beginning_of_half_year' => 'Beginning of Half Year',
                'end_of_half_year'       => 'End of Half Year',
                'beginning_of_year'    => 'Beginning of Year',
                'end_of_year'          => 'End of Year',
            ]
        ],

        [
            'label'     => 'SERVICE CHARGES',
            'name'      => 'service_charges',
            'id'        => 'service_charges',
            'type'      => 'number',
            'required'  => false,
            'default'   => '',
            'placeholder' => 'Enter Service Charges',
        ],

    ],

    'SMS CHARGES' => [
        [
            'label'        => 'CHARGE FREQUENCY',
            'name'         => 'sms_charge_freq',
            'id'           => 'charge_frequency',
            'type'         => 'select',
            'required'     => false,
            'dynamic'      => true,
            'options_key'  => 'charge_frequencies',
            'options'      => [
                ''                     => 'Select Frequency',
                'beginning_of_month'   => 'Beginning of Month',
                'end_of_month'         => 'End of Month',
                'beginning_of_quarter' => 'Beginning of Quarter',
                'end_of_quarter'       => 'End of Quarter',
                'beginning_of_half_year' => 'Beginning of Half Year',
                'end_of_half_year'       => 'End of Half Year',
                'beginning_of_year'    => 'Beginning of Year',
                'end_of_year'          => 'End of Year',
            ]
        ],
        [
            'label'    => 'SMS CHARGES',
            'name'     => 'sms_charges',
            'id'       => 'sms_charges',
            'type'     => 'number',
            'required' => false,
        ]
    ],
    'FREE IFSC COLLECTION PER MONTH' => [
        [
            'label'       => 'FREE IFSC COLLECTION PER MONTH',
            'name'        => 'free_ifsc_collection_per_month',
            'id'          => 'free_ifsc_collection_per_month',
            'type'        => 'select',
            'required'    => false,
            'options'     => [
                '0'          => '0 per month',
                '1'          => '1 per month',
                '5'          => '5 per month',
                '10'         => '10 per month',
                'unlimited'  => 'Unlimited',
            ]
        ]
    ],
    'FREE IMPS/ NEFT TRANSACTIONS PER MONTH' =>
    [
        [
            'label'    => 'FREE TRANSFERS PER MONTH',
            'name'     => 'free_transfers_per_month',
            'id'       => 'free_transfers_per_month',
            'type'     => 'select',
            'required' => false,
            'options'  => [
                '0'         => '0 per month',
                '1'         => '1 per month',
                '5'         => '5 per month',
                '10'        => '10 per month',
                'unlimited' => 'Unlimited',
            ]
        ],
        [
            'label'    => 'SINGLE TRANSACTION LIMIT',
            'name'     => 'single_transaction_limit',
            'id'       => 'single_transaction_limit',
            'type'     => 'number',
            'required' => false,
            'default'  => '',
        ]
        // rem 3 colum
    ]
];
