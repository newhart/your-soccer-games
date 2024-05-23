<?php

namespace Database\Seeders;

use App\Models\Continent;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class ContinentSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Continent::truncate();
        $csvFile = fopen(base_path("database/data/continent.csv"), "r");
        $firstline = true;

        while (($data = fgetcsv($csvFile)) !== false) {
            Continent::create([
                'id' => $data[0],
                'name' => $data[1],
                'federation' => $data[2]
            ]);
            $firstline = false;
        }
        // closed csv file
        fclose($csvFile);
    }
}
