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
        $this->call(CompanySeeder::class);
        $this->call(StateSeeder::class);
        $this->call(MenuSeeder::class);
        $this->call(RolePermissionSeeder::class);
        $this->call(BankNameSeeder::class);
        $this->call(PayableLedgerSeeder::class);
        $this->call(PayableExpenseSeeder::class);
        $this->call(RelationshipSeeder::class);
        $this->call(BloodGroupSeeder::class);
    }
}
