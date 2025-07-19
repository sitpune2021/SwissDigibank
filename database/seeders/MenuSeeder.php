<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\Menu;

class MenuSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $menus = config('menu');

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

                // Delete submenus that are no longer in config
                $menu->submenus()->whereNotIn('title', $submenuTitles)->delete();

                // Upsert submenus from config
                foreach ($menuData['submenu'] as $submenuData) {
                    $menu->submenus()->updateOrCreate(
                        ['title' => $submenuData['title']],
                        ['route' => $submenuData['route']]
                    );
                }
            } else {
                $menu->submenus()->delete();
            }
        }
    }
}
