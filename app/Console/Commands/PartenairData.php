<?php

namespace App\Console\Commands;

use App\Models\Product;
use App\Models\User;
use App\Services\CsvService;
use Illuminate\Console\Command;
use Illuminate\Support\Str;

class PartenairData extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'app:partenair-data';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Command description';

    /**
     * Execute the console command.
     */
    public function handle()
    {
        $products =  CsvService::readCSV('app/partenaires2.csv');
        $user = User::where('email', 's.maurel2208@gmail.com')->first();
        foreach ($products as $key => $product) {
            Product::create([
                'image' => fake()->imageUrl($width = 400, $height = 400),
                'matchs' =>  Str::slug($product['HOST'] . ' vs ' . $product['VISITOR']),
                'n_disque' => 'Unknown',
                'pays' => $product['COMMENTARY LANGUAGE'],
                'genre' => 'homme',
                'short_description' =>  fake()->sentence(3),
                'saison' => $product['SEASON'],
                'residence' => $product['HOST'],
                'visitor' => $product['VISITOR'],
                'journey' => 'Unknown',
                'user_id' => $user->id,
                'competition' => $product['COMPETITION'],
                'date_match' => $this->parseDate(str_replace('/', ':', $product['MATCH DATE'])),
                'result' => $product['SCORE'],
                'slug' => Str::slug($product['HOST'] . ' vs ' . $product['VISITOR']) . uniqid(),
                'is_right_now' => false,
                'format' => $product['FORMAT'],
            ]);
            echo 'creating';
        }
    }

    private function parseDate(string $data): string
    {
        $date_parse  = explode(':',  $data);
        if (count($date_parse) === 3 && strlen($date_parse[2]) === 4) {
            $day = $date_parse[0] === '0' ? '01' : $date_parse[0];
            $date =  $date_parse[2] . '-' . $this->validateMonth($date_parse[1])  . '-' . $day;
            return $date;
        }
        return '2009-01-01';
    }

    private function validateMonth($month)
    {
        if ((int) $month > 12 || (int) $month === 0) {
            return '12';
        }
        return $month;
    }
}
