<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Models\Product;
use App\Models\TypeMatch;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;

class HomeController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('auth');
    }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function index(Request $request)
    {
        $type_match = (new TypeMatch())->newQuery()->latest()->get();
        $query = (new Product())->newQuery()->with('type_match');
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
        if($request['date']){
            $date = $request['date']; 
            $query = $query->where('date_match' , $request['date']); 
        }else {
            $date = null; 
        }
        if (auth()->user()->type !== 'Admin') {
            $query = $query->where('user_id', auth()->user()->id);
        }
        $all_product = $query->latest()->paginate(10);
        return view('home', compact(['all_product', 'type_match', 'search' , 'date']));
    }

    public function updatePassword(Request $request)
    {
        # Validation
        $request->validate([
            'old_password' => 'required',
            'new_password' => 'required|confirmed',
        ]);

        #Match The Old Password
        if (!Hash::check($request->old_password, auth()->user()->password)) {
            return back()->with("error", "Le mot de passe actuel est incorrect!");
        }


        #Update the new Password
        User::whereId(auth()->user()->id)->update([
            'password' => Hash::make($request->new_password)
        ]);

        return back()->with("status", "Le mot de passe a été modifier avec succes!");
    }
}
