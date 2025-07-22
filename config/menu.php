<?php

return [
    [
        'title' => 'Dashboard',
        'icon' => 'las la-home',
        'route' => 'index1',
        'position' => '0',
        'active' => '1'
    ],
    [
        'title' => 'Company',
        'icon' => 'las la-piggy-bank',
        'position' => '2',
        'active' => '1',
        'submenu' => [
            ['title' => 'Profile', 'route' => 'company.view'],
            ['title' => 'Branches', 'route' => 'branch.index'],
            ['title' => 'Promoters', 'route' => 'promotor.index'],
            ['title' => 'Promotor & Share Holdings', 'route' => 'manage.shareholding'],
            ['title' => 'Director', 'route' => 'director.index'],
        ],
    ],
    [
        'title' => 'User',
        'icon' => 'las la-user',
        'position' => '3',
        'active' => '1',
        'submenu' => [
            ['title' => 'Permissions / Roles', 'route' => 'manage.permission'],
            ['title' => 'Users', 'route' => 'manage.user'],
        ],
    ],
    [
        'title' => 'Member',
        'icon' => 'las la-piggy-bank',
        'position' => '4',
        'active' => '1',
        'submenu' => [
            ['title' => 'Members', 'route' => 'member.index'],
            ['title' => 'Minors', 'route' => 'minor.index'],
            ['title' => 'Share Holding', 'route' => 'shares-holdings.index'],
            ['title' => 'Share Certificates', 'route' => 'share-certificates.index'],
            ['title' => 'Share Transfer History', 'route' => 'share-transfer-histories.index'],
            ['title' => 'Form 15G/15H', 'route' => 'Form 15G and 15H.index'],
        ]
    ],
     [
        'title' => 'Savings/Current AC',
        'icon' => 'las la-university',
        'position' => '5',
        'active' => '1',
        'submenu' => [
            ['title' => 'Schemes', 'route' => 'schemes.index'],
            // ['title' => 'Accounts', 'route' => 'account.index'],
        ]
    ],
     
    // [
    //     'title' => 'Accounts',
    //     'icon' => 'las la-piggy-bank',
    //     // 'submenu' => [
    //     //     ['title' => 'Bank Account', 'route' => 'accounts.bank.account'],
    //     //     ['title' => 'Account Overview', 'route' => 'accounts.account.overview'],
    //     //     ['title' => 'Account Details', 'route' => 'accounts.account.details'],
    //     //     ['title' => 'Deposit Details', 'route' => 'accounts.deposit.detail'],
    //     // ],
    // [
    //     'title' => 'Accounts',
    //     'icon' => 'las la-piggy-bank',
    //     'position' => '0',
    //     'active' => '1',
    //     'submenu' => [
    //         ['title' => 'Bank Account', 'route' => 'accounts.bank.account'],
    //         ['title' => 'Account Overview', 'route' => 'accounts.account.overview'],
    //         ['title' => 'Account Details', 'route' => 'accounts.account.details'],
    //         ['title' => 'Deposit Details', 'route' => 'accounts.deposit.detail'],
    //     ],
    // ],

    // [
    //     'title' => 'Transaction',
    //     'icon' => 'las la-exchange-alt',
    //     'position' => '0',
    //     'active' => '1',
    //     'submenu' => [
    //         ['title' => 'Style 01', 'route' => 'transaction.style1'],
    //         ['title' => 'Style 02', 'route' => 'transaction.style2'],
    //         ['title' => 'Style 03', 'route' => 'transaction.style3'],
    //     ],
    // ],

    // [
    //     'title' => 'Payment',
    //     'icon' => 'las la-wallet',
    //     'position' => '0',
    //     'active' => '1',
    //     'submenu' => [
    //         ['title' => 'Payment Overview', 'route' => 'payment.overview'],
    //         ['title' => 'Payment Providers', 'route' => 'payment.providers'],
    //         ['title' => 'Exchange', 'route' => 'payment.exchange'],
    //         ['title' => 'Make a Payment', 'route' => 'payment.make.payment'],
    //     ],
    // ],
    [
        'title' => 'HR Management',
        'icon' => 'las la-user',
        'position' => '6',
        'active' => '1',
        'submenu' => [
            ['title' => 'Employees', 'route' => 'ManageEmployee'],
            // ['title' => 'Attendance', 'route' => 'ManageEmployee'],
            // ['title' => 'Salary Disbursment', 'route' => 'ManageEmployee'],
        ],
    ],

    // [
    //     'title' => 'Private Transfers',
    //     'icon' => 'las la-coins',
    //     'position' => '0',
    //     'active' => '1',
    //     'submenu' => [
    //         ['title' => 'Add Contact', 'route' => 'transfer.add.contact'],
    //         ['title' => 'Transfer Overview', 'route' => 'transfer.overview'],
    //         ['title' => 'Make Transfer', 'route' => 'transfer.make.transfer'],
    //         ['title' => 'Chat', 'route' => 'transfer.chat'],
    //     ],
    // ],

    // [
    //     'title' => 'Reports',
    //     'icon' => 'las la-chart-pie',
    //     'position' => '0',
    //     'active' => '1',
    //     'submenu' => [
    //         ['title' => 'Style 01', 'route' => 'reports.style1'],
    //         ['title' => 'Style 02', 'route' => 'reports.style2'],
    //     ],
    // ],

    // [
    //     'title' => 'Settings',
    //     'icon' => 'las la-cog',
    //     'position' => '0',
    //     'active' => '1',
    //     'submenu' => [
    //         ['title' => 'Profile', 'route' => 'settings.profile'],
    //         ['title' => 'Security', 'route' => 'settings.security'],
    //         ['title' => 'Social Network', 'route' => 'settings.social.network'],
    //         ['title' => 'Notification', 'route' => 'settings.notification'],
    //         ['title' => 'Payment Limits', 'route' => 'settings.payment.limit'],
    //     ],
    // ],

    // [
    //     'title' => 'Authentication',
    //     'icon' => 'las la-user-circle',
    //     'position' => '0',
    //     'active' => '1',
    //     'submenu' => [
    //         ['title' => 'Sign Up', 'route' => 'auth.sign.up'],
    //         ['title' => 'Sign In', 'route' => 'log.in'],
    //         ['title' => 'Sign In QR Code', 'route' => 'auth.sign.in.qrcode'],
    //         ['title' => 'Error Page', 'route' => 'auth.error'],
    //     ],
    // ],

    // [
    //     'title' => 'Support',
    //     'icon' => 'las la-handshake',
    //     'position' => '0',
    //     'active' => '1',
    //     'submenu' => [
    //         ['title' => 'Help Center', 'route' => 'support.help.center'],
    //         ['title' => 'Privacy Policy', 'route' => 'support.privacy.policy'],
    //         ['title' => 'Contact Us', 'route' => 'support.contact.us'],
    //     ],
    // ],

];
