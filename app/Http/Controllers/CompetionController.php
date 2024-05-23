<?php

namespace App\Http\Controllers;

use App\Models\Competition;
use App\Models\Player;
use Illuminate\Contracts\View\View;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

use function PHPUnit\Framework\returnSelf;

class CompetionController extends Controller
{
    public function index(Request $request): View
    {
        $query = Competition::query()
            ->with('country')
            ->orderBy('name');

        if ($request['search']) {
            $search = $request['search'];
            $query->where('name', 'LIKE', '%' . $search . '%');
        } else {
            $search = null;
        }
        $competitions = $query->paginate(15);
        return view('admin.listCompetition', compact(['competitions', 'search']));
    }


    public function search(Request $request): JsonResponse
    {
        $query = Competition::query();
        if ($request->get('search')) {
            $query = $query
                ->where('name', 'LIKE', '%' . $request->get('search') . '%');
        }
        if ($request->get('player')) {
            $player = Player::where('full_name', 'LIKE', '%' . $request->get('player') . '%')
                ->first();
            if ($player) {
                $query->whereHas('season.players',  function ($query) use ($player) {
                    $query->where('full_name', $player->full_name);
                });
            }
        }
        $data = $query->orderBy('name', 'asc')->paginate(10);
        return response()->json($data);
    }

    public function store(Request $request)
    {
        $query = Competition::query()
            ->create([
                'name' => $request['name'],
                'country_id' => 1
            ]);
        return redirect()->back()->with('success', 'Nouvelle compétition a été ajouté avec success');
    }

    public function update(Request $request)
    {
        $query = Competition::query()->where('id', $request['id']);
        if ($query) {
            $query->update([
                'name' => $request['name']
            ]);
            return redirect()->back()->with('success', 'Nom de la compétition a été modifié avec success');
        }
        return redirect()->back()->with('error', "La modification de ce compétition a une erreur");
    }

    public function destroy(Request $request)
    {
        $competition =  Competition::query()->where('id', $request['id']);
        if ($competition) {
            $competition->delete();
            return redirect()->back()->with('success', 'La compétition a été supprimé avec success');
        }
        return redirect()->back()->with('error', "La suppression de ce compétition a une erreur");
    }
}
