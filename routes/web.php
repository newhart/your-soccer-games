<?php

use App\Http\Controllers\admin\OlderPlayerController as AdminOlderPlayerController;
use App\Http\Controllers\ClubController;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\PlayerController;
use App\Http\Controllers\CountryController;
use App\Http\Controllers\PaymentController;
use App\Http\Controllers\ProductController;
use App\Http\Controllers\CommandesController;
use App\Http\Controllers\CompetionController;
use App\Http\Controllers\DiskController;
use App\Http\Controllers\LanguageController;
use App\Http\Controllers\MomentMatchController;
use App\Http\Controllers\OlderPLayerController;
use App\Http\Controllers\PrixMatchController;
use App\Http\Controllers\SendingEmailController;
use App\Http\Controllers\TempController;
use App\Http\Controllers\UserPartenaireController;


Route::get('/', [ProductController::class, 'index'])->name('index');
Route::get('/show/{id}', [ProductController::class, 'show']);
Route::get('/panier', [ProductController::class, 'panier'])->name('panier');
Route::get('/all-matchs', [ProductController::class, 'all'])->name('matchs');
Route::get('/paiment', function () {
    $total = session()->get('total');
    return view('front.paiment', compact('total'));
});


Route::get('change-language', [LanguageController::class,  'changeLanguage'])->name('change.language');
Route::post('sendEmail', [TempController::class, 'sendEmail'])->name('temp.sendemail');
Route::controller(PaymentController::class)
    ->prefix('paypal')
    ->group(function () {
        Route::get('/payment-return', function () {
            $total = session()->get('total');
            return view('paypal.success', compact('total'));
        })->name('create.payment');
        // Route::view('payment', 'front.paiment')->name('create.payment');
        Route::get('handle-payment', 'handlePayment')->name('make.payment');
        Route::get('cancel-payment', 'paymentCancel')->name('cancel.payment');
        Route::get('payment-success', 'paymentSuccess')->name('success.payment');
    });

// cart
Route::get('cart', [ProductController::class, 'cart'])->name('cart');
Route::get('add-to-cart/{id}', [ProductController::class, 'addToCart'])->name('add.to.cart');
Route::post('update-cart/{id}', [ProductController::class, 'update'])->name('update.cart');
Route::post('update-player-cart/{id}', [ProductController::class, 'updatePlayerCart'])->name('update.player.cart');
Route::get('validate-cart', [ProductController::class, 'validateCart'])->name('validate.cart');
Route::post('remove-from-cart/{id}', [ProductController::class, 'remove'])->name('remove.from.cart');

Route::controller(PaymentController::class)->group(function () {
    Route::get('stripe', 'stripe');
    Route::post('stripe', 'stripePost')->name('stripe.post');
});


Auth::routes();

// competition search
Route::get('competition/search', [CompetionController::class, 'search'])->name('competition.search');
//country search
Route::get('/country/search', [CountryController::class, 'search'])->name('club.country');
// club search
Route::get('/club/search', [ClubController::class, 'search'])->name('club.search');
// club ress/ource
Route::get('admin/clubs', [ClubController::class, 'index'])->name('clubs.index')->middleware('auth');
Route::put('/admin/clubs/change', [ClubController::class, 'changeName'])->name('clubs.change')->middleware('auth');
// Players resource
Route::get('/players', [PlayerController::class, 'index'])->name('players')->middleware('auth');
Route::get('/older', [AdminOlderPlayerController::class, 'index'])->name('players.older')->middleware('auth');
Route::post('/older/validate/{id}', [AdminOlderPlayerController::class, 'validate_older_player'])->name('players.older.validate')->middleware('auth');
Route::post('/players/older/delete/{id}', [AdminOlderPlayerController::class, 'destroy'])->name('players.older.delete')->middleware('auth');
Route::get('/players/search', [PlayerController::class, 'search'])->name('players.search');
Route::post('/players/store', [PlayerController::class, 'store'])->name('players.store')->middleware('auth');
Route::post('/players/update/{id}', [PlayerController::class, 'update'])->name('players.update')->middleware('auth');
Route::post('/players/delete/{id}', [PlayerController::class, 'destroy'])->name('players.destroy')->middleware('auth');

Route::get('/home', [App\Http\Controllers\HomeController::class, 'index'])->name('home')->middleware('auth');
Route::get('/competitions', [CompetionController::class, 'index'])->name('competition.index')->middleware('auth');
Route::post('/competitions/store', [CompetionController::class, 'store'])->name('competition.store')->middleware('auth');
Route::post('/competitions/update/{id}', [CompetionController::class, 'update'])->name('competition.update')->middleware('auth');
Route::post('/competitions/delete/{id}', [CompetionController::class, 'destroy'])->name('competition.destroy')->middleware('auth');
Route::post('/country/store', [CountryController::class, 'store'])->name('country.store')->middleware('auth');
Route::post('/country/update/{id}', [CountryController::class, 'update'])->name('country.update')->middleware('auth');
Route::post('/country/delete/{id}', [CountryController::class, 'destroy'])->name('country.destroy')->middleware('auth');
Route::get('/list-pays', [CountryController::class, 'index'])->name('country-item')->middleware('auth');
// commandes ressource
Route::post('/commandes/confirme', [CommandesController::class, 'confirm'])->name('commandes.confirm')->middleware('auth');
Route::put('/commandes/delete/{commandes}', [CommandesController::class, 'delete'])->name('commandes.delete')->middleware('auth');
Route::post('/commandes/validation/{commandes}', [CommandesController::class, 'validation'])->name('commandes.validation')->middleware('auth');
Route::get('/list-commandes', [CommandesController::class, 'index'])->name('list.commandes')->middleware('auth');
Route::post('/send-client', [SendingEmailController::class, 'send'])->name('email.send')->middleware('auth');
Route::post('/send-patch/{id}', [CommandesController::class, 'send'])->name('commandes.send_product')->middleware('auth');
Route::get('/send-patch/{id}', [CommandesController::class, 'senLinkPartenaire'])->name('commandes.link');
Route::post('/add-commandes', [CommandesController::class, 'store'])->name('store.commandes');
Route::post('/handel-save-client', [CommandesController::class, 'saveClient'])->name('save.client');
Route::get('/gestion-prix', [PrixMatchController::class, 'index'])->name('match.prix')->middleware('auth');
Route::post('/update-prix/{id_type}', [PrixMatchController::class, 'update'])->name('update.prix')->middleware('auth');
Route::post('/add-prix', [PrixMatchController::class, 'create'])->name('add.prix')->middleware('auth');
Route::delete('/list-pays/delete/{id}', [CountryController::class, 'destroy'])->name('country-destroy')->middleware('auth');
Route::prefix('/product')->name('product.')->group(function () {
    Route::post('/store', [ProductController::class, 'store'])->name('store')->middleware('auth');
    Route::post('/update/{id}', [ProductController::class, 'update_product'])->name('update')->middleware('auth');
    Route::post('/destroy/{id}', [ProductController::class, 'destroy'])->name('destroy')->middleware('auth');
});
// partenaires ressource
Route::prefix('/partenaires')->name('partenaires.')->group(function () {
    Route::get('/', [UserPartenaireController::class, 'index'])
        ->name('index')
        ->middleware('auth');
    Route::post('/create', [UserPartenaireController::class, 'store'])->name('store')->middleware('auth');
    Route::delete('/{user}', [UserPartenaireController::class, 'destroy'])->name('delete')->middleware('auth');
    Route::put('/modify/{user}', [UserPartenaireController::class, 'update'])->name('updateUser')->middleware('auth');
    Route::get('/match/{user}', [UserPartenaireController::class, 'getMatch'])->name('userMatch');
});
Route::get('/partenaires/verify', [UserPartenaireController::class, 'verify'])->name('partenaires.verify');
Route::put('/partenaires/verify', [UserPartenaireController::class, 'updatedPassword'])->name('partenaires.update');

Route::post('/change-password', [App\Http\Controllers\HomeController::class, 'updatePassword'])->name('update-password');

Route::get('/parametre', function () {
    return view('admin.setting');
})->name('admin.parametre');
// export all players
Route::get('/player/export', [PlayerController::class, 'exportPlayers'])->name('player.export');

Route::post('/disk', [DiskController::class, 'store'])->name('disk.store')->middleware('auth');
Route::get('/disk', [DiskController::class, 'index'])->name('disk.index')->middleware('auth');
Route::put('/disk/{disk}', [DiskController::class, 'update'])->name('disk.update')->middleware('auth');
Route::delete('/disk/user/{disk}', [DiskController::class, 'delete'])->name('disk.delete')->middleware('auth');


Route::get('/home/moment', [MomentMatchController::class, 'index'])->name('moment.index')->middleware('auth');
Route::post('/moment/video/create', [MomentMatchController::class, 'storeVideo'])->name('create.video')->middleware('auth');
Route::post('/moment/video/update/{videoMatch}', [MomentMatchController::class, 'updateVideo'])->name('update.video')->middleware('auth');
Route::post('/moment/video/delete/{videoMatch}', [MomentMatchController::class, 'deleteVideo'])->name('delete.video')->middleware('auth');


// Route older player
Route::get('/free-player-older', [OlderPLayerController::class, 'index'])->name('older.player');
Route::get('/free-player-older/edit/{olderPlayer}', [OlderPLayerController::class, 'edit'])->name('older.player.edit');
Route::post('/free-player-older-store', [OlderPLayerController::class, 'store'])->name('older.player.store');
Route::put('/free-player-older/{olderPlayer}', [OlderPLayerController::class, 'update'])->name('older.player.update');

Route::post('/plus-info/{id}', [OlderPLayerController::class, 'plus_info'])->name('older.player.plus_info');
