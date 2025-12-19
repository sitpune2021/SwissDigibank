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
            ['title' => 'UNENCUMBERED DEPOSITS', 'route' => 'unencumbered-deposits.index'],
            ['title' => 'BANK ACCOUNT', 'route' => 'bank-account.index'],

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
            ['title' => 'ACCOUNTS', 'route' => 'gold-loan.account.index'],
            ['title' => 'ORNAMENTS INVENTORY', 'route' => 'gold-loan.ornaments.index'],
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
        'title' => 'CC / OD  LIMIT',
        'icon' => 'las la-university',
        'position' => '9',
        'active' => '1',
        'submenu' => [
            ['title' => 'SCHEMES', 'route' => 'cc_od.schemes.index'],
            ['title' => 'APPLICATIONS', 'route' => 'cc_od.applications.index'],
            ['title' => 'DISBURSEMENTS', 'route' => 'cc_od.disbursements.index'],
            ['title' => 'ACCOUNTS', 'route' => 'cc_od.account.index'],
        ],
    ],
    [
        'title' => 'DAILY / WEEKLY LOAN',
        'icon' => 'las la-university',
        'position' => '9',
        'active' => '1',
        'submenu' => [
            ['title' => 'SCHEMES', 'route' => 'daily_weekly.schemes.index'],
            ['title' => 'APPLICATIONS', 'route' => 'daily_weekly.applications.index'],
            ['title' => 'DISBURSEMENTS', 'route' => 'daily_weekly.disbursements.index'],
            ['title' => 'ACCOUNTS', 'route' => 'daily_weekly.account.index'],
        ],
    ],
    [
        'title' => 'PERSONAL LOAN',
        'icon' => 'las la-university',
        'position' => '9',
        'active' => '1',
        'submenu' => [
            ['title' => 'SCHEMES', 'route' => 'personal.schemes.index'],
            ['title' => 'CALCULATOR', 'route' => 'personal.calculator.index'],
            ['title' => 'APPLICATIONS', 'route' => 'personal.applications.index'],
            ['title' => 'DISBURSEMENTS', 'route' => 'personal.disbursements.index'],
            ['title' => 'ACCOUNTS', 'route' => 'personal.account.index'],
        ],
    ],
    [
        'title' => 'VEHICLE LOAN',
        'icon' => 'las la-university',
        'position' => '9',
        'active' => '1',
        'submenu' => [
            ['title' => 'SCHEMES', 'route' => 'vehical.schemes.index'],
            ['title' => 'CALCULATOR', 'route' => 'vehical.calculator.index'],
            ['title' => 'APPLICATIONS', 'route' => 'vehical.applications.index'],
            ['title' => 'DISBURSEMENTS', 'route' => 'vehical.disbursements.index'],
            ['title' => 'ACCOUNTS', 'route' => 'vehical.account.index'],
            ['title' => 'DISTRIBUTORS', 'route' => 'vehical.distributors.index'],
        ],
    ],
    [
        'title' => 'LOCKERS',
        'icon' => 'las la-lock',
        'position' => '9',
        'active' => '1',
        'submenu' => [
            ['title' => 'LOCKER LIST', 'route' => 'lockers.locker-list.index'],
            ['title' => 'MEMBER LOCKERS', 'route' => 'lockers.member-locker.index'],
        ],
    ],
    [
        'title' => 'PAYMENTs TO COLLECT',
        'icon' => 'las la-user',
        'position' => '9',
        'active' => '1',
        'route' => 'payments-to-collect.index'
    ],
    [
        'title' => 'PAYMENTs TO RELEASE',
        'icon' => 'las la-user',
        'position' => '9',
        'active' => '1',
        'route' => 'payments-to-release.index'
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
        'title' => 'ASSOCIATES / ADVISORS',
        'icon' => 'las la-user',
        'position' => '8',
        'active' => '1',
        'submenu' => [
            ['title' => 'RANK STRUCTURE', 'route' => 'associates-advisor.rank-structure.index'],
            ['title' => 'COMMISSION CHARTS', 'route' => 'associates-advisor.commission-charts.index'],
            ['title' => 'ASSOCIATES/ADVISORS', 'route' => 'associates-advisor.associates-advisors.index'],
            ['title' => 'COMMISSION PAYOUTS', 'route' => 'associates-advisor.commission-payout.index'],
        ],
    ],
    [
        'title' => 'HR MANAGEMENT',
        'icon' => 'las la-user',
        'position' => '6',
        'active' => '1',
        'submenu' => [
            ['title' => 'EMPLOYEES', 'route' => 'employee.index'],
            ['title' => 'ATTENDANCE', 'route' => 'hr-management.attendance.index'],
            ['title' => 'SALARY DISBURSEMENTS', 'route' => 'hr-management.salary-disbursement.index'],

        ],
    ],
    [
        'title' => 'PASSBOOK',
        'icon' => 'las la-book',
        'position' => '5',
        'active' => '1',
        'route' => 'passbook.index',
    ],
    [
        'title' => 'REPORTS',
        'icon' => 'las la-user',
        'position' => '10',
        'active' => '1',
        'submenu' => [
            ['title' => 'PROMOTERS/CUSTOMERS', 'route' => 'report.promoter-member'],
            ['title' => 'SHARE HOLDINGS', 'route' => 'report.share-holdings'],
            ['title' => 'SHARE TRANSFER HISTORY', 'route' => 'report.share-transfer-history'],
            ['title' => 'SAVING ACCOUNTS', 'route' => 'report.saving-account'],
            ['title' => 'FD ACCOUNTS', 'route' => 'report.fd-account'],
            ['title' => 'MIS ACCOUNTS', 'route' => 'report.mis-account'],
            ['title' => 'DD ACCOUNTS', 'route' => 'report.dd-accounts'],
            ['title' => 'RD ACCOUNTS', 'route' => 'report.rd-account'],
            ['title' => 'GOLD LOAN ACCOUNTS', 'route' => 'report.gold-loan-account'],
            ['title' => 'PROPERTY LOAN ACCOUNTS', 'route' => 'report.mortgage-loan-account'],
            ['title' => 'DEPOSIT LOAN ACCOUNTS', 'route' => 'report.loanagainst-account'],
            ['title' => 'BUSINESS LOAN ACCOUNTS', 'route' => 'report.business-loan-account'],
            ['title' => 'PERSONAL LOAN ACCOUNTS', 'route' => 'report.personal-loan-account'],
            ['title' => 'DAILY WEEKLY LOAN ACCOUNTS', 'route' => 'report.daily_weekly-loan-account'],
            ['title' => 'VEHICLE LOAN ACCOUNTS', 'route' => 'report.vehical-loan-account'],
            ['title' => 'CC OD LOAN ACCOUNTS', 'route' => 'report.cc_od-loan-account'],
        ],
    ],
    [
        'title' => 'ACCOUNTS',
        'icon' => 'las la-user',
        'position' => '9',
        'active' => '1',
        'submenu' => [
            // ['title' => 'TREE', 'route' => 'tree.index'],
            ['title' => 'VENDORS', 'route' => 'vendors.index'],
            ['title' => 'LEDGER GROUPS', 'route' => 'ledger-group.index'],
            ['title' => 'LEDGERS', 'route' => 'ledger.index'],
            // ['title' => 'ENTRIES', 'route' => 'entries.index'],
            // ['title' => 'TRIAL BALANCE', 'route' => 'trial-balance.index'],
            // ['title' => 'PROFIT AND LOSS(P & L)', 'route' => 'profit-loss.index'],
            // ['title' => 'INCOME STATEMENT', 'route' => 'income-statement.index'],
            // ['title' => 'BALANCE SHEET', 'route' => 'balance-sheet.index'],
            // ['title' => 'FY REPORT', 'route' => 'fy-report.index'],
        ],
    ],

    // [
    //     'title' => 'NEW JOURNAL ENTRY',
    //     'icon' => 'las la-user',
    //     'position' => '9',
    //     'active' => '1',
    //     'route' => 'journal-entry.index'

    // ],
    // [
    //     'title' => 'DAY BOOK',
    //     'icon' => 'las la-user',
    //     'position' => '9',
    //     'active' => '1',
    //     'route' => 'day-book.index'

    // ],
    // [
    //     'title' => 'SCHEDULE SMS',
    //     'icon' => 'las la-user',
    //     'position' => '9',
    //     'active' => '1',
    //     'route' => 'schedule-sms.index'

    // ],
    // [
    //     'title' => 'REPORTS',
    //     'icon' => 'las la-user',
    //     'position' => '9',
    //     'active' => '1',
    //     'submenu' => [
    //         ['title' => 'ASSOCIATE REPORT', 'route' => 'associate-report.index'],
    //         ['title' => 'BRANCH REPORT', 'route' => 'branch-report.index'],
    //         ['title' => 'MATURITY REPORT', 'route' => 'maturity-report.index'],
    //         ['title' => 'LOAN REPORT', 'route' => 'loan-report.index'],
    //     ],
    // ],
    // [
    //     'title' => 'DAILY COLLECTION',
    //     'icon' => 'las la-user',
    //     'position' => '9',
    //     'active' => '1',
    //     'submenu' => [
    //         ['title' => 'DASHBOARD', 'route' => 'dashboard.index'],
    //         ['title' => 'ASSOCIATE COLLECTION APPROVAL', 'route' => 'associate-approvals.index'],
    //         ['title' => 'ASSOCIATE COLLECTION REPORT', 'route' => 'associate-report.index'],
    //         ['title' => 'COLLECTION REPORT', 'route' => 'collection-report.index'],
    //         ['title' => 'ACTIVE ASSOCIATE', 'route' => 'active-associate.index'],
    //         ['title' => ' ASSOCIATE COLLECTION LIMIT', 'route' => 'associate-limit.index'],
    //     ],
    // ],

];
