<?php

namespace Database\Seeders;

// use Illuminate\Database\Console\Seeds\WithoutModelEvents;

use App\Models\Commandes;
use App\Models\Country;
use App\Models\PrixMatch;
use App\Models\Competition;
use App\Models\Moment;
use App\Models\Product;
use App\Services\PlayerDateService;
use Illuminate\Database\Seeder;
use Database\Seeders\PrixMatchSeeder;
use Database\Seeders\TypeMatchSeeder;
use Database\Seeders\UserAdminSeeder;
use Database\Seeders\UpdateClubPlayerSeeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        // Moment::create([
        //     'current' => true,
        //     'video' => 'on'
        // ]);
        // Moment::create([
        //     'current' => false,
        //     'video' => 'off'
        // ]);

        // $currents = Product::where('is_right_now', true)->get();

        // foreach ($currents as $current) {
        //     $current->moment_id = 2;
        //     $current->save();
        // }
        // $this->commande_product();
        $this->call([
            // UserAdminSeeder::class,
            // ContinentSeeder::class,
            // CountrySeeder::class,
            // CitySeeder::class,
            // TypeMatchSeeder::class,
            // PrixMatchSeeder::class,
            // ProductSeeder::class,
            // Player1::class,
            // Player2::class,
            // Player3::class,
            // Player4::class,
            // Player5::class,
            // Player6::class,
            // ClubSeeder::class,
            // CompetitionSeeder::class,
            // CompetitionTypeSeeder::class,
            // SeasonSeeder::class,
            // RegularSeeder::class,
            // FullNamePlayerSeeder::class,
            // VariationClubSeeder::class,
            // AddCompetionSeeder::class,
            // ClubPlayerSeeder::class,
            // UpdateClubPlayerSeeder::class,
            // CompetitionGameSeeder::class,
            // ClubCompetitionGameSeeder::class,
            // ClubResultSeeder::class,
            // ClubResultPlayerSeeder::class,
            // UpdateClubResultSeeder::class,
            PartenaireProductSeeder::class
        ]);
    }

    public function commande_product()
    {
        DB::statement('SET FOREIGN_KEY_CHECKS=0;');
        $commandes = Commandes::groupBy('is_same_time')->get();
        dd($commandes);
        $datas = [];
        foreach ($commandes as $commande) {
            if (!array_key_exists($commande->id, $datas)) {
                $datas[$commande->id][] = $commande->product_id;
            }
            // $exist = DB::table('commande_product')
            // ->where('commandes_id', $commande->id)
            // ->where('product_id', $commande->product_id)
            // ->first();
            // if(!$exist){
            //     DB::table('commande_product')->insert([
            //         'commandes_id' => $commande->id,
            //         'product_id' => $commande->product_id
            //     ]);
            // }
        }
        dd($datas);
    }

    private function remove_data_partenaire()
    {
        $products = Product::where('user_id', 20)->get();
        foreach ($products as $product) {
            $product->delete();
        }
    }
}
