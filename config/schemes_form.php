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
            'name'     => 'annual_int_rate',
            'id'       => 'annual_interest_rate',
            'type'     => 'number',
            'required' => true,

        ],
        [
            'label'    => 'Sr. Citizen Add-on Interest Rate (%)',
            'name'     => 'sr_citizen_add_on_int_rate',
            'id'       => 'sr_citizen_add_on_interest_rate',
            'type'     => 'number',
            'required' => true,

        ],
        [
            'label'         => 'Interest Payout',
            'name'          => 'interest_pay_cycle',
            'id'            => 'interestpayoutDropdown',
            'type'          => 'select',
            'required'      => true,
            'options'     => [
                'Monthly'     => 'Monthly',
                'Quarterly'   => 'Quarterly',
                'Half-Yearly' => 'Half-Yearly',
                'Yearly'      => 'Yearly',
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
            'name'     => 'min_monthly_avg_bal_charge',
            'id'       => 'min_monthly_avg_bal_charge',
            'type'     => 'number',
            'required' => true,
        ],

    ],
    'Service Charges' => [
        [
            'label'        => 'Charge Frequency',
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
                '5'          => '5 per month',
                '10'         => '10 per month',
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
        // rem 3 colum
    ],

    'IMPS Charges' => [
        ['label' => 'IMPS upto 1000', 'name' => 'imps_upto_1000', 'id' => 'imps_upto_1000', 'type' => 'decimal', 'required' => false, 'step' => '0.01', 'min' => 0],
        ['label' => 'IMPS upto 2500', 'name' => 'imps_upto_2500', 'id' => 'imps_upto_2500', 'type' => 'decimal', 'required' => false, 'step' => '0.01', 'min' => 0],
        ['label' => 'IMPS upto 5000', 'name' => 'imps_upto_5000', 'id' => 'imps_upto_5000', 'type' => 'decimal', 'required' => false, 'step' => '0.01', 'min' => 0],
        ['label' => 'IMPS upto 7500', 'name' => 'imps_upto_7500', 'id' => 'imps_upto_7500', 'type' => 'decimal', 'required' => false, 'step' => '0.01', 'min' => 0],
        ['label' => 'IMPS upto 10000', 'name' => 'imps_upto_10000', 'id' => 'imps_upto_10000', 'type' => 'decimal', 'required' => false, 'step' => '0.01', 'min' => 0],
        ['label' => 'IMPS upto 17500', 'name' => 'imps_upto_17500', 'id' => 'imps_upto_17500', 'type' => 'decimal', 'required' => false, 'step' => '0.01', 'min' => 0],
        ['label' => 'IMPS upto 25000', 'name' => 'imps_upto_25000', 'id' => 'imps_upto_25000', 'type' => 'decimal', 'required' => false, 'step' => '0.01', 'min' => 0],
        ['label' => 'IMPS upto 37500', 'name' => 'imps_upto_37500', 'id' => 'imps_upto_37500', 'type' => 'decimal', 'required' => false, 'step' => '0.01', 'min' => 0],
        ['label' => 'IMPS upto 50000', 'name' => 'imps_upto_50000', 'id' => 'imps_upto_50000', 'type' => 'decimal', 'required' => false, 'step' => '0.01', 'min' => 0],
        ['label' => 'IMPS upto 75000', 'name' => 'imps_upto_75000', 'id' => 'imps_upto_75000', 'type' => 'decimal', 'required' => false, 'step' => '0.01', 'min' => 0],
        ['label' => 'IMPS upto 100000', 'name' => 'imps_upto_100000', 'id' => 'imps_upto_100000', 'type' => 'decimal', 'required' => false, 'step' => '0.01', 'min' => 0],
        ['label' => 'IMPS upto 150000', 'name' => 'imps_upto_150000', 'id' => 'imps_upto_150000', 'type' => 'decimal', 'required' => false, 'step' => '0.01', 'min' => 0],
        ['label' => 'IMPS upto 200000', 'name' => 'imps_upto_200000', 'id' => 'imps_upto_200000', 'type' => 'decimal', 'required' => false, 'step' => '0.01', 'min' => 0],
        ['label' => 'IMPS upto 300000', 'name' => 'imps_upto_300000', 'id' => 'imps_upto_300000', 'type' => 'decimal', 'required' => false, 'step' => '0.01', 'min' => 0],
        ['label' => 'IMPS upto 400000', 'name' => 'imps_upto_400000', 'id' => 'imps_upto_400000', 'type' => 'decimal', 'required' => false, 'step' => '0.01', 'min' => 0],
        ['label' => 'IMPS upto 500000', 'name' => 'imps_upto_500000', 'id' => 'imps_upto_500000', 'type' => 'decimal', 'required' => false, 'step' => '0.01', 'min' => 0],
        ['label' => 'IMPS upto 1000000', 'name' => 'imps_upto_1000000', 'id' => 'imps_upto_1000000', 'type' => 'decimal', 'required' => false, 'step' => '0.01', 'min' => 0],
    ],

    'NEFT Charges' => [
        ['label' => 'NEFT upto 1000', 'name' => 'neft_upto_1000', 'id' => 'neft_upto_1000', 'type' => 'decimal', 'required' => false, 'step' => '0.01', 'min' => 0],
        ['label' => 'NEFT upto 2500', 'name' => 'neft_upto_2500', 'id' => 'neft_upto_2500', 'type' => 'decimal', 'required' => false, 'step' => '0.01', 'min' => 0],
        ['label' => 'NEFT upto 5000', 'name' => 'neft_upto_5000', 'id' => 'neft_upto_5000', 'type' => 'decimal', 'required' => false, 'step' => '0.01', 'min' => 0],
        ['label' => 'NEFT upto 7500', 'name' => 'neft_upto_7500', 'id' => 'neft_upto_7500', 'type' => 'decimal', 'required' => false, 'step' => '0.01', 'min' => 0],
        ['label' => 'NEFT upto 10000', 'name' => 'neft_upto_10000', 'id' => 'neft_upto_10000', 'type' => 'decimal', 'required' => false, 'step' => '0.01', 'min' => 0],
        ['label' => 'NEFT upto 17500', 'name' => 'neft_upto_17500', 'id' => 'neft_upto_17500', 'type' => 'decimal', 'required' => false, 'step' => '0.01', 'min' => 0],
        ['label' => 'NEFT upto 25000', 'name' => 'neft_upto_25000', 'id' => 'neft_upto_25000', 'type' => 'decimal', 'required' => false, 'step' => '0.01', 'min' => 0],
        ['label' => 'NEFT upto 37500', 'name' => 'neft_upto_37500', 'id' => 'neft_upto_37500', 'type' => 'decimal', 'required' => false, 'step' => '0.01', 'min' => 0],
        ['label' => 'NEFT upto 50000', 'name' => 'neft_upto_50000', 'id' => 'neft_upto_50000', 'type' => 'decimal', 'required' => false, 'step' => '0.01', 'min' => 0],
        ['label' => 'NEFT upto 75000', 'name' => 'neft_upto_75000', 'id' => 'neft_upto_75000', 'type' => 'decimal', 'required' => false, 'step' => '0.01', 'min' => 0],
        ['label' => 'NEFT upto 100000', 'name' => 'neft_upto_100000', 'id' => 'neft_upto_100000', 'type' => 'decimal', 'required' => false, 'step' => '0.01', 'min' => 0],
        ['label' => 'NEFT upto 150000', 'name' => 'neft_upto_150000', 'id' => 'neft_upto_150000', 'type' => 'decimal', 'required' => false, 'step' => '0.01', 'min' => 0],
        ['label' => 'NEFT upto 200000', 'name' => 'neft_upto_200000', 'id' => 'neft_upto_200000', 'type' => 'decimal', 'required' => false, 'step' => '0.01', 'min' => 0],
        ['label' => 'NEFT upto 300000', 'name' => 'neft_upto_300000', 'id' => 'neft_upto_300000', 'type' => 'decimal', 'required' => false, 'step' => '0.01', 'min' => 0],
        ['label' => 'NEFT upto 400000', 'name' => 'neft_upto_400000', 'id' => 'neft_upto_400000', 'type' => 'decimal', 'required' => false, 'step' => '0.01', 'min' => 0],
        ['label' => 'NEFT upto 500000', 'name' => 'neft_upto_500000', 'id' => 'neft_upto_500000', 'type' => 'decimal', 'required' => false, 'step' => '0.01', 'min' => 0],
        ['label' => 'NEFT upto 1000000', 'name' => 'neft_upto_1000000', 'id' => 'neft_upto_1000000', 'type' => 'decimal', 'required' => false, 'step' => '0.01', 'min' => 0],
    ],

    'UPI Charges' => [
        ['label' => 'UPI upto 1000', 'name' => 'upi_upto_1000', 'id' => 'upi_upto_1000', 'type' => 'decimal', 'required' => false, 'step' => '0.01', 'min' => 0],
        ['label' => 'UPI upto 2500', 'name' => 'upi_upto_2500', 'id' => 'upi_upto_2500', 'type' => 'decimal', 'required' => false, 'step' => '0.01', 'min' => 0],
        ['label' => 'UPI upto 5000', 'name' => 'upi_upto_5000', 'id' => 'upi_upto_5000', 'type' => 'decimal', 'required' => false, 'step' => '0.01', 'min' => 0],
        ['label' => 'UPI upto 7500', 'name' => 'upi_upto_7500', 'id' => 'upi_upto_7500', 'type' => 'decimal', 'required' => false, 'step' => '0.01', 'min' => 0],
        ['label' => 'UPI upto 10000', 'name' => 'upi_upto_10000', 'id' => 'upi_upto_10000', 'type' => 'decimal', 'required' => false, 'step' => '0.01', 'min' => 0],
        ['label' => 'UPI upto 17500', 'name' => 'upi_upto_17500', 'id' => 'upi_upto_17500', 'type' => 'decimal', 'required' => false, 'step' => '0.01', 'min' => 0],
        ['label' => 'UPI upto 25000', 'name' => 'upi_upto_25000', 'id' => 'upi_upto_25000', 'type' => 'decimal', 'required' => false, 'step' => '0.01', 'min' => 0],
        ['label' => 'UPI upto 37500', 'name' => 'upi_upto_37500', 'id' => 'upi_upto_37500', 'type' => 'decimal', 'required' => false, 'step' => '0.01', 'min' => 0],
        ['label' => 'UPI upto 50000', 'name' => 'upi_upto_50000', 'id' => 'upi_upto_50000', 'type' => 'decimal', 'required' => false, 'step' => '0.01', 'min' => 0],
        ['label' => 'UPI upto 75000', 'name' => 'upi_upto_75000', 'id' => 'upi_upto_75000', 'type' => 'decimal', 'required' => false, 'step' => '0.01', 'min' => 0],
        ['label' => 'UPI upto 100000', 'name' => 'upi_upto_100000', 'id' => 'upi_upto_100000', 'type' => 'decimal', 'required' => false, 'step' => '0.01', 'min' => 0],
        ['label' => 'UPI upto 150000', 'name' => 'upi_upto_150000', 'id' => 'upi_upto_150000', 'type' => 'decimal', 'required' => false, 'step' => '0.01', 'min' => 0],
        ['label' => 'UPI upto 200000', 'name' => 'upi_upto_200000', 'id' => 'upi_upto_200000', 'type' => 'decimal', 'required' => false, 'step' => '0.01', 'min' => 0],
        ['label' => 'UPI upto 300000', 'name' => 'upi_upto_300000', 'id' => 'upi_upto_300000', 'type' => 'decimal', 'required' => false, 'step' => '0.01', 'min' => 0],
        ['label' => 'UPI upto 400000', 'name' => 'upi_upto_400000', 'id' => 'upi_upto_400000', 'type' => 'decimal', 'required' => false, 'step' => '0.01', 'min' => 0],
        ['label' => 'UPI upto 500000', 'name' => 'upi_upto_500000', 'id' => 'upi_upto_500000', 'type' => 'decimal', 'required' => false, 'step' => '0.01', 'min' => 0],
        ['label' => 'UPI upto 1000000', 'name' => 'upi_upto_1000000', 'id' => 'upi_upto_1000000', 'type' => 'decimal', 'required' => false, 'step' => '0.01', 'min' => 0],
    ],
];
