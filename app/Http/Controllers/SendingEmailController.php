<?php

namespace App\Http\Controllers;

use App\Models\Commandes;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Mail;

class SendingEmailController extends Controller
{
    public function send(Request $request)
    {
        $commandes = Commandes::where('email' , $request->email)
        ->where('is_same_time'  , $request->is_same_time)
        ->with('product')
        ->get(); 
        $cart = [];
        $ids = [];  
        foreach ($commandes as $commande) {
            if(!in_array($commande->product?->id , $ids)){
                $cart[] = [
                    'player' => $commande->player , 
                    'residence' => $commande->product?->residence , 
                    'visitor' => $commande->product?->visitor , 
                    'complet_match' => $commande->match_complet , 
                    'hight_light' => $commande->hight_light, 
                    'date' => $commande->product?->date_match
                ]; 
                $ids[] = $commande->product?->id; 
                $commande->mail_send = true ; 
                $commande->save(); 
            }
        }

        $content = [
            'name' => $commandes[0]?->name, 
            'last_name' => $commandes[0]->last_name , 
            'is_same_time' => $commandes[0]->is_same_time
        ]; 
        $data1["email"] = $request->email ; 
        $data1["title"] = "Notification Your Soccer Games";
        $data1["body"] = "Commande envoyer";
        $data1["content"] = $content;
        $data1["cart"] = $cart;
        try {
            Mail::send('mail.notification-commande-user', $data1, function ($message) use ($data1) {
                $message->to($data1["email"])
                    ->subject($data1["title"]);
            });
        } catch (\Throwable $th) {
            throw $th;
        }
        return redirect()->back()->with('success', 'Mail a ete envoyer avec success'); 
    }
}
