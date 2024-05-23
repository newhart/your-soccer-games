<?php

namespace Database\Seeders;

use App\Models\ClubResult;
use App\Models\CompetitionGame;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class UpdateClubResultSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $csvFile = fopen(base_path("database/data/club_result.csv"), "r");
        while (($data = fgetcsv($csvFile)) !== false) {
            $competition_game  = CompetitionGame::find($data[2]);
            if ($competition_game) {
                $club_result = ClubResult::find($data[0]);
                if ($club_result) {
                    $club_result->competition_game_id = $competition_game->id;
                    $club_result->variation_club_id = $data[1];
                    $club_result->save();
                }
            }
        }
        // closed csv file
        fclose($csvFile);
    }
}
