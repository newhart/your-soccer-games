<?php

namespace App\Http\Controllers\admin;

use App\Http\Controllers\Controller;
use App\Mail\OlderEmail;
use App\Mail\PlusInfoEmail;
use App\Models\OlderPlayer;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Mail;
use Throwable;

class OlderPlayerController extends Controller
{
    public function index()
    {
        $players  = OlderPlayer::latest()
            ->with('product')
            ->paginate(15);
        $search = null;
        // get session item here
        $item  = session()->get('item');
        return view('admin.players.older', compact(['players', 'search', 'item']));
    }

    public function destroy(Request $request)
    {
        try {
            $player =  OlderPlayer::query()->where('id', $request['id'])->first();
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

    public function validate_older_player(Request $request)
    {
        try {
            // get  OlderPlayer by id
            $player = OlderPlayer::query()->where('id', $request['id'])->first();
            // create encrypte token with player name
            $token = encrypt($player->name);
            // save token in database
            $player->update([
                'token' => $token,
                'status' => "Valider"
            ]);
            Mail::to($player->email)->send(new OlderEmail($player));
            // redirect with success message
            return redirect()->back()->with('success', 'Le joueur a été validé avec success');
        } catch (\Throwable $th) {
            return redirect()->back()->with('error', $th->getMessage());
        }
    }

    public function plus_info(Request $request)
    {
        $player = OlderPlayer::query()->where('id', $request['id'])->first();
        Mail::to($player->email)->send(new PlusInfoEmail($player));
        return redirect()->back()->with('success', 'Demande envoyer avec success');
    }
}
