<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class PermissionSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $permissions = [
            // Dashboard Access
            ['name' => 'view_dashboard', 'description' => 'View Dashboard', 'guard_name' => 'web'],
 
            // Accounts Management
            ['name' => 'create_account', 'description' => 'Create Account', 'guard_name' => 'web'],
            ['name' => 'view_account', 'description' => 'View Account','guard_name' => 'web'],
            ['name' => 'edit_account', 'description' => 'Edit Account','guard_name' => 'web'],
            ['name' => 'delete_account', 'description' => 'Delete Account','guard_name' => 'web'],
 
            // Member Management
            ['name' => 'create_member', 'description' => 'Create Member','guard_name' => 'web'],
            ['name' => 'view_member', 'description' => 'View Member','guard_name' => 'web'],
            ['name' => 'edit_member', 'description' => 'Edit Member','guard_name' => 'web'],
            ['name' => 'delete_member', 'description' => 'Delete Member','guard_name' => 'web'],
        ];

        DB::table('permissions')->insert($permissions);
        
    }
}
