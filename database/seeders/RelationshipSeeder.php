<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use App\Models\Relation;

class RelationshipSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $relations = [
            'Father',
            'Mother',
            'Brother',
            'Sister',
            'Spouse',
        ];

        foreach ($relations as $relation) {
            Relation::create(['relation' => $relation]);
        }
    }
}
