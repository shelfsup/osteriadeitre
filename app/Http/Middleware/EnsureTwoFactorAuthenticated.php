<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Foundation\Auth\AuthenticatesUsers;
use Illuminate\Support\Facades\Auth;

class EnsureTwoFactorAuthenticated
{
    use AuthenticatesUsers;

    public function handle($request, Closure $next)
    {
        // Verifica solo le rotte che richiedono autenticazione a due fattori
        $user = Auth::user();

        if ($user && $user->two_factor_secret) {
            // Se l'utente è autenticato e ha abilitato l'autenticazione a due fattori
            if (!$request->session()->has('auth.2fa.passed') && !$request->session()->has('2fa.not')) {

                return redirect('/2fa');

            } else if ($request->session()->has('2fa.not')) {
                // $request->session()->forget('2fa.not');
                Auth::logout();
                $this->removeSessionKeys($request);
                $request->session()->invalidate();
                $request->session()->regenerateToken();
                return redirect('/login');
            }
        }

        return $next($request);

    }

    private function removeSessionKeys($request)
    {
        $sessionKeys = array_keys(session()->all());

        foreach ($sessionKeys as $key) {
            if (strpos($key, 'login_web_') === 0) {
                session()->remove($key);
            }
        }
        $request->session()->remove('failed.token');
        $request->session()->remove('login.id');
        $request->session()->remove('2fa.not');
        $request->session()->remove('auth.password_confirmed_at');
    }

}
