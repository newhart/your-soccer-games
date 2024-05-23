<?php

namespace App\Http\Controllers;

use App\Exports\PlayerExport;
use App\Models\Club;
use Throwable;
use App\Models\Player;
use App\Models\Country;
use Illuminate\Http\Request;
use Illuminate\Contracts\View\View;
use Maatwebsite\Excel\Facades\Excel;

class PlayerController extends Controller
{
    public function index(Request $request): View
    {
        $query = Player::query()
            ->with('country')
            ->orderBy('created_at', 'DESC');

        if ($request['search']) {
            $search = $request['search'];
            $query->where('first_name', 'LIKE', '%' . $search . '%')
                ->orWhere('last_name', 'LIKE', '%' . $search . '%')
                ->orWhere('full_name', 'LIKE', '%' . $search . '%');
        } else {
            $search = null;
        }
        $players = $query->paginate(15);
        $country = Country::query()->get();
        return view('admin.players.index', compact(['players', 'country', 'search']));
    }

    public function search(Request $request)
    {
        $query = Player::query();

        if ($request['search']) {
            $search =  implode('%', str_split($request['search']));
            $search_implod = implode(' ', array_reverse(explode(' ', $request['search'])));
            $search1 =   implode('%', str_split($search_implod));
            $query->where(function ($query) use ($search, $search1) {
                $query->where('full_name', 'LIKE', '%' . $search . '%')
                    ->orWhere('full_name', 'LIKE', '%' . $search1 . '%');
            });
        } else {
            $search = null;
        }

        if ($request->get('club')) {
            $club = Club::query()
                ->where('name', 'LIKE', '%' . $request->get('club') . '%')
                ->first();

            if ($club) {
                $query = $query->whereHas('clubs', function ($query) use ($club) {
                    $query->where('name', $club->name);
                });
            }
        }


        $players = $query
            ->orderBy('full_name', 'asc')
            ->paginate(15);

        return response()->json(
            $players
        );
    }

    public function store(Request $request)
    {
        if ($request['image']) {
            $imageName = time() . '.' . $request['image']->extension();
            $request->image->move(public_path('img/joueurs'), $imageName);
            $url = asset('img/joueurs/' . $imageName);
        }
        $query = Player::query()
            ->create([
                'first_name' => $request['name'],
                'last_name' => $request['last_name'],
                'birth_date' => $request['birth_date'],
                'country_id' => $request['country_id'],
                'image' => $url ?? null,
                'is_woman' => $request['genre'] === 'Homme' ? false : true,
                'birth_place' =>  $request['birth_place'] ?? null,
                'full_name' => $request['full_name'] ?? null,
            ]);
        if ($query) {
            return redirect()->back()->with('success', 'Nouvelle joueur a été ajouté avec success');
        }
        return redirect()->back()->with('error', "La creation de d'un joueur a une erreur");
    }

    public function update(Request $request)
    {
        $query = Player::query()->where('id', $request['id'])->first();
        if ($request['image']) {
            $imageName = time() . '.' . $request['image']->extension();
            $request->image->move(public_path('img/joueurs'), $imageName);
            $url = asset('img/joueurs/' . $imageName);
        }

        if ($query) {
            $query->update([
                'first_name' => $request['name'],
                'last_name' => $request['last_name'],
                'birth_date' => $request['birth_date'],
                'is_woman' => $request['genre'] === 'Homme' ? false : true,
                'image' => $url ?? $query['image'],
                'country_id' => $request['country_id'],
                'birth_place' =>  $request['birth_place'] ?? null,
                'full_name' => $request['full_name'] ?? null,
            ]);
            return redirect()->back()->with('success', 'Ce joueur a été modifié avec success');
        }
        return redirect()->back()->with('error', "La modification de ce joueur a une erreur");
    }

    public function destroy(Request $request)
    {
        try {
            $player =  Player::query()->where('id', $request['id']);
            if ($player) {
                $player->delete();
                return redirect()->back()->with('success', 'Le joueur a été supprimé avec success');
            }
            return redirect()->back()->with('error', "La suppression de ce joueur a une erreur");
        } catch (Throwable $e) {
            report($e);
            return redirect()->back()->with('error', "La suppression de ce joueur a une erreur car ce joueur est déjà lié a quelque relation");
        }
    }

    public function exportPlayers()
    {
        ini_set('memory_limit', '1024M');
        $batchSize = 110000; // Taille du lot
        $totalPlayers = Player::count(); // Nombre total d'enregistrements
        $batches = ceil($totalPlayers / $batchSize);

        $fileName = 'players_export.csv';

        // Créez un tableau pour stocker les données
        $allData = [];

        for ($i = 3; $i < 5; $i++) {
            $offset = $i * $batchSize;
            $data = Player::select('first_name', 'last_name', 'birth_date')
                ->skip($offset)
                ->take($batchSize)
                ->get();

            // Ajoutez les données au tableau
            $allData = array_merge($allData, $data->toArray());
        }

        // Téléchargez le fichier exporté
        return Excel::download(new PlayerExport($allData), $fileName);
    }
}
