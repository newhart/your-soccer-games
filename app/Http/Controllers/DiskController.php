<?php

namespace App\Http\Controllers;

use App\Http\Requests\DiskRequest;
use App\Models\Disk;
use Illuminate\Contracts\View\View;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;

class DiskController extends Controller
{
    public function index(Request $request): View
    {
        if ($request->get('search')) {
            $disks  = Disk::where('number', 'LIKE', "%{$request->get('search')}%")->paginate(10);
            $search = $request->get('search');
        } else {
            $disks = Disk::paginate(10);
            $search = '';
        }
        return  view('disk.index', ['disks' => $disks, 'search' => $search]);
    }

    public function store(DiskRequest $request): RedirectResponse
    {
        Disk::create($request->validated());
        return redirect()->back()->with('success', 'Disque creeer avec success');
    }

    public function delete(Disk $disk)
    {
        $disk->delete();
        return redirect()->back()->with('success', 'Disque supprimer avec success');
    }

    public function update(DiskRequest $request, Disk $disk): RedirectResponse
    {
        $disk->update($request->validated());
        return redirect()->back()->with('success',  'Disque modifier avec success');
    }
}
