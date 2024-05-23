<?php

namespace Database\Seeders;

use App\Models\Product;
use App\Services\CsvService;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Faker\Factory as Faker;
use Illuminate\Support\Str;

class Partenaire1Seeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $faker = Faker::create();
        $products =  CsvService::readCSV('app/partenaires1.csv');
        // $user = User::where('email', 's.maurel2208@gmail.com')->first();
        foreach ($products as $key => $product) {
            // if ($key == 0) continue;
            Product::create([
                'image' => $faker->imageUrl($width = 400, $height = 400),
                'matchs' =>  Str::slug($product['EQUIPO 1'] . ' vs ' . $product['EQUIPO 2']),
                'n_disque' => $product['DVD'],
                // 'pays' => $product['COMMENTARY LANGUAGE'],
                'genre' => 'homme',
                'short_description' =>  $faker->sentence(3),
                'saison' => $product['TEMPORADA'],
                'residence' => $product['EQUIPO 1'],
                'visitor' => $product['EQUIPO 2'],
                'journey' => 'Unknown',
                'user_id' => 7,
                'canal' => $product['CANAL TV'],
                'competition' => $product['COMPETICION'],
                'date_match' => $this->parseDate(str_replace('.', ':', $product['FECHA'])),
                'result' => $product['RESULTADO'],
                'slug' => Str::slug($product['EQUIPO 1'] . ' vs ' . $product['EQUIPO 2']) . uniqid(),
                'is_right_now' => false,
                'format' => 'mp4',
                'langue' => $product['AUDIO']
            ]);
        }
    }

    private function parseDate(string $data): string
    {
        $date_parse  = explode(':',  $data);
        if (count($date_parse) === 3 && strlen($date_parse[2]) === 4) {
            $day = $date_parse[0] === '0' ? '01' : $this->validateDay($date_parse[0]);
            $date =  $date_parse[2] . '-' . $this->validateMonth($date_parse[1])  . '-' . $day;
            return $date;
        }
        return '2009-01-01';
    }

    private function validateDay($day)
    {
        if ($day === '00') {
            return '01';
        }
        if (strlen($day) === 1) {
            if ('0' . $day  === '00') {
                return '01';
            }
            return '0' . $day;
        }
        if ((int) $day >= 31) {
            return '30';
        }
        return trim($day);
    }
    private function validateMonth($month)
    {
        if ($month === '00') {
            return '01';
        }
        if (strlen($month) === 1) {
            if ('0' . $month  === '00') {
                return '01';
            }
            return '0' . $month;
        }
        if ((int) $month > 12 || (int) $month === 0) {
            return '12';
        }
        return trim($month);
    }
}
