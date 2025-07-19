<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use App\Models\Bank;

class BankNameSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $banks = [
             'AU Small Finance Bank',
             'Allahabad Bank',
             'Allahabad U.P Gramin Bank',
             'Ambarnath Jai Hind Cooperative Bank Limited',
             'Andhra Bank',
             'Airtel Payments Bank',
             'Andhra Pradesh Grameena Vikas Bank Ltd',
             'Ahmedabad District Co-operative Bank Ltd',
             'The Ahmedabad Mercantile Co-operative Bank Ltd',
             'Andhra Pragathi Grameena Bank',
             'Arunachal Pradesh Rural Bank',
             'Assam Gramin Vikash Bank',
             'Axis Bank',
             'Abhyudaya Co-operative Bank Ltd',
             'Ambajogai Peoples Co-operative Bank Ltd',
             'Almora Urban Co-operative Bank',
             'Apna Sahakari Bank Ltd',
             'Adv Shamraoji Shinde Satyashodhak Sahakari Bank Limited',
             'Bandhan Bank',
             'Bangiya Gramin Vikash Bank',
             'Bank of Bahrain and Kuwait',
             'Bank of Baroda',
             'Bank of Baroda - Corporate Banking',
             'Bank of Baroda - Retail Banking',
             'Bank of India',
             'Bank of Maharashtra',
             'Baroda Gujarat Gramin Bank',
             'Buldana Urban Co-operative Credit Society Ltd',
             'Baroda Rajasthan Kshetriya Gramin Bank',
             'Baroda UP Gramin Bank',
             'Bihar Gramin Bank',
             'Bombay Merchantile Bank',
             'Canara Bank',
             'Capital Small Finance Bank',
             'Catholic Syrian Bank Limited',
             'Central Bank of India',
             'Central Madhya Pradesh Gramin Bank',
             'Chaitanya Godavari Grameena Bank',
             'Chhattisgarh Rajya Gramin Bank',
             'Chungathara Service Co-operative Bank Ltd',
             'Citi Bank',
             'Coastal Local Area Bank Limited',
             'Corporation Bank',
             'Cosmos Bank',
             'CSB Bank',
             'Dakshin Bihar Gramin Bank',
             'HSBC Bank',
             'Dena Bank',
             'Dena Gujarat Gramin Bank',
             'Deogiri Nagari Sahakari Bank Ltd',
             'Deutsche Bank',
             'Development Credit Bank'

        ];

        foreach ($banks as $bank) {
            Bank::create(['name' => $bank]);
        }
    }
}
