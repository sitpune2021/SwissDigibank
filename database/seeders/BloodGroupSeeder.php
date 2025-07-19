<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use App\Models\BloodGroup;

class BloodGroupSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $bloods = [
             'A+',
             'A-',
             'B+',
             'B-',
             'AB+',
             'AB-',
             'O+',
             'O-',
        ];
        foreach ($bloods as $blood) {
            BloodGroup::create(['group' => $blood]);
        }
    }
}
