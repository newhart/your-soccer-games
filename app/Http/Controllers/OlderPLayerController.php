<?php

namespace App\Http\Controllers;

use App\Http\Requests\OlderPlayerRequest;
use App\Models\OlderPlayer;
use Illuminate\Http\RedirectResponse;
use Illuminate\Support\Facades\Storage;

class OlderPLayerController extends Controller
{
    public function index()
    {
        return view('player.older');
    }

    private function extractData(OlderPlayer $olderPlayer, OlderPlayerRequest $request)
    {
        $data = $request->validated();
        /** @var UploadedFile|null $image */
        $image = $request->photo;
        if ($image === null || $image->getError()) {
            return $data;
        }
        /** @var $category new Category() */
        if ($olderPlayer->photo) {
            Storage::disk('public')->delete($olderPlayer->photo);
        }
        $data['photo'] = $image->store('players', 'public');
        return $data;
    }

    public function store(OlderPlayerRequest $request): RedirectResponse
    {
        if (!$request->hasFile('photo')) {
            return redirect()->back()->with('error', 'the Photo is required');
        }
        try {
            $olderPlayer = new OlderPlayer();
            OlderPlayer::create($this->extractData($olderPlayer, $request));
        } catch (\Throwable $th) {
            return redirect()->back()->with('error', $th->getMessage());
        }

        return redirect()->route('older.player')->with('success', 'Information seding with success');
    }
}
