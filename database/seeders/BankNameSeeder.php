<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class BankNameSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        DB::table('banks_name')->insert([
            ['name' => 'AU Small Finance Bank'],
            ['name' => 'Allahabad Bank'],
            ['name' => 'Allahabad U.P Gramin Bank'],
            ['name' => 'Ambarnath Jai Hind Cooperative Bank Limited'],
            ['name' => 'Andhra Bank'],
            ['name' => 'Airtel Payments Bank'],
            ['name' => 'Andhra Pradesh Grameena Vikas Bank Ltd'],
            ['name' => 'Ahmedabad District Co-operative Bank Ltd'],
            ['name' => 'The Ahmedabad Mercantile Co-operative Bank Ltd'],
            ['name' => 'Andhra Pragathi Grameena Bank'],
            ['name' => 'Arunachal Pradesh Rural Bank'],
            ['name' => 'Assam Gramin Vikash Bank'],
            ['name' => 'Axis Bank'],
            ['name' => 'Abhyudaya Co-operative Bank Ltd'],
            ['name' => 'Ambajogai Peoples Co-operative Bank Ltd'],
            ['name' => 'Almora Urban Co-operative Bank'],
            ['name' => 'Apna Sahakari Bank Ltd'],
            ['name' => 'Adv Shamraoji Shinde Satyashodhak Sahakari Bank Limited'],
            ['name' => 'Bandhan Bank'],
            ['name' => 'Bangiya Gramin Vikash Bank'],
            ['name' => 'Bank of Bahrain and Kuwait'],
            ['name' => 'Bank of Baroda'],
            ['name' => 'Bank of Baroda - Corporate Banking'],
            ['name' => 'Bank of Baroda - Retail Banking'],
            ['name' => 'Bank of India'],
            ['name' => 'Bank of Maharashtra'],
            ['name' => 'Baroda Gujarat Gramin Bank'],
            ['name' => 'Buldana Urban Co-operative Credit Society Ltd'],
            ['name' => 'Baroda Rajasthan Kshetriya Gramin Bank'],
            ['name' => 'Baroda UP Gramin Bank'],
            ['name' => 'Bihar Gramin Bank'],
            ['name' => 'Bombay Merchantile Bank'],
            ['name' => 'Canara Bank'],
            ['name' => 'Capital Small Finance Bank'],
            ['name' => 'Catholic Syrian Bank Limited'],
            ['name' => 'Central Bank of India'],
            ['name' => 'Central Madhya Pradesh Gramin Bank'],
            ['name' => 'Chaitanya Godavari Grameena Bank'],
            ['name' => 'Chhattisgarh Rajya Gramin Bank'],
            ['name' => 'Chungathara Service Co-operative Bank Ltd'],
            ['name' => 'Citi Bank'],
            ['name' => 'Coastal Local Area Bank Limited'],
            ['name' => 'Corporation Bank'],
            ['name' => 'Cosmos Bank'],
            ['name' => 'CSB Bank'],
            ['name' => 'Dakshin Bihar Gramin Bank'],
            ['name' => 'HSBC Bank'],
            ['name' => 'Dena Bank'],
            ['name' => 'Dena Gujarat Gramin Bank'],
            ['name' => 'Deogiri Nagari Sahakari Bank Ltd'],
            ['name' => 'Deutsche Bank'],
            ['name' => 'Development Credit Bank']

        ]);
    }
}
