<?php

namespace App\Http\Controllers;

use App\Http\Requests\Auth\TwoFactorChallengeRequest;
use Illuminate\Http\Exceptions\HttpResponseException;
use Illuminate\Support\Facades\Auth;
use Laravel\Fortify\Contracts\TwoFactorChallengeViewResponse;
use Laravel\Fortify\Contracts\TwoFactorLoginResponse;
use Laravel\Fortify\Events\RecoveryCodeReplaced;

class TwoFactorChallengeController extends Controller
{
    //

    private $recovery_code_used;

    public function index(TwoFactorChallengeRequest $request)
    {
        if (!$request->hasChallengedUser()) {
            throw new HttpResponseException(redirect()->route('login'));
        }

        // return view('auth/two-factor-challenge');

        return app(TwoFactorChallengeViewResponse::class);
    }

    public function store(TwoFactorChallengeRequest $request)
    {
        $user = $request->challengedUser();

        if ($this->recovery_code_used != $request->validRecoveryCode()) {
            $user->replaceRecoveryCode($this->recovery_code_used);
            event(new RecoveryCodeReplaced($user, $this->recovery_code_used));
            $this->removeSessionKeys($request);

            Auth::login($user);

            $request->session()->regenerate();
            $request->session()->put('auth.2fa.passed', true);

            return app(TwoFactorLoginResponse::class);
        } else if (!$request->hasValidCode()) {

            if ($request->session()->increment("failed.token") >= 4 && !$request->session()->has('2fa.not')) {
                $this->removeSessionKeys($request);
                $request->session()->put('2fa.not', true);
            } else {
                // Incrementa il contatore solo se non hai ancora superato il limite

                $request->session()->increment("failed.token", 1);
                dd($request->session());
            }

            return redirect()->back();
        }

        $this->removeSessionKeys($request);

        Auth::login($user);

        $request->session()->regenerate();
        $request->session()->put('auth.2fa.passed', true);

        return app(TwoFactorLoginResponse::class);
    }

    private function removeSessionKeys($request)
    {
        $request->session()->remove('failed.token');
        $request->session()->remove('login.id');
    }
}
