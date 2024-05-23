<?php

namespace App\Console\Commands;

use App\Models\Player;
use App\Models\Product;
use Illuminate\Console\Command;

class PlayerProduct extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'app:player-product';

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
        $players = Player::all();
        foreach ($players as $key => $player) {
            $products = Product::where(function ($query) use ($player) {
                $conditions = [];
                foreach ($player->dates as $category) {
                    $conditions[] = sprintf("(date_match = '%s' AND (visitor = '%s' OR residence = '%s'))", $category->date_playing, $category->club_name, $category->club_name);
                }
                $query->orWhereRaw(implode(' OR ', $conditions));
            })->pluck('id')->all();
            $player->products()->sync($products);
            echo 'related with success';
        }
    }
}
