<?php

namespace Database\Seeders;

use App\Models\Player;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class FullNamePlayerSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        for ($i = 1; $i <= 519255; $i++) {
            $player = Player::find($i);
            if ($player) {
                $player->full_name = $player->first_name . " " . $player->last_name;
                $player->save();
            }
        }
    }
}
