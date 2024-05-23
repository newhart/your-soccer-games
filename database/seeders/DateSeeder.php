<?php

namespace Database\Seeders;

use App\Models\Date;
use App\Models\Player;
use App\Models\Product;
use Carbon\Carbon;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class DateSeeder extends Seeder
{
    use WithoutModelEvents;
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $players = Player::all();
        $latest_date = Product::query()
            ->latest('date_match')
            ->first();

        foreach ($players as $player) {
            $club_result_players = DB::select(
                "SELECT cr.id , cr.competition_game_id , competition_games.duration_game , competition_games.game_date,club_result_player.player_id ,club_result_player.substitute,
	                clubs.name , clubs.short_name , clubs.full_name, variation_clubs.club_id  as id_club
	                FROM club_results as cr
	                INNER JOIN competition_games ON competition_games.id  = cr.competition_game_id
	                INNER JOIN club_result_player ON cr.id = club_result_player.club_result_id
	                INNER JOIN variation_clubs ON cr.club_variation_id  = variation_clubs.id
	                INNER JOIN clubs ON variation_clubs.club_id = clubs.id
	                WHERE club_result_player.player_id = $player->id  AND club_result_player.substitute = '0' ;
	            "
            );

            foreach ($club_result_players as  $club_result_player) {
                $club_name  = $club_result_player->name === 'Paris S-G' ? 'PSG' : e($club_result_player->name);
                if ($club_name !== 'FC Barcelone') {
                    $club_name =  trim(str_replace('FC', '', $club_name));
                }
                if ($club_name === 'Thonon Evian') {
                    $club_name = 'EVIAN TG';
                }
                $date1 = Carbon::parse($latest_date->date_match);
                $date2 = Carbon::parse($club_result_player->game_date);

                if ($date2->lessThanOrEqualTo($date1)) {
                    $all_date_for_play[$club_result_player->game_date] = $club_name;
                }
                array_push($dates, $club_result_player->game_date);
            }

            foreach ($all_date_for_play as $key =>  $date_play) {
                $date = Date::create([
                    'club_name' => $date_play,
                    'date_playing' => $key
                ]);
                $player->dates()->attach([$date->id]);
            }
        }
    }
}
