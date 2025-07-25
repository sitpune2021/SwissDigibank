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
            ['title' => 'Promotor & Share Holdings', 'route' => 'shareholding.index'],
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
            // ['title' => 'Users', 'route' => 'users.index'],
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
            // ['title' => 'Share Holding', 'route' => 'shares-holdings.index'],
            // ['title' => 'Share Certificates', 'route' => 'share-certificates.index'],
            // ['title' => 'Share Transfer History', 'route' => 'share-transfer-histories.index'],
            // ['title' => 'Form 15G/15H', 'route' => 'form-15g-15h.index'],
        ]
    ],
    //  [
    //     'title' => 'Savings/Current AC',
    //     'icon' => 'las la-university',
    //     'position' => '5',
    //     'active' => '1',
    //     'submenu' => [
    //         ['title' => 'Schemes', 'route' => 'schemes.index'],
    //     ]
    // ],
    // [
    //     'title' => 'HR Management',
    //     'icon' => 'las la-user',
    //     'position' => '6',
    //     'active' => '1',
    //     'submenu' => [
    //         ['title' => 'Employees', 'route' => 'employee.index'],
    //     ],
    // ],



];
