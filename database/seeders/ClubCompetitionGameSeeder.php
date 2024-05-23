<?php

namespace Database\Seeders;

use App\Models\CompetitionGame;
use App\Models\VariationClub;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class ClubCompetitionGameSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $csvFile = fopen(base_path("database/data/club_reslut.csv"), "r");
        while (($data = fgetcsv($csvFile)) !== false) {
            $variation_club  = VariationClub::query()
                ->where('id', $data[1])
                ->with('club')
                ->first();
            $competition_game = CompetitionGame::find($data[2]);
            if ($variation_club && $competition_game) {
                DB::table('club_competition_game')
                    ->insert([
                        'id' => $data[0],
                        'club_id' => $variation_club->club->id,
                        'competition_game_id' => $competition_game->id,
                        'goal_for' => $data[3],
                        'goals_against' => $data[4],
                        'halftime1' => $data[5],
                        'halftime2' => $data[6],
                        'home' => $data[11],
                    ]);
            }
        }
        // closed csv file
        fclose($csvFile);
    }
}
