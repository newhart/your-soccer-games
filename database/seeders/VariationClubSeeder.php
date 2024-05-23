<?php

namespace Database\Seeders;

use App\Models\Club;
use App\Models\VariationClub;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class VariationClubSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $csvFile = fopen(base_path("database/data/club_variation.csv"), "r");
        $firstline = true;
        while (($data = fgetcsv($csvFile)) !== false) {
            $club = Club::find($data[1]);
            if ($club) {
                VariationClub::create([
                    'id' => $data[0],
                    'variant_name' => $data[2],
                    'short_variant_name' => $data[3],
                    'club_id' => $data[1],
                ]);
                $firstline = false;
            }
        }
        // closed csv file
        fclose($csvFile);
    }
}
