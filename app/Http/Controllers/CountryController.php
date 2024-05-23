<?php

namespace App\Http\Controllers;

use App\Models\Club;
use Throwable;
use App\Models\Country;
use App\Models\Continent;
use App\Models\Player;
use Illuminate\Cache\RateLimiting\Limit;
use Illuminate\Http\Request;
use Illuminate\Contracts\View\View;
use Illuminate\Http\JsonResponse;

class CountryController extends Controller
{
    public function index(Request $request): View
    {
        $query = Country::query()
            ->orderBy('name');

        if ($request['search']) {
            $search = $request['search'];
            $query->where('name', 'LIKE', '%' . $search . '%');
        } else {
            $search = null;
        }
        $countries = $query->paginate(15);

        $continents = Continent::query()->orderBy('name')->get();
        return view('admin.listPays', [
            'countries' => $countries,
            'continents' => $continents,
            'search' => $search
        ]);
    }

    public function search(Request $request): JsonResponse|string
    {
        $country_query = Country::query();

        if ($request->get('search')) {
            $country_query = $country_query
                ->where('name', 'LIKE', '%' . $request->get('search') . '%');
        }

        if ($request->get('player')) {
            $player = Player::query()
                ->where('full_name', 'LIKE', '%' . $request->get('player') . '%')
                ->first();
            if ($player) {
                $country_query = $country_query->whereHas('players', function ($query) use ($player) {
                    $query->where('full_name', $player->full_name);
                });
            }
        }
        // pepare for query
        $cuntries = $country_query->orderBy('name', 'asc')->limit(10)->get();
        return response()->json($cuntries);
    }

    public function store(Request $request)
    {
        $query = Country::query()
            ->create([
                'name' => $request['name'],
                'nationality' => $request['nationality'],
                'country_flag' => null,
                'logitude' => $request['logitude'],
                'latitude' => $request['latitude'],
                'timezone' => $request['timezone'],
                'continent_id' => $request['continent_id'],
            ]);
        return redirect()->back()->with('success', 'Nouvelle pays a été ajouté avec success');
    }

    public function update(Request $request)
    {
        $query = Country::query()->where('id', $request['id']);
        if ($query) {
            $query->update([
                'name' => $request['name'],
                'nationality' => $request['nationality'],
                'country_flag' => null,
                'logitude' => $request['logitude'],
                'latitude' => $request['latitude'],
                'timezone' => $request['timezone'],
                'continent_id' => $request['continent_id'],
            ]);
            return redirect()->back()->with('success', 'Nom de la pays a été modifié avec success');
        }
        return redirect()->back()->with('error', "La modification de ce pays a une erreur");
    }

    public function destroy(Request $request)
    {
        try {
            $Country =  Country::query()->where('id', $request['id']);
            if ($Country) {
                $Country->delete();
                return redirect()->back()->with('success', 'La pays a été supprimé avec success');
            }
            return redirect()->back()->with('error', "La suppression de ce pays a une erreur");
        } catch (Throwable $e) {
            report($e);

            return redirect()->back()->with('error', "La suppression de ce pays a une erreur car ce pays est déjà lié a un joueur");
        }
    }
}
