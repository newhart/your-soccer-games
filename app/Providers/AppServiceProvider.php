<?php

namespace App\Providers;

use App\Models\Commandes;
use App\Models\OlderPlayer;
use App\Models\User;
// use App\Rules\Recaptcha;
// use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\View;
use Illuminate\Support\ServiceProvider;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    public function register(): void
    {
        //
    }

    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {
        View::composer('layouts.app', function ($view) {
            $users = User::whereHas('products')
                ->limit(5)
                ->get();
            $view->with([
                'users' => $users
            ]);
        });

        View::composer('layouts.admin', function ($view) {
            $name = Commandes::where('status', 'En attente')
                ->count();
            $new_older_player = OlderPlayer::where('status', 'En attente')->count();
            $view->with([
                'commandes' => $name,
                'older_player' => $new_older_player,
                'new_older_player' => $new_older_player
            ]);
        });
    }
}
