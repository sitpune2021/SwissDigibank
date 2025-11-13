<?php

return [
    'tabs' => [
        'scan_oq' => [
            'label' => 'Scan QR',
            'icon' => 'fa-qrcode',
        ],
        'add_money' => [
            'label' => 'Add Money',
            'icon' => 'fa-money-bill-wave',
        ],
        'branch' => [
            'label' => 'Branch',
            'icon' => 'fa-building',
        ],
        'account_overview' => [
            'label' => 'Account Overview',
            'icon' => 'fa-user-circle',
        ],
        'bank' => [
            'label' => 'Bank',
            'icon' => 'fa-university',
        ],
        'fixed_deposits' => [
            'label' => 'Fixed Deposits',
            'icon' => 'fa-piggy-bank',
        ],
        'digital_rupee' => [
            'label' => 'Digital Rupee',
            'icon' => 'fa-coins',
        ],
        'see_more' => [
            'label' => 'See More',
            'icon' => 'fa-ellipsis-h',
            'sub_tabs' => [
                'muffinpay_wallet' => [
                    'label' => 'Muffinpay Wallet',
                    'sub_tabs' => [
                        'prepaid_card' => [
                            'label' => 'Prepaid Card',
                            'icon' => 'fa-credit-card',
                        ],
                        'p2p_transfer' => [
                            'label' => 'P2P Transfer',
                            'icon' => 'fa-exchange-alt',
                        ],
                        'ncmc' => [
                            'label' => 'NCMC',
                            'icon' => 'fa-credit-card',
                        ],
                    ],
                ],
                'bill_payment' => [
                    'label' => 'Bill Payment',
                    'sub_tabs' => [
                        'postpaid_mobile_bill' => [
                            'label' => 'Postpaid Mobile Bill',
                            'icon' => 'fa-phone',
                        ],
                        'electricity' => [
                            'label' => 'Electricity',
                            'icon' => 'fa-bolt',
                        ],
                        'water' => [
                            'label' => 'Water',
                            'icon' => 'fa-tint',
                        ],
                        'broadband' => [
                            'label' => 'Broadband',
                            'icon' => 'fa-wifi',
                        ],
                        'lpg' => [
                            'label' => 'LPG',
                            'icon' => 'fa-gas-pump',
                        ],
                        'lic' => [
                            'label' => 'LIC',
                            'icon' => 'fa-building',
                        ],
                        'loan_payment' => [
                            'label' => 'Loan Payment',
                            'icon' => 'fa-credit-card',
                        ],
                        'credit_card_payment' => [
                            'label' => 'Credit Card Payment',
                            'icon' => 'fa-credit-card',
                        ],
                    ],
                ],
                'travel_booking' => [
                    'label' => 'Travel Booking',
                    'sub_tabs' => [
                        'flight' => [
                            'label' => 'Flight',
                            'icon' => 'fa-plane',
                        ],
                        'train' => [
                            'label' => 'Train',
                            'icon' => 'fa-train',
                        ],
                        'bus_booking' => [
                            'label' => 'Bus Booking',
                            'icon' => 'fa-bus',
                        ],
                        'hotel' => [
                            'label' => 'Hotel',
                            'icon' => 'fa-bed',
                        ],
                    ],
                ],
                'finance' => [
                    'label' => 'Finance',
                    'sub_tabs' => [
                        'free_credit_score' => [
                            'label' => 'Free Credit Score',
                            'icon' => 'fa-bar-chart',
                        ],
                        'insurance_premium' => [
                            'label' => 'Insurance Premium',
                            'icon' => 'fa-shield-alt',
                        ],
                    ],
                ],
            ],
        ],
    ],
];
