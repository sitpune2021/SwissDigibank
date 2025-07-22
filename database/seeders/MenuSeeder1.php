<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class MenuSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $menus = [
            [
                'menu' => 'Dashboard',
                'submenu' => '',
                'position' => 1,
                'link' => 'Dashboard',
                'icon'  => 'las la-home',
                'active' => 1,
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'menu' => 'Company',
                'submenu' => 'Profile',
                'position' => 2,
                'link' => 'CompanyView',
                'icon'  => 'las la-piggy-bank',
                'active' => 1,
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'menu' => 'Company',
                'submenu' => 'Branches',
                'position' => 2,
                'link' => 'ManageBranch',
                'icon'  => '',
                'active' => 1,
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'menu' => 'Company',
                'submenu' => 'Promoters',
                'position' => 2,
                'link' => 'ManagePromotor',
                'icon'  => 'las la-piggy-bank',
                'active' => 1,
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'menu' => 'Company',
                'submenu' => 'Promoter & Shareholdings',
                'position' => 2,
                'link' => 'ManageShareholding',
                'icon'  => '',
                'active' => 1,
                'created_at' => now(),
                'updated_at' => now(),
            ]
        ];

        foreach ($menus as $menu) {
            DB::table('menu')->updateOrInsert(
                ['menu' => $menu['menu'], 'submenu' => $menu['submenu'],
                'position' => $menu['position'],'link' => $menu['link'],
                'icon' => $menu['icon'],'active' => $menu['active']
                ], // condition
                array_merge($menu, [
                    // 'created_at' => now(),
                    'updated_at' => now(),
                ])
            );
        }
    }
}
