<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class PayableLedgerSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {

        DB::table('payable_ledgers')->insert([
            ['name' => 'Loan Paid A/C - Loan Paid A/C (Liability)'],
            ['name' => 'Xyz - Xyz (Liability)'],
            ['name' => 'Wallet Balance - Wallet Balance (Liability)'],
            ['name' => 'Saving Accounts - Saving Accounts (Liability)'],
            ['name' => 'Fd Accounts - Fd Accounts (Liability)'],
            ['name' => 'Rd Accounts - Rd Accounts (Liability)'],
            ['name' => 'Fd Tds - Fd Tds (Liability)'],
        ]);
    }
}
