<?php

namespace Database\Seeders;

use App\Models\Competition;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class CompetitionSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $csvFile = fopen(base_path("database/data/competition_profile.csv"), "r");
        $firstline = true;
        while (($data = fgetcsv($csvFile)) !== false) {
            Competition::create([
                'id' => $data[0],
                'name' => $data[1],
                'country_id' => $data[4] == 0 ?  219 : $data[4]
            ]);
            $firstline = false;
        }
        // closed csv file
        fclose($csvFile);
    }
}
