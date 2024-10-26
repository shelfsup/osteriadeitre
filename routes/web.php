<?php

use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\App;
use Laravel\Jetstream\Jetstream;
use App\Http\Controllers\TeamInvitationController;
use App\Http\Controllers\TwoFactorChallengeController;


App::setLocale('it');

Route::get('/menu', function () {
    return view('menu-online');
})->name('menu_ristorante');

Route::get('/menu-asporto', function () {
    return view('menu-asporto-online');
})->name('menu_asporto_ristorante');


Route::get('/', function () {
    return view('scelta-menu-online');
});

// Route::get('/menù-asporto', function () {
//     return view('menu-online-asporto');
// })->name('menu_asporto');

// ROTTA PER AUTENTICAZIONE A DUE FATTORI
Route::get('/2fa', [TwoFactorChallengeController::class, 'index'])->name('two-factor.login-custom');

Route::post('/2fa', [TwoFactorChallengeController::class, 'store'])->name('two-factor.login-post');

// Auth::routes();


Route::middleware([
    // 'auth:sanctum',
    'auth',
    config('jetstream.auth_session'),
    'web',
    'verified',
    'ensure.two.factor.authenticated',
    // EnsureTwoFactorAuthenticated::class
])->group(function () {

    Route::get('/dashboard', function () {
        return view('dashboard');
    })->name('dashboard');

    Route::get('/il-mio-menù', function () {
        return view('il-mio-menu');
    })->name('Il Mio Menù');

    Route::get('/gli-special', function () {
        return view('i-fuori-menu');
    })->name('Gli Special');

    Route::get('/le-promozioni', function () {
        return view('il-mio-menu');
    })->name('Le Promozioni');

});


// SOVRASCRIVO LA ROTTA DI JETSTREAM PER GLI INVITI AD UNIRSI A UN TEAM
Route::group(['middleware' => config('jetstream.middleware', ['web'])], function () {

    $authMiddleware = config('jetstream.guard')
        ? 'auth:' . config('jetstream.guard')
        : 'auth';

    $authSessionMiddleware = config('jetstream.auth_session', false)
        ? config('jetstream.auth_session')
        : null;

    Route::group(['middleware' => array_values(array_filter([$authMiddleware, $authSessionMiddleware, 'verified']))], function () {
        // Teams...
        if (Jetstream::hasTeamFeatures()) {
            Route::get('/team-invitations/{invitation}', [TeamInvitationController::class, 'accept'])
                ->middleware(['signed'])
                ->name('team-invitations.accept');
        }
    });
});
