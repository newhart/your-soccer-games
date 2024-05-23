<?php

namespace Database\Seeders;

use App\Models\ClubResult;
use App\Models\Player;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class ClubResultPlayerSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {

        $csvFile = fopen(base_path("database/data/club_result_player.csv"), "r");
        while (($data = fgetcsv($csvFile)) !== false) {
            $club_result  = ClubResult::query()
                ->where('id', $data[1])
                ->with('club')
                ->first();
            $player = Player::find($data[2]);
            if ($club_result && $player) {
                $exit = DB::table('club_result_player')
                    ->where('id', $data[0])
                    ->first();
                if (!$exit) {
                    DB::table('club_result_player')
                        ->insert([
                            'id' => $data[0],
                            'club_result_id' => $club_result->id,
                            'player_id' => $player->id,
                            'substitude' => $data[6],
                            'player_number' => $data[3]
                        ]);
                }
            }
        }
        // closed csv file
        fclose($csvFile);
    }
}
