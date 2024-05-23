<?php

namespace Database\Seeders;

use App\Models\Product;
use App\Models\User;
use App\Services\CsvService;
use Carbon\Carbon;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Str;

use Faker\Factory as Faker;

class PartenaireProductSeeder extends Seeder
{
    use WithoutModelEvents;
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $faker = Faker::create();
        $reader =  CsvService::readCSV('app/public/dave.csv');
        $reader->setHeaderOffset(0);
        $records = $reader->getRecords();
        // dd($records);
        // $user = User::where('email', 's.maurel2208@gmail.com')->first();
        foreach ($records as $key => $product) {
            // if ($key == 0) continue;
            // $test = Product::where('visitor', $product['VISITOR'])
            //     ->where('residence', $product['HOST'])
            //     ->first();
            // dd($this->parseDate(str_replace('/', ':', $product['MATCH DATE'])),);
            // dump($test);
            Product::create([
                'image' => $faker->imageUrl($width = 400, $height = 400),
                'matchs' =>  Str::slug($product['HOST'] . ' vs ' . $product['VISITOR']),
                'n_disque' => 'Unknown',
                'genre' => 'homme',
                'short_description' =>  $faker->sentence(3),
                'saison' => $product['SEASON'],
                'residence' => $product['HOST'],
                'visitor' => $product['VISITOR'],
                'journey' => 'Unknown',
                // 'user_id' => 20,
                'competition' => $product['COMPETITION'],
                'date_match' => $this->parseDate(str_replace('/', ':', $product['MATCH DATE'])),
                'result' => $product['SCORE'],
                'slug' => Str::slug($product['HOST'] . ' vs ' . $product['VISITOR']) . uniqid(),
                'is_right_now' => false,
                'format' => $product['FORMAT'],
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
}
