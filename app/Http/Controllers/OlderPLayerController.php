<?php

namespace App\Http\Controllers;

use App\Http\Requests\OlderPlayerRequest;
use App\Mail\PlusInfoEmail;
use App\Models\OlderPlayer;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Storage;

class OlderPLayerController extends Controller
{
    public function index()
    {
        $player = null;
        return view('player.older', compact(['player']));
    }

    public function edit(OlderPlayer $olderPlayer)
    {
        $player = $olderPlayer;
        return view('player.older', compact(['player']));
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

    public function update(OlderPlayerRequest $request, OlderPlayer $olderPlayer): RedirectResponse
    {
        $olderPlayer->update($this->extractData($olderPlayer, $request));
        return redirect()->route('older.player')->with('success', 'Information updated with success');
    }


    public function plus_info(Request $request)
    {
        $player = OlderPlayer::query()->where('id', $request['id'])->first();
        Mail::to($player->email)->send(new PlusInfoEmail($player));
        return redirect()->back()->with('success', 'Demande envoyer avec success');
    }
}
