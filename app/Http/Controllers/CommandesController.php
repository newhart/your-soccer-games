<?php

namespace App\Http\Controllers;

use App\Mail\AdminNotificationEmail;
use App\Mail\NotificationSendLinkEmail;
use App\Models\Commandes;
use App\Models\Product;
use App\Models\User;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Crypt;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\URL;

class CommandesController extends Controller
{

    public function saveClient(Request $request)
    {
        session()->put('client', $request->all());
        return response()->json(['success' => true]);
    }
    public function index(Request $request)
    {
        $counts = 0;
        $filter_month = null;
        if (auth()->user()->id === 1) {
            $totals = Commandes::withCount('products')
                ->get();
        } else {
            $totals = Commandes::withCount('products')
                ->whereHas('products', function ($query) {
                    $query->where('user_id', auth()->user()->id);
                })
                ->get();
        }

        if ($totals) {
            foreach ($totals as $total) {
                $counts += $total->products_count;
            }
        }



        $query = (new Commandes())
            ->with(['products.user'])
            ->newQuery();
        if ($request['search']) {
            $search = $request['search'];
            $query =  $query->where('name', 'LIKE', '%' . $search . '%')
                ->orWhere('last_name', 'LIKE', '%' . $search . '%')
                ->orWhere('email', 'LIKE', '%' . $search . '%');
        } else {
            $search = null;
        }
        if ($request->get('date')) {
            $query  = $query->whereDate('created_at', $request->get('date'));
        }

        if ($request->filter_month) {
            $filter_month = $request->filter_month;
            $year = now()->year;
            $query = $query->whereMonth('created_at', $filter_month)
                ->whereYear('created_at', $year);

            $totals = $query->withCount('products')->get();
            $counts = 0;
            foreach ($totals as $total) {
                $counts += $total->products_count;
            }
        }
        if ($request['filter']) {
            $filter = $request['filter'];
            $query->where('status', 'LIKE', '%' . $filter . '%');
        } else {
            $filter = null;
            $query = $query->where('status', '<>', 'Supprimer');
        }

        if ($request->filter_partenaire) {
            $filter_partenaire = $request->filter_partenaire;
            $query =  $query->whereHas('products', function ($query) use ($request) {
                $query->where('user_id', $request->filter_partenaire);
            });
        } else {
            $filter_partenaire = null;
        }
        // get the commande for user auth if is not admin 
        if (auth()->user()->type !== "Admin") {
            $query = $query->whereHas('products', function ($query) {
                $query->where('user_id', auth()->user()->id);
            });
        }
        $commandes = $query
            ->orderBy('created_at', 'desc')
            ->paginate(20);
        if ($request->get('page') || $request->get('date') || $request->get('search') || $request->get('filter')) {
            $totals = $query->withCount('products')->get();
            $counts = 0;
            foreach ($totals as $total) {
                $counts += $total->products_count;
            }
        }
        $partenaires =  User::where('type', 'Partenaire')->get();
        return view('admin.commandes', compact(['commandes', 'search', 'filter', 'partenaires', 'filter_partenaire', 'counts', 'filter_month']));
    }

    public function send(Request $request)
    {
        $request->validate(['lien' => 'required']);
        $commandes = (new Commandes())->newQuery()->with('product')->where('is_same_time', $request['id'])->get();
        foreach ($commandes as $key => $commande) {
            if ($key === 0) {
                $data["email"] = $commande['email'];
                $data["title"] = "Livraison Your Soccer Games";
                $data["url"] = $request['lien'];
                $data["body"] = "Le lien de la video que vous avez commander est " . $request['lien'];
                $data["content"] = $commandes;

                Mail::send('mail.send_path', $data, function ($message) use ($data) {
                    $message->to($data["email"])
                        ->subject($data["title"]);
                });
                $partenaire = User::findOrFail($commande->product->user_id);
                if ($partenaire) {
                    Mail::to('admin@yoursoccergames.com')->send(new AdminNotificationEmail($partenaire));
                }
            }
            $commande->update([
                'status' => 'Envoyer'
            ]);
        }

        return redirect()->back()->with('success', "L'email a été envoyer avec succes");
    }

    public function store(Request $request)
    {

        $uuid = fake()->randomNumber(9);
        $cart = session()->get('cart', []);
        $productIds = [];
        $valid = null;
        foreach ($cart as $key => $value) {
            $productIds[] = $value['id'];
            $valid = $value;
        }
        // create new commandes
        $newcommande =  Commandes::create([
            'name' => $request['name'],
            'last_name' => $request['last_name'],
            'email' => $request['email'],
            'phone_number' => $request['phone_number'],
            'is_same_time' => $uuid,
            'product_id' => $valid['id'],
            'match_complet' => $valid['complet_match'],
            'hight_light' => $valid['hight_light'],
            'player' => array_key_exists('player', $valid) && $$valid['player'] !== '' ? $valid['player'] : null,
        ]);
        $newcommande->products()->attach($productIds);
        $commande = (new Commandes())->newQuery()->with('product')->where('id', $newcommande['id'])->first();
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

            try {
                Mail::send('mail.notification-commande-admin', $data, function ($message) use ($data) {
                    $message->to('admin@yoursoccergames.com')
                        ->subject($data["title"]);
                });
            } catch (\Exception $e) {
                dd($e->getMessage());
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

        return redirect()->route('index')->with('success-store-commande', "Vous recevrez un lien de téléchargement vers la ou les vidéos que vous avez commandées dans un délai de 48h.");
    }

    public function senLinkPartenaire(Request $request)
    {
        try {
            $encryptedId = $request->input('token');
            $id = Crypt::decrypt($encryptedId);
        } catch (\Illuminate\Contracts\Encryption\DecryptException $e) {
            dd($e->getMessage());
        }
        return view('partenaires.send', ['token' => $encryptedId, 'id' => $id]);
    }

    public function confirm(Request $request, Product $product): RedirectResponse
    {
        $commandes = Commandes::where('email', $request->email)
            ->where('status', '<>', 'Envoyer')
            ->with('product')
            ->get()
            ->groupBy('is_same_time'); // find all commande no validate for the user by emaol of the client owner of the commande
        $confirmationLink = URL::route('commandes.link', ['id' => $request->is_same_time,  'token' => Crypt::encrypt($request->is_same_time)]); // generate link 
        $data = [];
        $commande = [];
        $partenaire_ids = [];
        foreach ($commandes as $items) {
            foreach ($items as $k =>  $item) {
                if ($k === 0) {
                    $commande['commande'] = $item->toArray();
                }
                $data[] = $item->toArray();
                if ($request->user()->id !== $item->product->user_id) { // say if the admin is not the owner of the product
                    $partenaire_ids[] = $item->product->user_id;
                }
            }
        }
        $user = User::findOrFail($commande['commande']['product']['user_id']);
        if ($user && $user->type !== "Admin") {
            $this->sendEmailForPartenaire($partenaire_ids,  $commande, $data, $confirmationLink); // send email for the partenaire owner of the product
        }
        $this->sendEmailForPartenaire($partenaire_ids,  $commande, $data, $confirmationLink); // send email for the partenaire owner of the product
        return redirect()->back()->with(['success' => 'Commande confirmer avec success']);
    }

    public function validation(Request $request, int $commande_id): RedirectResponse
    {
        $commande = Commandes::where('email', $request->email)
            ->where('is_same_time', $request->is_same_time)
            ->first();
        $commande->status = 'Envoyer';
        $commande->save();
        return redirect()->back()->with('success', 'Modification fait avec success');
    }

    private function sendEmailForPartenaire(array $partenaire_ids, array $commande, array $data, string $confirmationLink): void
    {
        foreach ($partenaire_ids as $partenaire) {
            $user = User::findOrFail($partenaire);
            if ($user) {
                Mail::to($user->email)->send(new NotificationSendLinkEmail($commande, $data, $confirmationLink, $user));
            }
        }
    }

    public function delete(Request $request,  int $id)
    {
        $commande = Commandes::where('is_same_time', $request->is_same_time)
            ->first();
        $commande->update(['status' => 'Supprimer']);
        return redirect()->back()->with('success', 'Commande supprimer avec success');
    }
}
