<?php

namespace App\Http\Controllers;

use App\Models\Moment;
use App\Models\Product;
use App\Models\TypeMatch;
use App\Models\VideoMatch;
use Illuminate\Http\Request;

class MomentMatchController extends Controller
{
    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function index(Request $request)
    {
        if ($request->get('type_video')) {
            $moment_current = Moment::where('video', 'on')->with(['matchs', 'videoMatchs'])->first();
            $moment_current->current = true;
            $moment_current->save();

            $moment_not_current = Moment::where('video', 'off')->with(['matchs', 'videoMatchs'])->first();
            $moment_not_current->current = false;
            $moment_not_current->save();
        } else {
            $moment_current = Moment::where('video', 'off')->with(['matchs', 'videoMatchs'])->first();
            $moment_current->current = true;
            $moment_current->save();

            $moment_not_current = Moment::where('video', 'on')->with(['matchs', 'videoMatchs'])->first();
            $moment_not_current->current = false;
            $moment_not_current->save();
        }
        $moment_type = Moment::where('current', true)->with(['matchs', 'videoMatchs'])->first();
        $type_match = (new TypeMatch())->newQuery()->latest()->get();
        $query = (new Product())->newQuery()
            ->where('moment_id', 2)
            ->with('type_match');
        // find by  match name
        if ($request['search']) {
            $search = $request['search'];
            $query = $query->where('slug', 'LIKE', '%' . str_replace(' ', '-', strtolower($request['search'])) . '%')
                ->orWhere('residence', 'LIKE', '%' . $search . '%')
                ->orWhere('visitor', 'LIKE', '%' . $search . '%')
                ->orWhere('short_description', 'LIKE', '%' . $search . '%');
        } else {
            $search = null;
        }

        // find by  date match
        if ($request['date']) {
            $date = $request['date'];
            $query = $query->where('date_match', $request['date']);
        } else {
            $date = null;
        }
        if (auth()->user()->type !== 'Admin') {
            $query = $query->where('user_id', auth()->user()->id);
        }

        if ($moment_type->video === 'on') {
            $all_product = VideoMatch::where('moment_id', 1)->paginate(10);
        } else {
            $all_product = $query->latest()->paginate(10);
        }
        return view('admin.matchs.moment', compact(['all_product', 'type_match', 'search', 'date', 'moment_type']));
    }

    public function storeVideo(Request $request)
    {
        $request->validate(
            [
                'title_video' => 'required',
                'url_video' => 'required',
            ]
        );
        VideoMatch::create([
            'title' =>  $request->title_video,
            'url' => $request->url_video,
            'moment_id' => 1
        ]);

        return redirect()->back()->with('success', 'Vidéo ajouté avec succès');
    }

    public function updateVideo(int $video,  Request $request)
    {
        $request->validate(
            [
                'title' => 'required',
                'url' => 'required',
            ]
        );
        $video = VideoMatch::where('id', $video)->first();
        $video->update([
            'title' =>  $request->title,
            'url' => $request->url,
        ]);

        return redirect()->back()->with('success', 'Vidéo modifier avec succès');
    }

    public function deleteVideo(int $video)
    {
        $video = VideoMatch::where('id', $video)->first();
        $video->delete();
        return redirect()->back()->with('success', 'Vidéo supprimer avec succès');
    }
}
