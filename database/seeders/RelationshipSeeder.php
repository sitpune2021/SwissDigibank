<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class RelationshipSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        DB::table('relationship')->insert([
            ['relation' => 'Father'],
            ['relation' => 'Mother'],
            ['relation' => 'Brother'],
            ['relation' => 'Sister'],
            ['relation' => 'Spouse'],
        ]);
    }
}
