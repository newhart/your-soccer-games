<?php

namespace Database\Seeders;

use App\Models\City;
use App\Models\Club;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class ClubSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $csvFile = fopen(base_path("database/data/club_profile.csv"), "r");
        $firstline = true;
        while (($data = fgetcsv($csvFile)) !== false) {
            $city  = City::find($data[4]);
            if ($city) {
                $club = Club::create([
                    'id' => $data[0],
                    'name' => $data[1],
                    'full_name' => $data[2],
                    'short_name' => $data[3],
                    'city_id' => $data[4] == 0 ? 1 : $data[4],
                    'national_team' => $data[5],
                    'zip_code' => $data[6] === '' ? null : $data[6],
                    'address' => $data[7],
                    'fundation_at' => count(explode('-', $data[8])) === 1  ? $data[8] . '01-01' : $data[8],
                    'end_at' => $data[9] === '' ? null : $data[9],
                    'website' => $data[10],
                    'first_color' => $data[11],
                    'seconds_color' => $data[12]
                ]);
                $firstline = false;
            }
        }
        // closed csv file
        fclose($csvFile);
    }
}
