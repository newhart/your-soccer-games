<?php

namespace App\Http\Controllers;

use App\Models\Commandes;
use App\Models\Product;
use App\Models\User;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Mail;

class TempController extends Controller
{
    public  function sendEmail()
    {
        DB::statement('SET FOREIGN_KEY_CHECKS=0;');
        $uuid = fake()->randomNumber(9);
        $cart = session()->get('cart', []);
        $client = session()->get('client', []);
        $user_ids = [] ;
        $productIds = []; 
        $valid = null ; 
        foreach ($cart as $key =>  $value) {
            $valid = $value ; 
            $product = Product::find($value['id']); 
            $user_ids[] = $product->user_id ; 
            $productIds[] = $value['id']; 
        }
        // create new commandes 
        $newcommande =  Commandes::create([
            'name' => 'haritiana',
            'last_name' => 'Randria',
            'email' => 'test@test.fr',
            'phone_number' => '12134515',
            'is_same_time' => $uuid,
            'product_id' => $valid['id'],
            'match_complet' => $valid['complet_match'],
            'hight_light' => $valid['hight_light'],
            'player' => array_key_exists('player', $valid) && $valid['player'] !== '' ? $valid['player'] : null,
        ]);
        // associate product in commandes 
        $newcommande->products()->attach($productIds); 
        $commande = Commandes::where('id' , $newcommande->id)->with('product')->first();
        if (isset($commande)) {
            // data admin
            $data["email"] = $commande['email'];
            $data["title"] = "Notification Your Soccer Games";
            $data["body"] = "Nouvelle commande";
            $data["content"] = $commande;
            $data["cart"] = $cart;

            // data user
            $data1["email"] = $commande['email'];
            $data1["title"] = "Notification Your Soccer Games";
            $data1["body"] = "Commande envoyer";
            $data1["content"] = $commande;
            $data1["cart"] = $cart;
            // send email for all  partenaire
            foreach (array_unique($user_ids) as $user) {
                $partenaire = User::where('id' , $user)
                ->where('id', '<>' , 1)
                ->first(); 
                if($partenaire){
                    // partenaire data
                    $partenaire_data["email"] = $commande['email'];
                    $partenaire_data["title"] = "Notification Your Soccer Games";
                    $partenaire_data["body"] = "Commande envoyer";
                    $partenaire_data["content"] = $commande;
                    $partenaire_data["cart"] = $this->filterArray($cart , $partenaire->id);
                    $partenaire_data['partenaire'] = $partenaire; 
                    Mail::send('mail.notification-commande-partenaire', $partenaire_data, function ($message) use ($partenaire_data, $partenaire) {
                        $message->to($partenaire->email)
                            ->subject($partenaire_data["title"]);
                    });
                }   
            }

            try {
                Mail::send('mail.notification-commande-admin', $data, function ($message) use ($data) {
                    $message->to('admin@yoursoccergames.com')
                        ->subject($data["title"]);
                }); // send email to admin 
            } catch (\Throwable $th) {
                throw $th;
            }
            try {
                Mail::send('mail.notification-commande-user', $data1, function ($message) use ($data1) {
                    $message->to($data1["email"])
                        ->subject($data1["title"]);
                });
            } catch (\Throwable $th) {
                throw $th;
            }
        }
        session()->put('cart', []);
        session()->put('total', 0);
        session()->put('client', []);
        return redirect()->route('index')->with('success-store-commande' , 'Payment fait avec success!') ;
    }

    private function filterArray(array $cart, int $user_id){
        $result = array_filter($cart, function($item) use($user_id) {
            return $item["user_id"] == $user_id;
        });
        return $result ; 
    }
}
