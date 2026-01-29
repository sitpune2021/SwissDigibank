<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

class RoleSeeder extends Seeder
{
    /**
     * Run the database seeds.  
     */

    public function run(): void
    {        
        Schema::disableForeignKeyConstraints();

        DB::table('roles')->truncate();

        Schema::enableForeignKeyConstraints();

        $roles = [
            [
                'name' => 'Super Admin',
                'guard_name' => 'web',
                'description' => 'Administrator with full access',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'name' => 'Manager',
                'guard_name' => 'web',
                'description' => 'Manage perticuler branch',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'name' => 'Promoter',
                'guard_name' => 'web',
                'description' => 'Promoter role with special permissions',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'name' => 'Director',
                'guard_name' => 'web',
                'description' => 'Director role for managing operations',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'name' => 'Member',
                'guard_name' => 'web',
                'description' => 'Customer role',
                'created_at' => now(),
                'updated_at' => now(),
            ],
        ];

        DB::table('roles')->insert($roles);
    }
}
