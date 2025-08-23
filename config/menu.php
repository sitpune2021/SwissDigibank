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
            ['title' => 'Profile', 'route' => 'company.index'],
            ['title' => 'Branches', 'route' => 'branch.index'],
            ['title' => 'Promoters', 'route' => 'promotor.index'],
            ['title' => 'Promotor Share Holdings', 'route' => 'shareholding.index'],
            ['title' => 'Director', 'route' => 'director.index'],
        ],
    ],
    [
        'title' => 'User',
        'icon' => 'las la-user',
        'position' => '3',
        'active' => '1',
        'submenu' => [
            ['title' => 'Permissions / Roles', 'route' => 'roles.index'],
            ['title' => 'Users', 'route' => 'users.index'],
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
            ['title' => 'Share Holding', 'route' => 'shares-transfer.index'],
            // ['title' => 'Share Certificates', 'route' => 'share-certificates.index'],
            // ['title' => 'Share Transfer History', 'route' => 'share_transfer_histories.index'],
            ['title' => 'Form 15G/15H', 'route' => 'form15g15h.index'],
        ]
    ],
    [
        'title' => 'Account',
        'icon' => 'las la-university',
        'position' => '5',
        'active' => '1',
        'submenu' => [
            ['title' => 'Schemes', 'route' => 'schemes.index'],
            ['title' => 'Saving A/c', 'route' => 'accounts.index'],
        ]
    ],
     [
        'title' => 'FD/ MIS Accounts',
        'icon' => 'las la-university',
        'position' => '7',
        'active' => '1',
        'submenu' => [
            // ['title' => 'Schemes', 'route' => 'fd-mis-schemes.index'],
            ['title' => 'Calculator', 'route' => 'calculator.index'],
        ]
    ],
    [
        'title' => 'Approvals',
        'icon' => 'las la-university',
        'position' => '5',
        'active' => '1',
        'submenu' => [
            ['title' => 'Pending Transactions', 'route' => 'pending-transaction.index'],
            ['title' => 'Share Transfer/ Allocation', 'route' => 'share-transfer-approval.approve_transfer'],
            ['title' => 'Reversed Transactions', 'route' => 'reverse-transaction.reverse_transaction'],
            ['title' => 'Account Approvals', 'route' => 'approveAccounts'],

            // ['title' => 'Share Surrender', 'route' => 'share-surrender.index'],
        ]
    ],
    [
        'title' => 'HR Management',
        'icon' => 'las la-user',
        'position' => '6',
        'active' => '1',
        'submenu' => [
            ['title' => 'Employees', 'route' => 'employee.index'],
        ],
    ],
      [
        'title' => 'MDS/RD/DDS Accounts',
        'icon' => 'las la-university',
        'position' => '8',
        'active' => '1',
        'submenu' => [
            // ['title' => 'Schemes', 'route' => 'fd-mis-schemes.index'],
            ['title' => 'Calculator', 'route' => 'rd-calculator.create'],
        ]
    ],

];
