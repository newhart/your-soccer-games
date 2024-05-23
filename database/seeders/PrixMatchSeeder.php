<?php

namespace Database\Seeders;

use App\Models\PrixMatch;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class PrixMatchSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        PrixMatch::create([
            'prix' => 0,
            'type_match_id' => 1
        ]);
        PrixMatch::create([
            'prix' => 0,
            'type_match_id' => 2
        ]);
    }
}
