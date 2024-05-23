<?php

namespace App\Services;

use App\Models\Commandes;
use App\Models\User;
use Illuminate\Support\Facades\Mail;

/**
 * Class OrderService
 * @package App\Services
 */
class OrderService
{

    public static function storeOrder(array $carts){
        $products = []; 
        $user_ids = [] ;
        foreach ($carts as $cart) {
            $products['id'] = $cart['id']; 
            $user_ids[] = $cart->user_id ; 
            $products['player']=  array_key_exists('player', $cart) && $cart['player'] !== '' ? $cart['player'] : null ; 
        }
        $order =  self::order() ; 
        foreach ($products as $product) {
            $order->products()->attach([$product['id']]) ; // attach the product to the order
            if($product['player']){
                $order->player = $product['player']; 
                $order->save(); 
            }
        }
        $data = [
            'email' => 'test@test.fr' , 
            'title' => 'Notification Your Soccer Game', 
            'body' => 'Nouvelle commande', 
            'content' => $order , 
            'cart' => $cart 
        ]; 
        self::senEmail($data , 'mail.notification-commande-admin' , 'admin@yoursoccergames.com');
        self::senEmail($data , 'mail.notification-commande-user' , 'test@test.fr');
        self::sendEmailPartenaire($user_ids , $order, $cart);
    }

    private static function order() : Commandes {
        return   Commandes::create([
            'name' => 'Test name',
            'last_name' => 'Test first name', 
            'email' => 'test@test.fr',
            'phone_number' => '0355455544',
            'is_same_time' => fake()->randomNumber(9) , 
            'product_id' =>  1,
            'match_complet' => 1,
            'hight_light' => 0,
            'player' => null,
        ]);
    }

    private static function senEmail(array  $data, string $view , string $email) : void
    {
        Mail::send($view, $data, function ($message) use ($data, $email) {
            $message->to($email)
                ->subject($data["title"]);
        });
    }
    
    private static function sendEmailPartenaire(array $user_ids , Commandes $order , array $cart){
         // send email for all  partenaire
         foreach (array_unique($user_ids) as $user) {
            $partenaire = User::where('id' , $user)
            ->where('id', '<>' , 1)
            ->first(); 
            if($partenaire){
                // partenaire data
                $partenaire_data["email"] = 'test@test.fr';
                $partenaire_data["title"] = "Notification Your Soccer Games";
                $partenaire_data["body"] = "Commande envoyer";
                $partenaire_data["content"] = $order;
                $partenaire_data["cart"] = self::filterArray($cart , $partenaire->id);
                $partenaire_data['partenaire'] = $partenaire; 
                Mail::send('mail.notification-commande-partenaire', $partenaire_data, function ($message) use ($partenaire_data, $partenaire) {
                    $message->to($partenaire->email)
                        ->subject($partenaire_data["title"]);
                });
            }   
        }
    }

    private static function filterArray(array $cart, int $user_id){
        $result = array_filter($cart, function($item) use($user_id) {
            return $item["user_id"] == 12;
        });
        return $result ; 
    }

}
