<?php

namespace Database\Seeders;

use App\Models\Season;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class SeasonSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $csvFile = fopen(base_path("database/data/competition_season.csv"), "r");
        $firstline = true;
        while (($data = fgetcsv($csvFile)) !== false) {
            Season::create([
                'id' => $data[0],
                'season' => $data[5],
                'competition_season_name' => $data[6],
                'start_at' => $this->date_valid($data[7]),
                'end_at' => $this->date_valid($data[8]),
                'priority' => $data[9],
                'division_number' => $data[10],
                'competition_id' => $data[1],
                'competition_type_id' => $data[2]
            ]);
            $firstline = false;
        }
        // closed csv file
        fclose($csvFile);
    }

    private function date_valid(string $date)
    {
        if (in_array('00', explode('-', $date))) {
            return now();
        }
        return $date;
    }
}
