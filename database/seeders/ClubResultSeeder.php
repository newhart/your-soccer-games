<?php

namespace Database\Seeders;

use App\Models\ClubResult;
use App\Models\CompetitionGame;
use App\Models\VariationClub;
use Illuminate\Database\Seeder;

class ClubResultSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $csvFile = fopen(base_path("database/data/club_result.csv"), "r");
        while (($data = fgetcsv($csvFile)) !== false) {
            $variation_club  = VariationClub::query()
                ->where('id', $data[1])
                ->with('club')
                ->first();
            $competition_game  = CompetitionGame::find($data[2]);
            $exits = ClubResult::find($data[0]);
            if ($variation_club && $competition_game) {
                if (!$exits) {
                    ClubResult::create([
                        'id' => $data[0],
                        'competition_game_id' => $competition_game->id,
                        'club_id' => $variation_club->club->id,
                        'variation_club_id' => $data[1]
                    ]);
                }
            }
        }
        // closed csv file
        fclose($csvFile);
    }
}
