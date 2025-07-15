<?php

namespace Database\Seeders;

use App\Models\User;
// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        // User::factory(10)->create();

        // User::factory()->create([
        //     'name'=>'Super Admin',
        //     'fname' => 'Anuradha',
        //     'lname'=>'Jamdade',
        //     'email' => 'admin@gmail.com',
        //     'mobile'=>9503654539,
        //     'password'=>'123456',
        //     'role_id'=>1
        // ]);
        $this->call(MenuSeeder::class);
        $this->call(RolePermissionSeeder::class);
    }
}
