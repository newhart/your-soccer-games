<?php

namespace Database\Seeders;

use App\Models\TypeMatch;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class TypeMatchSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        TypeMatch::create([
            'name' => 'Match complet'
        ]);
        TypeMatch::create([
            'name' => 'Hight light'
        ]);
    }
}
