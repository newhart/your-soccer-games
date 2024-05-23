<?php

namespace Database\Seeders;

use App\Models\Player;
use App\Models\VariationClub;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class ClubPlayerSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $csvFile = fopen(base_path("database/data/player_club.csv"), "r");
        $firstline = true;
        while (($data = fgetcsv($csvFile)) !== false) {
            $player = Player::find($data[1]);
            $variation_club = VariationClub::query()
                ->where('id', $data[2])
                ->with('club')
                ->first();
            if ($player && $variation_club) {
                DB::table('club_player')
                    ->insert([
                        'club_id' => $variation_club->club->id,
                        'player_id' => $player->id, 
                        'arrival_at' => $data[3] === '0000-00-00'  ? now() : $this->parseDate($data[3]),
                        'leaving_at' => $data[4] === '0000-00-00'  ? now() : $this->parseDate($data[4])
                    ]);
                $firstline = false;
            }
        }
        // closed csv file
        fclose($csvFile);
    }

    private function parseDate(string $data): string
    {
        $date_parse  = explode('-',  $data);
        if ($date_parse[0] === '0000' || $date_parse[1] === '00' || $date_parse[2] === '00' ) {
            return now();
        }
        return $data; 
        
    }
}
