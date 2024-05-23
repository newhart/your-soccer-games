<?php

namespace App\Http\Controllers;

use App\Http\Requests\PasswordChangeRequest;
use App\Http\Requests\ProfilePartenaireRequest;
use App\Http\Requests\UserPartenaireRequest;
use App\Mail\SendingEmailPartenaire;
use App\Models\User;
use App\Services\ProductSearchService;
use Illuminate\Contracts\View\View;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Routing\Route;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Crypt;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\URL;

class UserPartenaireController extends Controller
{
    public function index(Request $request): View
    {
        $this->authorize('view', new User());
        $search = $request->get('search');
        $users = User::where('type', '<>',  'Admin')
            ->with('profile')
            ->paginate(10);
        return view('partenaires.index', ['search' => $search, 'users' => $users]);
    }

    public function store(UserPartenaireRequest $request, ProfilePartenaireRequest $profileRequest): RedirectResponse
    {
        // $this->authorize('create');
        $data = $request->validated(); // validation email and name
        $data['type']  = 'Partenaire';
        $user = User::create($data); // create new user partenaires
        if ($user) {
            $user->profile()->create($profileRequest->validated());
        }
        $confirmationLink = URL::route('partenaires.verify', ['token' => Crypt::encrypt($user->email)]); // generate url for the confirmation user
        $email_infos = [
            'title' => 'Creation nouvelle partenaire',
            'name' => $user->name,
            'email' => $user->email,
            'url' => $confirmationLink
        ];

        Mail::to($user->email)->send(new SendingEmailPartenaire($email_infos));

        return redirect()->route('partenaires.index')->with(['success' => 'Partenaire creer avec success']);
    }

    public function verify(Request $request): View
    {
        $encryptedEmail = $request->input('token');
        Crypt::decrypt($encryptedEmail);
        return view('partenaires.verify', ['email' => $encryptedEmail]);
    }

    public function updatedPassword(PasswordChangeRequest $request): RedirectResponse
    {
        $data = $request->validated();
        $encryptedEmail = $request->input('token');
        $email = Crypt::decrypt($encryptedEmail);
        $user = User::where('email', $email)
            ->where('type', '<>', 'Admin')
            ->first();
        $user->password = Hash::make($data['password']); // create new password for the partenaire after validation;
        $user->email_verified_at = now(); // set time for the verification email
        $user->save();
        $credentials = ['email' => $email, 'password' => $data['password']];
        if (Auth::attempt($credentials)) {
            return redirect()->intended('/home');
        } else {
            return back()->withInput()->withErrors(['email' => 'Les informations d\'identification sont incorrectes.']);
        }
    }

    public function destroy(User $user): RedirectResponse
    {
        $this->authorize('delete', $user);
        $user->delete();
        return redirect()->back()->with(['success' => 'Partenaire supprimer avec success']);
    }

    public function update(UserPartenaireRequest $request, User $user, ProfilePartenaireRequest $profileRequest): RedirectResponse
    {
        $this->authorize('update', $user);
        $user->update($request->validated());
        $user->profile()->update($profileRequest->validated());
        return redirect()->back()->with(['success' => 'Partenaire modifier avec success']);
    }

    public function getMatch(Request $request, User $user)
    {
        $route = 'partenaires.userMatch';
        $data = ProductSearchService::productSearch($request, $user->id);
        $route = ['route' => 'partenaires.userMatch', 'user' =>  $user , 'partenaire' => $user->name];
        $data = array_merge($route, $data);
        return view('front.allmatch', $data);
    }
}
