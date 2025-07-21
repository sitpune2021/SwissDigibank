<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\Company;

class CompanySeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        Company::create([
            'user_id'           => 1, // Assuming a user with ID 1 exists
            'company_website'       => 'https://example.com',
            'company_name'          => 'Example Corporation',
            'short_name'            => 'ExCorp',
            'about_company'         => 'We provide exemplary services in the tech domain.',

            'address_line1'         => '123 Main Street',
            'address_line2'         => 'Suite 400',
            'city'                  => 'Metropolis',
            'state'                 => 'Metro State',
            'pincode'               => '123456',
            'country'               => 'Freedonia',

            'mobile_no'             => '9876543210',
            'landline_no'           => '01112345678',
            'contact_email'         => 'contact@example.com',

            'cin_no'                => 'U12345DL2025PTC123456',
            'pan_no'                => 'ABCDE1234F',
            'tan_no'                => 'DELX12345B',
            'gst_no'                => '22ABCDE1234F1Z5',

            'company_category'      => 'Private',
            'company_class'         => 'Class A',
            'incorporation_date'    => '2020-01-15',
            'incorporation_state'   => 'Metro State',
            'incorporation_country' => 'Freedonia',

            'authorized_capital'    => '5000000',
            'paid_up_capital'       => '2500000',
        ]);
    }
}
