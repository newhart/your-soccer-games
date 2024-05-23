<?php

namespace Database\Seeders;

use App\Models\Player;
use App\Models\Season;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class RegularSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $csvFile = fopen(base_path("database/data/club_regular_team.csv"), "r");
        $firstline = true;
        while (($data = fgetcsv($csvFile)) !== false) {
            $player = Player::find($data[3]);
            $season = Season::find($data[2]);
            if ($player && $season) {
                DB::table('player_season')
                    ->insert([
                        'tactical_position' => $data[4],
                        'valid' => $data[6],
                        'season_id' => $season->id,
                        'player_id' => $player->id
                    ]);
                $firstline = false;
            }
        }
        // closed csv file
        fclose($csvFile);
    }
}
