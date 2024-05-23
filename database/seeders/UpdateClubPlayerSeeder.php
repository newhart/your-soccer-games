<?php

namespace Database\Seeders;

use App\Models\Player;
use App\Models\VariationClub;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;

class UpdateClubPlayerSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $csvFile = fopen(base_path("database/data/player_club.csv"), "r");
        $firstline = true;
        while (($data = fgetcsv($csvFile)) !== false) {
            $player = Player::find($data[3]);
            $variation_club = VariationClub::query()
                ->where('id', $data[1])
                ->with('club')
                ->first();

            if ($player && $variation_club) {
                if ($data[3] !== '0000-00-00' && $data[4] !== '0000-00-00') {
                    DB::table('club_player')
                    ->where('club_id', $variation_club->club->id)
                    ->where('player_id', $player->id)
                        ->update([
                            'arrival_at' => $data[3] === '0000-00-00'  ? now() : $data[3],
                            'leaving_at' => $data[4] === '0000-00-00'  ? now() : $data[4]
                        ]);
                    $firstline = false;
                }
            }
        }
        // closed csv file
        fclose($csvFile);
    }
}
