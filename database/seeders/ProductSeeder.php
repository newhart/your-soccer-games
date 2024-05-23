<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;

use App\Models\Product;
use Illuminate\Database\Seeder;
use Illuminate\Support\Str;

class ProductSeeder extends Seeder
{
    use WithoutModelEvents;
    private function parseDate(string $data): string
    {
        $date_parse  = explode(':',  $data);
        if (count($date_parse) === 3 && strlen($date_parse[2]) === 4) {
            return $date_parse[2] . '-' . $date_parse[0] . '-' . $date_parse[1];
        }
        return '2009-01-01';
    }
    public function run(): void
    {
        $csvFile = fopen(base_path("database/data/products.csv"), "r");
        $firstline = true;
        while (($data = fgetcsv($csvFile)) !== false) {
            if (!$firstline) {
                Product::create([
                    'image' => fake()->imageUrl($width = 400, $height = 400),
                    'matchs' =>  $data[2],
                    'n_disque' => $data[3],
                    'pays' => $data[4],
                    'genre' => $data[5],
                    'short_description' =>  fake()->sentence(3),
                    'saison' => $data[7],
                    'residence' => $data[11],
                    'visitor' => $data[12],
                    'journey' => $data[9],
                    'competition' => $data[8],
                    'date_match' => $this->parseDate(str_replace('/', ':', $data[6])),
                    'result' => $data[10],
                    'slug' => Str::slug($data[11] . ' vs ' . $data[12]) . uniqid(),
                    'is_right_now' => false,
                    'format' => $data[13],
                ]);
            }
            $firstline = false;
        }

        fclose($csvFile);
    }
}
