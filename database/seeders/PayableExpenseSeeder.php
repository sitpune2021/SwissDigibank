<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class PayableExpenseSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        DB::table('payable_expenses')->insert([
            ['name' => 'Late Payment Charges AC - Late Payment Charges AC (Expense)'],
            ['name' => 'Office Expence  - Office Expence  (Expense)'],
            ['name' => 'Employee Salary - Employee Salary (Expense)'],
            ['name' => 'Govind - Govind (Expense)'],
            ['name' => 'Electricity - Electricity (Expense)'],
            ['name' => 'Commission - Commission (Expense)'],
            ['name' => 'Razorpay Auto Collect Charges - Razorpay Sc Charges (Expense)'],
            ['name' => 'Cashback - Cashback (Expense)'],
            ['name' => 'Depreciation - Deprication (Expense)'],
            ['name' => 'Saving Interest - Saving Interest (Expense)'],
            ['name' => 'Fd Interest - Fd Interest (Expense)'],
            ['name' => 'Rd Interest - Rd Interest (Expense)'],
            ['name' => 'Salary - Salary (Expense)'],
            ['name' => 'Boarding Expenses - Boarding Expenses (Expense)'],
            ['name' => 'Employees  Salaries - Employees  Salaries (Expense)'],
            ['name' => 'Ramesh Nath - Ramesh Nath (Expense)'],
        ]);
    }
}
