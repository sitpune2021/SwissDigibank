<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Role;
use Spatie\Permission\Models\Permission;
use App\Models\User;
use Illuminate\Support\Facades\Hash;

class RolePermissionSeeder extends Seeder
{
    public function run(): void
    {
        // ✅ Step 1: Create Permissions First
        $permissions = [
            'manage_companies',
            'manage_branches',
            'manage_members',
            'view_reports',
            'approve_loans',
            'create_member',
            'view_own_profile',
        ];

        foreach ($permissions as $permission) {
            Permission::firstOrCreate(['name' => $permission, 'guard_name' => 'web']);
        }

        // ✅ Step 2: Create Roles
        $roles = ['Super Admin', 'Company', 'Branch', 'Member'];

        foreach ($roles as $role) {
            Role::firstOrCreate(['name' => $role, 'guard_name' => 'web']);
        }

        // ✅ Step 3: Assign Permissions to Roles
        foreach ($roles as $roleName) {
            $role = Role::where('name', $roleName)->first();

            if ($roleName === 'Super Admin') {
                $role->syncPermissions(Permission::all());
            } elseif ($roleName === 'Company') {
                $role->syncPermissions(['manage_branches', 'manage_members', 'view_reports']);
            } elseif ($roleName === 'Branch') {
                $role->syncPermissions(['create_member']);
            } elseif ($roleName === 'Member') {
                $role->syncPermissions(['view_own_profile']);
            }
        }

        // ✅ Step 4: Create Super Admin User
        $user = User::firstOrCreate(
            ['email' => 'admin@gmail.com'],
            [
                'name' => 'Super Admin',
                'fname' => 'Anuradha',
                'lname' => 'Jamdade',
                'mobile' => 9503654539,
                'password' => Hash::make('123456'),
                'role_id' => 1,  // Optional, only if your users table has role_id
            ]
        );

        $user->assignRole('Super Admin');
    }
}
