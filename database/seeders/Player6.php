<?php

namespace Database\Seeders;

use App\Models\Player;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class Player6 extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $csvFile = fopen(base_path("database/data/player6.csv"), "r");
        $firstline = true;
        while (($data = fgetcsv($csvFile)) !== false) {
            $player = Player::create([
                'id' => $data[0],
                'last_name' => $data[1],
                'first_name' => $data[2],
                'birth_date' => $this->par_date_birth_day($data[3]),
                'birth_place' => $data[4],
                'country_id' => $data[8] == 0 ? 34 : $data[8],
                'is_woman' => $data[11],
            ]);
            $player->profile()->create([
                'heigth' => $data[5],
                'wieght' => $data[6],
                'is_public' => $data[10],
                'twitter' => $data[12]
            ]);
            $firstline = false;
        }
        // closed csv file
        fclose($csvFile);
    }

    private function par_date_birth_day($date)
    {
        $parse_date = explode('-', $date);
        if ($date === '0000-00-00' || $parse_date[1] === '00' || $parse_date[2] === '00') {
            return now();
        }
        return $date;
    }
}
