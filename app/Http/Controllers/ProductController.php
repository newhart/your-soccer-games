<?php

namespace App\Http\Controllers;

use App\Models\Competition;
use App\Models\Disk;
use App\Models\Moment;
use App\Models\Player;
use App\Models\PrixMatch;
use App\Models\Product;
use App\Models\TypeMatch;
use App\Models\User;
use App\Models\VideoMatch;
use App\Services\ProductSearchService;
use Illuminate\Http\Request;
use Carbon\Carbon;

class ProductController extends Controller
{
    public function index()
    {
        $moment_type = Moment::where('current', true)->with(['matchs', 'videoMatchs'])->first();

        $all_products = Product::where('user_id', 1)
            ->with('type_match.prix_match')
            ->limit(84)
            ->get();

        if ($moment_type->video === 'on') {
            $product_right_now = VideoMatch::where('moment_id', 1)->limit(10)->get();
        } else {

            $product_right_now = Product::where('is_right_now', true)
                ->where('user_id', 1)
                ->with('type_match.prix_match')
                ->limit(10)
                ->get();
        }

        $partenaires =  User::where('type', '<>', 'Admin')
            ->with('profile')
            ->latest()
            ->get();

        $today = Carbon::today()->format('m-d');
        $playersWithBirthdayToday = Player::whereRaw('DATE_FORMAT(birth_date, "%m-%d") = ?', [$today])->limit(13)->get();
        return view('welcome', [
            'product_rigt_now' => $product_right_now,
            'all_products' => $all_products,
            'partenaires' => $partenaires,
            'moment_type' => $moment_type,
            'playersWithBirthdayToday' => $playersWithBirthdayToday
        ]);
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'short_description' => 'required',
            'saison' => 'required',
            'residence' => 'required',
            'visitor' => 'required',
            'date_match' => 'required',
            'image' => 'required',
            'n_disque' => 'required'
        ]);
        if ($request['image']) {
            $imageName = time() . '.' . $request['image']->extension();
            $request->image->move(public_path('img/match'), $imageName);
            $url = asset('img/match/' . $imageName);
        }
        if ($validated) {
            $newProduct = Product::create([
                'price' => 0,
                'short_description' => $request['short_description'],
                'saison' => $request['saison'],
                'residence' => $request['residence'],
                'visitor' => $request['visitor'],
                'date_match' => $request['date_match'],
                'image' => $url ?? null,
                'is_right_now' => $request['is_right_now'] === 'on' ? true : false,
                'slug' => str_replace(' ', '_', $request['visitor'] . 'Vs' . $request['residence']),
                'matchs' => null,
                'journey' => $request['journey'] ?? null,
                'result' => $request['result'] ?? null,
                'description' => $request['description'] ?? null,
                'user_id' => $request->user()->id,
                'n_disque' => $request['n_disque'],
                'genre' => $request['genre'],
                'possibility_hight_light' =>  $request['possibility_hight_light'] === 'on' ? true : false,
                'possibility_match_complet' =>  $request['possibility_match_complet'] === 'on' ? true : false,
            ]);
            if ($newProduct) {
                return redirect()->back()->with('success', 'Nouvelle match a été ajouté avec success');
            } else {
                return redirect()->back()->with('error', "L'ajout d'un match a une erreur");
            }
        }
    }

    public function update_product(Request $request)
    {
        $validated = $request->validate([
            'short_description' => 'required',
            'saison' => 'required',
            'residence' => 'required',
            'visitor' => 'required',
            'date_match' => 'required',
            'n_disque' => 'required'
        ]);
        if ($request['image']) {
            $imageName = time() . '.' . $request['image']->extension();
            $request->image->move(public_path('img/match'), $imageName);
            $url = asset('img/match/' . $imageName);
        }
        if ($validated) {
            $product = (new Product())->newQuery()->where('id', $request['id'])->first();
            if ($product) {
                $newProduct = $product->update([
                    'short_description' => $request['short_description'],
                    'saison' => $request['saison'],
                    'residence' => $request['residence'],
                    'visitor' => $request['visitor'],
                    'date_match' => $request['date_match'],
                    'image' => $url ?? $product['image'],
                    'is_right_now' => $request['is_right_now'] && $request['is_right_now'] === 'on' ? true : false,
                    'matchs' => $product['matchs'],
                    'journey' => $request['journey'] ?? $product['journey'],
                    'result' => $request['result'] ?? $product['result'],
                    'description' => $request['description'] ?? $product['description'],
                    'n_disque' => $request['n_disque'],
                    'genre' => $request['genre'],
                    'possibility_hight_light' =>  $request['possibility_hight_light'] && $request['possibility_hight_light'] === 'on' ? true : false,
                    'possibility_match_complet' =>  $request['possibility_match_complet'] && $request['possibility_match_complet'] === 'on' ? true : false,
                ]);
                return redirect()->back()->with('success', 'Match a été modifié avec success');
            }
            return redirect()->back()->with('error', "La modification d'un match a une erreur");
        }
    }

    public function panier()
    {
        $product_rigt_now = Product::where('is_right_now', true)
            ->with('type_match', function ($q) {
                $q->with('prix_match');
            })
            ->paginate(10);
        $prix = (new PrixMatch())->newQuery()->get();
        $total = session()->get('total');
        $typeMatch = (new TypeMatch())->newQuery()->with('prix_match')->get();
        return view('front.panier', [
            'product_rigt_now' => $product_rigt_now,
            'prix' => $prix,
            'typeMatch' => $typeMatch,
            'total' => $total
        ]);
    }

    public function destroy(Request $request)
    {
        $match = (new Product())
            ->where('id', $request['id'])
            ->newQuery()
            ->first();
        if ($match) {
            $match->delete();
            return redirect()->back()->with('success', 'Ce match a été supprimé avec success');
        }
        return redirect()->back()->with('error', "La suppression de ce match a une erreur");
    }

    public function all(Request $request)
    {
        $data = ProductSearchService::productSearch($request, 1);
        $route = ['route' => 'matchs', 'user' => null, 'partenaire' => null];
        $data = array_merge($data, $route);
        return view('front.allmatch', $data);
    }

    private function  unsort_date(array $dates): array
    {
        usort($dates, function ($a, $b) {
            $dateTimestamp1 = strtotime($a);
            $dateTimestamp2 = strtotime($b);

            return $dateTimestamp1 < $dateTimestamp2 ? -1 : 1;
        });
        return $dates;
    }

    public function show(Request $request)
    {
        $product = Product::where('slug', $request->id)
            ->with('type_match', function ($q) {
                $q->with('prix_match');
            })->first();
        $related_products =  Product::where('residence', $product->residence)
            ->with('type_match', function ($q) {
                $q->with('prix_match');
            })
            ->where('id', '<>', $product->id)
            ->orWhere('visitor', $product->visitor)
            ->paginate();

        return view('front.detailsMatch', [
            'product' => $product,
            'related_products' => $related_products
        ]);
    }

    public function addToCart($id, Request $request)
    {
        $product = (new Product())->newQuery()->with(['type_match' =>  function ($q) {
            $q->with('prix_match');
        }, 'user'])->where('id', $id)->first();

        if ($product) {
            $disk = Disk::where('number', $product->n_disque)->first();
            if ($disk) {
                return redirect()->back()->with('error',  "Cette disque a eu une defaillant pour le moment ce produit n'est pas encore disponible");
            }
        }

        $cart = session()->get('cart', []);

        if (isset($cart[$id])) {
            return redirect()->back()->with(['success-add', 'Product already added to cart!']);
        } else {
            $cart[$id] = [
                "id" => $product->id,
                "slug" => $product->slug,
                "residence" => $product->residence,
                "visitor" => $product->visitor,
                "quantity" => 1,
                "type_match" => $product->type_match?->name,
                "date" => $product->date_match,
                "competition" => $product->competition,
                "possibility_hight_light" => $product->possibility_hight_light,
                "possibility_match_complet" => $product->possibility_match_complet,
                "result" => $product->result,
                "complet_match" => $product->possibility_match_complet ? true : false,
                "hight_light" => !$product->possibility_match_complet ? true : false,
                "result" => $product->result,
                "result" => $product->result,
                "price" => $product->type_match?->prix_match?->prix,
                "price_id" => $product->type_match?->prix_match?->id,
                "image" => $product->image,
                "n_disque" => $product->n_disque,
                'user_id' => $product->user_id,
                'owner' => $product->user
            ];

            if ($request['player']) {
                $cart[$id]['player'] = $request['player'];
            }
            $prix_match_complet = (new PrixMatch())->where('id', 1)->newQuery()->first();
            $prix_hight_light = (new PrixMatch())->where('id', 2)->newQuery()->first();
            $total = session()->get('total');
            $token = session()->get('token_player', null);
            if ($token && count($cart) === 1 && $product->user_id === 1) {
                $total  = 0;
            } else {
                $total = $cart[$id]['complet_match'] ? $total + $prix_match_complet['prix'] : ($cart[$id]['hight_light'] ? $total + $prix_hight_light['prix'] : 0);
            }
            session()->put('total', $total);
            session()->put('token_player', null);
        }

        session()->put('cart', $cart);
        return redirect()->back()->with(['success-add', 'Product added to cart successfully!']);
    }

    /**
     * Write code on Method
     *
     * @return response()
     */
    public function update(Request $request)
    {
        if ($request->id) {
            $cart = session()->get('cart');
            $cart[$request->id][$request->type] = $request->value === 'true' ? true : false;
            if ($request['player']) {
                $cart[$request->id]['player'] = $request['player'];
            }
            session()->put('cart', $cart);
            session()->flash('success', 'Cart updated successfully');

            $total = session()->get('total');
            $prix_match_complet = (new PrixMatch())->where('id', 1)->newQuery()->first();
            $prix_hight_light = (new PrixMatch())->where('id', 2)->newQuery()->first();
            if ($request->value === 'true' && $request->type === 'complet_match') {
                $totalnew = $total + $prix_match_complet->prix;
                session()->put('total', $totalnew);
            } elseif ($request->value === 'false' && $request->type === 'complet_match') {
                $totalnew = $total - $prix_match_complet->prix;
                session()->put('total', $totalnew);
            }

            if ($request->value === 'true' && $request->type === 'hight_light') {
                $totalnew = $total + $prix_hight_light->prix;
                session()->put('total', $totalnew);
            } elseif ($request->value === 'false' && $request->type === 'hight_light') {
                $totalnew = $total - $prix_hight_light->prix;
                session()->put('total', $totalnew);
            }
            $total = session()->get('total');

            return response()->json([
                'total' => $total,
            ]);
        }
    }

    public function updatePlayerCart(Request $request)
    {
        if ($request->id) {
            $cart = session()->get('cart');
            $cart[$request->id]['player'] = $request['player'];
            session()->put('cart', $cart);
            session()->flash('success', 'Cart updated successfully');
        }
    }

    public function validateCart()
    {
        $cart = session()->get('cart');

        $error = [];
        $error1 = [];

        foreach ($cart as $key => $value) {
            if ((array_key_exists('complet_match', $value) && !$value['complet_match']) && (array_key_exists('hight_light', $value) && !$value['hight_light'])) {
                array_push($error, $value['id']);
            }
            if ((array_key_exists('hight_light', $value) && $value['hight_light']) && (!array_key_exists('player', $value) || !$value['player'])) {
                array_push($error1, $value['id']);
            }
        }

        if (count($error) > 0 || count($error1) > 0) {
            return response()->json([
                'errors' => $error,
                'errors1' => $error1,
                'cart' => $cart,
            ]);
        } else {
            if (count($cart) > 0) {
                return response()->json([
                    'succes' => true,
                    'cart' => $cart,
                ]);
            } else {
                return response()->json([
                    'errors' => [],
                    'cart' => $cart,
                ]);
            }
        }
    }

    /**
     * Write code on Method
     *
     * @return response()
     */
    public function remove(Request $request)
    {
        if ($request->id) {
            $cart = session()->get('cart');
            $prix_match_complet = (new PrixMatch())->where('id', 1)->newQuery()->first();
            $prix_hight_light = (new PrixMatch())->where('id', 2)->newQuery()->first();
            $total = session()->get('total');
            if ($cart[$request->id]['complet_match']) {
                $totalnew = $total - $prix_match_complet->prix;
                session()->put('total', $totalnew);
            }

            $total = session()->get('total');

            if ($cart[$request->id]['hight_light']) {
                $totalnew = $total - $prix_hight_light->prix;
                session()->put('total', $totalnew);
            }
            if (isset($cart[$request->id])) {
                unset($cart[$request->id]);
                session()->put('cart', $cart);
            }

            session()->flash('success', 'Product removed successfully');
            return redirect()->back()->with('success', 'Product removed successfully');
        }
    }
}
