<?php

namespace App\Http\Controllers;

use App\Models\PrixMatch;
use App\Models\TypeMatch;
use Illuminate\Http\Request;

class PrixMatchController extends Controller
{
    public function index()
    {
        $all_type = (new TypeMatch())
            ->newQuery()->with('prix_match')->get();
        return view('admin.gestion-prix', compact('all_type'));
    }

    public function create(Request $request)
    {
        $prix = (new PrixMatch())
            ->newQuery();
        $type = (new TypeMatch())
            ->newQuery();
        $newType =  $type->create([
            'name' => $request['name']
        ]);
        $prix->create([
            'prix' => $request['prix'],
            'type_match_id' => $newType['id']
        ]);
        return redirect()->back()->with(['success', 'Price created with success']);
    }
    public function update(Request $request)
    {
        $type = (new TypeMatch())
            ->newQuery()
            ->where('id', $request['id_type'])->first();
        if ($type) {
            $type->update([
                'name' => $request['name']
            ]);
        }
        $prix = (new PrixMatch())
            ->newQuery()
            ->where('type_match_id', $request['id_type'])->first();

        if ($prix) {
            $prix->update([
                'prix' => $request['prix']
            ]);
        } else {
            PrixMatch::create([
                'prix' => $request['prix'],
                'type_match_id' => $request['id_type']
            ]);
        }
        return redirect()->back()->with(['success', 'Price updated with success']);
    }
}
