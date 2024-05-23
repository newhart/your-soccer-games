<?php

namespace Database\Seeders;

use App\Models\City;
use Illuminate\Database\Seeder;

class CitySeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $csvFile = fopen(base_path("database/data/city.csv"), "r");
        $firstline = true;
        while (($data = fgetcsv($csvFile)) !== false) {
            if ((int) $data[6] !== 0) {
                City::create([
                    'id' => $data[0],
                    'name' => $data[1],
                    'zip' => $data[2],
                    'locality' => $data[3],
                    'longitude' => $data[4],
                    'latitude' => $data[5],
                    'country_id' => (int) $data[6]
                ]);
                $firstline = false;
            }
        }
        // closed csv file
        fclose($csvFile);
    }
}
