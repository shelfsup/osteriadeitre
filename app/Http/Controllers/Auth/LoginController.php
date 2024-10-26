<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Models\TeamInvitation;
use App\Providers\RouteServiceProvider;
use Illuminate\Foundation\Auth\AuthenticatesUsers;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Laravel\Jetstream\Contracts\AddsTeamMembers;

class LoginController extends Controller
{
    /*
    |--------------------------------------------------------------------------
    | Login Controller
    |--------------------------------------------------------------------------
    |
    | This controller handles authenticating users for the application and
    | redirecting them to your home screen. The controller uses a trait
    | to conveniently provide its functionality to your applications.
    |
    */

    use AuthenticatesUsers;

    /**
     * Create a new controller instance.
     *
     * @return void
     */
    // public function __construct()
    // {
    //     $this->middleware('guest')->except('logout');
    // }

    public function switchTeam($team)
    {
        // Rimuovi l'utente da tutti i team
        $this->teams()->detach();

        // Aggiungi l'utente al nuovo team
        $this->teams()->attach($team);

        // Aggiorna il team corrente dell'utente
        $this->current_team_id = $team->id;
        $this->save();
    }

    public function login(Request $request)
    {

        // dd($request->password);
        $this->validateLogin($request);


        if ($this->attemptLogin($request)) {
            // Se l'utente è autenticato, verifica se ha un invito in sospeso
            $user = Auth::user();
            // dd($user);
            if ($user) {
                $pendingInvitation = TeamInvitation::where('email', $user->email)->first();

                //  dd($pendingInvitation);
                if ($pendingInvitation && $pendingInvitation->email == $user->email) {
                    // Accetta l'invito e esegui le azioni correlate
                    app(AddsTeamMembers::class)->add(
                        $pendingInvitation->team->owner,
                        $pendingInvitation->team,
                        $pendingInvitation->email,
                        $pendingInvitation->role
                    );

                    // Switcha il team
                    // dd($pendingInvitation->team); // Controlla il valore
                    $user->switchTeam($pendingInvitation->team);
                    // Cancella l'invito
                    $pendingInvitation->delete();

                    $user->save();

                }
            }

        }

        // If the class is using the ThrottlesLogins trait, we can automatically throttle
        // the login attempts for this application. We'll key this by the username and
        // the IP address of the client making these requests into this application.
        if (method_exists($this, 'hasTooManyLoginAttempts') &&
            $this->hasTooManyLoginAttempts($request)) {
            $this->fireLockoutEvent($request);

            return $this->sendLockoutResponse($request);
        }

        if ($this->attemptLogin($request)) {
            if ($request->hasSession()) {
                $request->session()->put('auth.password_confirmed_at', time());
                $request->session()->put('login.id', Auth::user()->id);
                $request->session()->put("failed.token", 0);
            }

            Auth::user()->setTeamOwnerId();
            return $this->sendLoginResponse($request);

        }

        // If the login attempt was unsuccessful we will increment the number of attempts
        // to login and redirect the user back to the login form. Of course, when this
        // user surpasses their maximum number of attempts they will get locked out.
        $this->incrementLoginAttempts($request);

        return $this->sendFailedLoginResponse($request);
    }

    public function redirectTo()
    {
        return route('dashboard');
    }

    public function redirectPath()
    {
        return $this->redirectTo();
    }
}
