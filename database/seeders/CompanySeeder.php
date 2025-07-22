<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class CompanySeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        DB::table('companies')->insert([
            'user_id' => 1,
            'company_website' => 'www.xyz.com',
            'company_name' => 'SBC Global',
            'short_name' => 'SBC Global',
            'about_company' => 'SBC Global, The bank that inspire you',
            'address_line1' => 'Mumbai',
            'address_line2' => 'pune',
            'city' => 'Mumbai',
            'state' => 14,
            'pincode' => '400001',
            'country' => 'India',
            'mobile_no' => '9876543210',
            'landline_no' => '02212345678',
            'contact_email' => 'info@example.com',
            'cin_no' => 'U12345MH2020PTC123456',
            'pan_no' => 'ABCDE1234F',
            'tan_no' => 'MUMA12345B',
            'gst_no' => '27ABCDE1234F1Z5',
            'company_category' => 'Limited By Guarantee',
            'company_class' => 'Association of Persons',
            'incorporation_date' => '2020-01-15',
            'incorporation_state' => 'Maharashtra',
            'incorporation_country' => 'India',
            'authorized_capital' => 1000000.00,
            'paid_up_capital' => 1000000.00,
        ]);
    }
}
