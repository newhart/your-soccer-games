<?php

namespace App\Http\Controllers;

use App\Models\Commandes;
use App\Models\Product;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Mail;
use Session;
use Stripe;
use Srmklive\PayPal\Services\PayPal as PayPalClient;

class PaymentController extends Controller
{
    /**
     * success response method.
     *
     * @return \Illuminate\Http\Response
     */
    public function stripe()
    {
        $total = session()->get('total');
        return redirect('/paiment')->with('total', $total);
    }

    /**
     * success response method.
     *
     * @return \Illuminate\Http\Response
     */
    public function stripePost(Request $request)
    {
        Stripe\Stripe::setApiKey(env('STRIPE_SECRET'));
        Stripe\Charge::create([
            "amount" => session()->get('total'),
            "currency" => "eur",
            "source" => $request->stripeToken,
            "description" => "Test payment from Your Soccer Games"
        ]);
        Session::flash('success', 'Payment fait avec success!');

        return back();
    }

    // Paypal

    public function handlePayment(Request $request)
    {
        $provider = new PayPalClient;
        $provider->setApiCredentials(config('paypal'));
        $paypalToken = $provider->getAccessToken();
        $response = $provider->createOrder([
            "intent" => "CAPTURE",
            "application_context" => [
                "return_url" => route('success.payment'),
                "cancel_url" => route('cancel.payment'),
            ],
            "purchase_units" => [
                0 => [
                    "amount" => [
                        "currency_code" => "EUR",
                        "value" => session()->get('total')
                    ]
                ]
            ]
        ]);
        if (isset($response['id']) && $response['id'] != null) {
            foreach ($response['links'] as $links) {
                if ($links['rel'] == 'approve') {
                    return redirect()->away($links['href']);
                }
            }
            return redirect()
                ->route('cancel.payment')
                ->with('error', "Quelque chose s'est mal passé.");
        } else {
            return redirect()
                ->route('create.payment')
                ->with('error', $response['message'] ?? "Quelque chose s'est mal passé.");
        }
    }

    public function paymentCancel()
    {
        return redirect()
            ->route('create.payment')
            ->with('error', $response['message'] ?? 'Vous avez annulé la transaction.');
    }

    private function sendEmail()
    {
            DB::statement('SET FOREIGN_KEY_CHECKS=0;');
            $uuid = fake()->randomNumber(9);
            $cart = session()->get('cart', []);
            $client = session()->get('client', []);
            $user_ids = [] ;
            $productIds = []; 
            $valid = null ; 
            foreach ($cart as  $value) {
                $product = Product::find($value['id']); 
                $user_ids[] = $product->user_id ; 
                $productIds[] = $value['id']; 
                $valid = $value ; 
            }
            // create new commandes 
            $newcommande =  Commandes::create([
                'name' => $client['name'],
                'last_name' => $client['last_name'],
                'email' => $client['email'],
                'phone_number' => $client['phone_number'],
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
                    }); // send  email to client
                } catch (\Throwable $th) {
                    throw $th;
                }
                $commande->mail_send = true ; 
                $commande->save(); 
            }
            session()->put('cart', []);
            session()->put('total', 0);
            session()->put('client', []);
    }

    public function paymentSuccess(Request $request)
    {
        $provider = new PayPalClient;
        $provider->setApiCredentials(config('paypal'));
        $provider->getAccessToken();
        $response = $provider->capturePaymentOrder($request['token']);
        if (isset($response['status']) && $response['status'] == 'COMPLETED') {
            if (count(session()->get('client', [])) > 0) {
                $this->sendEmail();
            }
            return redirect()
                ->route('create.payment')
                ->with('success', 'Payment fait avec success!');
        } else {
            return redirect()
                ->route('create.payment')
                ->with('error', $response['message'] ?? 'Payment a une erreur!');
        }
    }
}
