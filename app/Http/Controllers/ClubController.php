<?php

namespace App\Http\Controllers;

use App\Models\Club;
use App\Models\Player;
use App\Models\Product;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;

class ClubController extends Controller
{
    public function  search(Request $request): JsonResponse
    {
        $query = Club::query();
        if ($request->get('search')) {
            $query = $query
                ->where(function ($query) use ($request) {
                    if ($request->get('search') === 'lens') {
                        $query
                            ->where('name', $request->get('search'));
                    } else {
                        $query
                            ->where('full_name', 'LIKE', '%' . $request->get('search') . '%')
                            ->orWhere('name', 'LIKE', '%' . $request->get('search') . '%')
                            ->orWhere('short_name', 'LIKE', '%' . $request->get('search') . '%');
                    }
                });
        }
        if ($request->get('player')) {
            $player = Player::query()
                ->where('full_name', 'LIKE', '%' . $request->get('player') . '%')
                ->first();
            if ($player) {
                $query = $query->whereHas('players', function ($query) use ($player) {
                    $query->where('full_name', $player->full_name);
                });
            }
        }

        $data  = $query->orderBy('name', 'ASC')->limit(10)->get();
        return response()->json($data);
    }

    public function index(Request $request)
    {
        $query = Product::distinct()->select('residence');
        $search = null;
        if ($request->get('search')) {
            $query = $query->where('residence', $request->get('search'));
            $search = $request->get('search');
        }
        $clubs = $query
            ->paginate(10);
        return view('admin.clubs.index', compact('clubs', 'search'));
    }

    public  function changeName(Request $request): RedirectResponse
    {
        $request->validate(['newName' => ['required'], 'oldName' => ['required']]);
        $productsVisitors = Product::where('visitor', $request->oldName)->get();
        $productsResidences = Product::where('residence', $request->oldName)->get();
        if (count($productsResidences) > 0) {
            foreach ($productsResidences as $residence) {
                $residence->residence = $request->newName;
                $residence->save();
            }
        }

        if (count($productsVisitors) > 0) {
            foreach ($productsVisitors as $visitor) {
                $visitor->visitor = $request->newName;
                $visitor->save();
            }
        }

        return redirect()->back()->with('success', 'Nom de la club modifier avec success');
    }
}
