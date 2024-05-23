<?php

namespace Database\Seeders;

use App\Models\CompetitionGame;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class CompetitionGameSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $csvFile = fopen(base_path("database/data/competition_game.csv"), "r");
        $firstline = true;
        while (($data = fgetcsv($csvFile)) !== false) {
            CompetitionGame::create([
                'id' => $data[0],
                // 'season_id' => $data[1],
                'duration_game' => $data[2],
                'game_date' => $data[4],
                'game_hour' => $data[5],
                'attendace' => $data[6],
                'num_match' => $data[10],
                'type_match' => $data[11],
            ]);
            $firstline = false;
        }
        // closed csv file
        fclose($csvFile);
    }
}
