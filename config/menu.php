<?php

return [
    [
        'title' => 'DASHBOARD',
        'icon' => 'las la-home',
        'route' => 'index1',
        'position' => '0',
        'active' => '1'
    ],
    [
        'title' => 'COMPANY',
        'icon' => 'las la-piggy-bank',
        'position' => '2',
        'active' => '1',
        'submenu' => [
            ['title' => 'PROFILE', 'route' => 'company.index'],
            ['title' => 'BRANCHES', 'route' => 'branch.index'],
            ['title' => 'PROMOTORS', 'route' => 'promotor.index'],
            ['title' => 'PROMOTOR SHARE HOLDINGS', 'route' => 'shareholding.index'],
            ['title' => 'DIRECTOR', 'route' => 'director.index'],
        ],
    ],
    [
        'title' => 'USER',
        'icon' => 'las la-user',
        'position' => '3',
        'active' => '1',
        'submenu' => [
            ['title' => 'PERMISSION/ROLES', 'route' => 'roles.index'],
            ['title' => 'USERS', 'route' => 'users.index'],
        ],
    ],
    [
        'title' => 'CUSTOMER',
        'icon' => 'las la-piggy-bank',
        'position' => '4',
        'active' => '1',
        'submenu' => [
            ['title' => 'CUSTOMERS', 'route' => 'member.index'],
            ['title' => 'MINORS', 'route' => 'minor.index'],
            ['title' => 'SHARE HOLDING', 'route' => 'shares-transfer.index'],
            // ['title' => 'Share Certificates', 'route' => 'share-certificates.index'],
            // ['title' => 'Share Transfer History', 'route' => 'share_transfer_histories.index'],
            ['title' => 'FORM 15G/15H', 'route' => 'form15g15h.index'],
        ]
    ],
    [
        'title' => 'SAVING/CURRENT',
        'icon' => 'las la-university',
        'position' => '5',
        'active' => '1',
        'submenu' => [
            ['title' => 'SCHEMES', 'route' => 'schemes.index'],
            ['title' => 'SAVING A/C', 'route' => 'accounts.index'],
        ]
    ],
    [
        'title' => 'FD/MIS',
        'icon' => 'las la-university',
        'position' => '7',
        'active' => '1',
        'submenu' => [
            ['title' => 'SCHEMES', 'route' => 'fd-mis-schemes.index'],
            ['title' => 'CALCULATOR', 'route' => 'calculator.index'],
            ['title' => 'FD ACCOUNTS', 'route' => 'fd-mis-schemes.fd_index'],
            ['title' => 'MIS ACCOUNTS', 'route' => 'misaccount.index'],
        ]
    ],
    [
        'title' => 'MDS/RD/DDS',
        'icon' => 'las la-university',
        'position' => '7',
        'active' => '1',
        'submenu' => [
            ['title' => 'SCHEMES', 'route' => 'rdschemes.index'],
            ['title' => 'CALCULATOR', 'route' => 'rd-calculator.create'],
            ['title' => 'DDS ACCOUNTS', 'route' => 'dds-accounts.index'],
            ['title' => 'MDS / RD ACCOUNTS', 'route' => 'mds-rd-accounts.rd-account-index'],
        ]
    ],
       [
        'title' => 'GOLD LOAN',
        'icon' => 'las la-university',
        'position' => '9',
        'active' => '1',
        'submenu' => [
            ['title' => 'SCHEMES', 'route' => 'gold-loan.schemes.index'],
            ['title' => 'CALCULATOR', 'route' => 'gold-loan.calculator.index'],
            ['title' => 'APPLICATIONS', 'route' => 'gold-loan.applications.index'],
            ['title' => 'DISBURSEMENTS', 'route' => 'gold-loan.disbursements.index'],
            ['title' => 'ORNAMENTS INVENTORY', 'route' => 'gold-loan.ornaments.index'],
            ['title' => 'ACCOUNTS', 'route' => 'gold-loan.account.index'],
        ],
    ],
     [
        'title' => 'PROP./MORTGAGE LOAN',
        'icon' => 'las la-university',
        'position' => '9',
        'active' => '1',
        'submenu' => [
            ['title' => 'SCHEMES', 'route' => 'mortgage.schemes.index'],
            ['title' => 'CALCULATOR', 'route' => 'mortgage.calculator.index'],
            ['title' => 'APPLICATIONS', 'route' => 'mortgage.applications.index'],
            ['title' => 'DISBURSEMENTS', 'route' => 'mortgage.disbursements.index'],
            ['title' => 'ACCOUNTS', 'route' => 'mortgage.account.index'],
            ['title' => 'LIEN PROPERTY REPORT', 'route' => 'mortgage.lineproperty.index'],
        ],
    ],
    [
        'title' => 'LOAN AGAINST DEPOSIT',
        'icon' => 'las la-university',
        'position' => '9',
        'active' => '1',
        'submenu' => [
            ['title' => 'SCHEMES', 'route' => 'loanagainst.schemes.index'],
            ['title' => 'CALCULATOR', 'route' => 'loanagainst.calculator.index'],
            ['title' => 'APPLICATIONS', 'route' => 'loanagainst.applications.index'],
            ['title' => 'DISBURSEMENTS', 'route' => 'loanagainst.disbursements.index'],
            ['title' => 'ACCOUNTS', 'route' => 'loanagainst.account.index'],
            ['title' => 'LIEN DEPOSITS REPORT', 'route' => 'loanagainst.lineproperty.index'],
        ],
    ],
    [
        'title' => 'BUSINESS LOAN',
        'icon' => 'las la-university',
        'position' => '9',
        'active' => '1',
        'submenu' => [
            ['title' => 'SCHEMES', 'route' => 'bussiness.schemes.index'],
            ['title' => 'CALCULATOR', 'route' => 'bussiness.calculator.index'],
            ['title' => 'APPLICATIONS', 'route' => 'bussiness.applications.index'],
            ['title' => 'DISBURSEMENTS', 'route' => 'bussiness.disbursements.index'],
            ['title' => 'ACCOUNTS', 'route' => 'bussiness.account.index'],
        ],
    ],
    [
        'title' => 'APPROVALS',
        'icon' => 'las la-university',
        'position' => '5',
        'active' => '1',
        'submenu' => [
            ['title' => 'PENDING TRANSACTIONS', 'route' => 'pending-transaction.index'],
            ['title' => 'SHARE TRANSFER/ ALLOCATION', 'route' => 'share-transfer-approval.approve_transfer'],
            ['title' => 'REVERSED TRANSACTIONS', 'route' => 'reverse-transaction.reverse_transaction'],
            ['title' => 'ACCOUNT APPROVALS', 'route' => 'approveAccounts'],
            ['title' => 'LOAN APPLICATION', 'route' => 'loans'],
            // ['title' => 'Share Surrender', 'route' => 'share-surrender.index'],
        ]
    ],
    [
        'title' => 'HR MANAGEMENT',
        'icon' => 'las la-user',
        'position' => '6',
        'active' => '1',
        'submenu' => [
            ['title' => 'EMPLOYEES', 'route' => 'employee.index'],
        ],
    ],

];
