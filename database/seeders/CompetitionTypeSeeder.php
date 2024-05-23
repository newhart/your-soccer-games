<?php

namespace Database\Seeders;

use App\Models\CompetitionType;
use Illuminate\Database\Seeder;

class CompetitionTypeSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $csvFile = fopen(base_path("database/data/competition_type.csv"), "r");
        $firstline = true;
        while (($data = fgetcsv($csvFile)) !== false) {
            CompetitionType::create([
                'id' => $data[0],
                'name' => $data[1],
            ]);
            $firstline = false;
        }
        // closed csv file
        fclose($csvFile);
    }
}
