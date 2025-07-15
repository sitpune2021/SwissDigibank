<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class BloodGroupSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        DB::table('blood_group')->insert([
            ['group' => 'A+'],
            ['group' => 'A-'],
            ['group' => 'B+'],
            ['group' => 'B-'],
            ['group' => 'AB+'],
            ['group' => 'AB-'],
            ['group' => 'O+'],
            ['group' => 'O-'],
        ]);
    }
}
