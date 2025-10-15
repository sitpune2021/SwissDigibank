<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\DB;
use App\Models\Menu;

class MenuSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        Schema::disableForeignKeyConstraints();

        DB::table('sub_menuses')->truncate();
        DB::table('menus')->truncate();

        Schema::enableForeignKeyConstraints();

        $menus = config('menu');

        DB::transaction(function () use ($menus) {
            foreach ($menus as $menuData) {
                $menu = Menu::updateOrCreate(
                    ['title' => $menuData['title']],
                    [
                        'icon' => $menuData['icon'] ?? null,
                        'route' => $menuData['route'] ?? null,
                        'position' => $menuData['position'] ?? null,
                        'active' => $menuData['active'] ?? null,
                    ]
                );

                if (!empty($menuData['submenu'])) {
                    $submenuTitles = collect($menuData['submenu'])->pluck('title')->toArray();

                    // Delete submenus not in config
                    $menu->submenus()->whereNotIn('title', $submenuTitles)->delete();

                    // Upsert submenus
                    foreach ($menuData['submenu'] as $submenuData) {
                        $menu->submenus()->updateOrCreate(
                            ['title' => $submenuData['title']],
                            ['route' => $submenuData['route'] ?? null]
                        );
                    }
                } else {
                    // Delete all submenus if none in config
                    $menu->submenus()->delete();
                }
            }
        });
    }
}
