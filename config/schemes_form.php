<?php

return [


    [
        [
            'label'    => 'Scheme Name',
            'name'     => 'scheme_name',
            'id'       => 'scheme_name',
            'type'     => 'text',
            'required' => true
        ],
        [
            'label'    => 'Scheme Code',
            'name'     => 'scheme_code',
            'id'       => 'scheme_code',
            'type'     => 'text',
            'required' => true
        ],

        [
            'label'    => 'Min. Opening Balance',
            'name'     => 'min_opening_balance',
            'id'       => 'min_opening_balance',
            'type'     => 'number',
            'required' => true,

        ],
        [
            'label'    => 'Min. Monthly Avg. Balance',
            'name'     => 'min_monthly_avg_balance',
            'id'       => 'min_monthly_avg_balance',
            'type'     => 'number',
            'required' => true,

        ],

        [
            'label'    => 'Annual Interest Rate (%)',
            'name'     => 'annual_interest_rate',
            'id'       => 'annual_interest_rate',
            'type'     => 'number',
            'required' => true,

        ],
        [
            'label'    => 'Sr. Citizen Add-on Interest Rate (%)',
            'name'     => 'sr_citizen_add_on_interest_rate',
            'id'       => 'sr_citizen_add_on_interest_rate',
            'type'     => 'decimal',
            'required' => true,

        ],
        [
            'label'         => 'Interest Payout',
            'name'          => 'interest_payout',
            'id'            => 'interestpayoutDropdown',
            'type'          => 'select',
            'required'      => true,
            'options'     => [
                'monthly'     => 'Monthly',
                'quarterly'   => 'Quarterly',
                'half_yearly' => 'Half-Yearly',
                'yearly'      => 'Yearly',
            ]
        ],

        [
            'label'    => 'Lock In Amount',
            'name'     => 'lock_in_amount',
            'id'       => 'lock_in_amount',
            'type'     => 'number',
            'required' => true,
        ],
        [
            'label'    => 'Min. Monthly Avg. Balance Charge',
            'name'     => 'min_monthly_avg_balance_charge',
            'id'       => 'min_monthly_avg_balance_charge',
            'type'     => 'number',
            'required' => true,
        ],

    ],

    'Service Charges' => [
        [
            'label'        => 'Charge Frequency',
            'name'         => 'service_charge_frequency',
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
            'label'     => 'Service Charges',
            'name'      => 'service_charges',
            'id'        => 'service_charges',
            'type'      => 'number',
            'required'  => false,
            'default'   => '',
            'placeholder' => 'Enter Service Charges',
        ],

    ],

    'SMS Charges' => [
        [
            'label'        => 'Charge Frequency',
            'name'         => 'sms_charge_frequency',
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
            'label'    => 'SMS Charges',
            'name'     => 'sms_charges',
            'id'       => 'sms_charges',
            'type'     => 'number',
            'required' => false,
        ]
    ],
    'free ifsc collection per month' => [
        [
            'label'       => 'Free IFSC Collection per Month',
            'name'        => 'free_ifsc_collection_per_month',
            'id'          => 'free_ifsc_collection_per_month',
            'type'        => 'select',
            'required'    => false,
            'options'     => [
                '0'          => '0 per month',
                '1'          => '1 per month',
                '2'          => '2 per month',
                '3'          => '3 per month',
                '4'          => '4 per month',
                '5'          => '5 per month',
                '6'          => '6 per month',
                '7'          => '7 per month',
                '8'          => '8 per month',
                '9'          => '9 per month',
                '10'          => '10 per month',
                '11'          => '11 per month',
                '12'         => '12 per month',
                '13'          => '13 per month',
                '14'          => '14 per month',
                '15'          => '15 per month',
                '16'          => '16 per month',
                '17'          => '17 per month',
                '18'          => '18 per month',
                '19'          => '19 per month',
                '20'          => '20 per month',
                '21'          => '21 per month',
                '22'          => '22 per month',
                '23'          => '23 per month',
                '24'          => '24 per month',
                '25'          => '25 per month',
                'unlimited'  => 'Unlimited',
            ]
        ]
    ],
    'free imps/ neft transactions per month' =>
    [
        [
            'label'    => 'Free Transfers per Month',
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
            'label'    => 'Single Transaction Limit',
            'name'     => 'single_transaction_limit',
            'id'       => 'single_transaction_limit',
            'type'     => 'number',
            'required' => false,
            'default'  => '',
        ]
    ],
    'IMPS/ NEFT TRANSFER LIMIT (DAILY / WEEKLY / MONTHLY)' =>
    [
        [
            'label'    => '',
            'name'     => 'daily_max_limit',
            'id'       => 'daily_max_limit',
            'type'     => 'number',
            'required' => false,
            'default'  => '',

        ],
        [
            'label'    => '',
            'name'     => 'weekly_max_limit',
            'id'       => 'weekly_max_limit',
            'type'     => 'number',
            'required' => false,
            'default'  => '',
        ],
        [
            'label'    => '',
            'name'     => 'monthly_max_limit',
            'id'       => 'monthly_max_limit',
            'type'     => 'number',
            'required' => false,
            'default'  => '',
        ]
    ],

];
