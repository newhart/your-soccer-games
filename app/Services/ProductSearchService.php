<?php

namespace App\Services;

use App\Models\Competition;
use App\Models\Player;
use App\Models\Product;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

/**
 * Class ProductSearchService
 * @package App\Services
 */
class ProductSearchService
{
    public static function productSearch(Request $request,  int $user_id = 1): array
    {
        $latest_date = Product::query()
            ->where('user_id', $user_id)
            ->latest('date_match')
            ->first();
        $query = Product::query()
            ->oldest('date_match')
            ->with('type_match', function ($q) {
                $q->with('prix_match');
            });

        if($user_id !== 1){
            $query = $query->where('user_id' , $user_id);
        }

        $dates = [];
        $all_date_for_play = [];
        if ($request->get('player')) {
            $player  = Player::where('full_name', 'LIKE', '%' . $request->get('player') . '%')->with('country')->first();
            if ($player){
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
            }

            $dates = array_unique($dates);

            if (count($dates) === 0) {
                $dates = [now(), now()];
            }
            if(count($all_date_for_play)){
                // get in the product all data equals of the date and name of the club or of the country
                $query = $query->where(function ($query) use ($all_date_for_play) {
                    $query->where(function ($query) use ($all_date_for_play) {
                        $conditions = [];
                        foreach ($all_date_for_play as $date => $visitor) {
                            $conditions[] = sprintf("(date_match = '%s' AND (visitor = '%s' OR residence = '%s'))", $date, $visitor, $visitor);
                        }
                        $query->orWhereRaw(implode(' OR ', $conditions));
                    });
                });
            }else {
                $query = $query->where('date_match', 'false');
            }
        }
        if ($request->get('competition')) {
            $competition_date = [];
            $competition = Competition::where('name', 'LIKE', '%' . $request->get('competition') . '%')
                ->whereHas('season')
                ->with('season')
                ->first();
            foreach ($competition->season as $season) {
                array_push($competition_date, date($season->start_at), date($season->end_at));
            }
            if (count($competition_date) > 0) {
                $query = $query->whereIn('date_match', array_unique($competition_date));
            } else {
                $query = $query
                    ->where('competition', 'LIKE', '%' . $request->get('competition') . '%');
            }
        }
        if ($request->get('date')) {
            $query = $query
                ->where('saison', 'LIKE', '%' . $request->get('date') . '%')
                ->whereYear('date_match', $request->get('date'));
        }
        if ($request->get('club')) {
            $name_of_the_club  = $request->get('club') === 'Paris S-G' ? 'PSG' : $request->get('club');
            if ($name_of_the_club !== 'FC Barcelone') {
                $name_of_the_club =  trim(str_replace('FC', '', $name_of_the_club));
            }
            if ($name_of_the_club === 'Thonon Evian') {
                $name_of_the_club = 'EVIAN TG';
            }
            $query =  $query->where(function ($query) use ($name_of_the_club) {
                $query->where('visitor', 'LIKE', '%' . strtoupper($name_of_the_club) . '%')
                    ->orWhere('residence', 'LIKE', '%' . strtoupper($name_of_the_club) . '%');
            });
        }

        if ($request->get('country')) {
            $query  = $query
                ->where(function ($query) use ($request) {
                    $query->where('residence',  $request->get('country'))
                        ->orWhere('visitor', $request->get('country'));
                });
        }

        if ($request->get('country') && $request->get('club')) {
            $query  = $query
                ->where(function ($query) use ($request) {
                    $query->where(function ($query) use ($request) {
                        $query->where('residence',  $request->get('country'))
                            ->orWhere('visitor', $request->get('country'));
                    });
                })
                ->orWhere(function ($query) use ($name_of_the_club) {
                    $query->where('residence',  $name_of_the_club)
                        ->orWhere('visitor', $name_of_the_club);
                });
        }

        $all_products = $query
            ->paginate(102);

        $oldest_date = Product::query()
            ->where('user_id', $user_id)
            ->oldest('date_match')
            ->first();
        if (isset($dates) && count($dates) > 0) {
            $latest_date = $dates[0];
            $oldest_date = end($dates);
            $date_interval = [str_split($oldest_date, 4)[0], str_split($latest_date, 4)[0]];
        } else {
            if ($oldest_date) {
                $date_interval = [str_split($oldest_date['date_match'], 4)[0], str_split($latest_date['date_match'], 4)[0]];
            } else {
                $date_interval = [];
            }
        }

        return [
            'all_products' => $all_products,
            'date_interval' => $date_interval,
        ];
    }
}
