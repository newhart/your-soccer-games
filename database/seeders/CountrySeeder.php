<?php

namespace Database\Seeders;

use App\Models\Country;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class CountrySeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Country::truncate();
        $csvFile = fopen(base_path("database/data/country.csv"), "r");
        $firstline = true;
        while (($data = fgetcsv($csvFile)) !== false) {
            Country::create([
                'id' => $data[0],
                'name' => $data[1],
                'nationality' => $data[2],
                'country_flag' => $data[3],
                'logitude' => $data[4],
                'latitude' => $data[5],
                'continent_id' => ($data[6] == 0 || $data[6] > 6) ? 2 : $data[6],
                'timezone' => $data[7],
                'is_active' => $data[8]
            ]);
            $firstline = false;
        }
        // closed csv file
        fclose($csvFile);
    }
}
