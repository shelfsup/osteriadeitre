<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Providers\RouteServiceProvider;
use Illuminate\Foundation\Auth\VerifiesEmails;
use Illuminate\Support\Facades\Auth;
use App\Model\User;

class VerificationController extends Controller
{
    /*
    |--------------------------------------------------------------------------
    | Email Verification Controller
    |--------------------------------------------------------------------------
    |
    | This controller is responsible for handling email verification for any
    | user that recently registered with the application. Emails may also
    | be re-sent if the user didn't receive the original email message.
    |
    */

    use VerifiesEmails;

    /**
     * Where to redirect users after verification.
     *
     * @var string
     */
    protected $redirectTo = RouteServiceProvider::HOME;

    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('auth');
        $this->middleware('signed')->only('verify');
        $this->middleware('throttle:6,1')->only('verify', 'resend');
    }

    public function verifyUserAuthorization($role = null, $mod = true)
    {
        if ($mod == 'true') {
            $mod = true;
        } else {
            $mod = false;
        }

        $setUserAuthorization = Auth::user()->setAuthorization($role, $mod);
        $getUserAuthorization = Auth::user()->getAuthorizedVar();
        if ($getUserAuthorization) {
            return response()->json(['result' => 'success', 'message' => '']);
        }
        return response()->json(['result' => 'error', 'message' => 'Non sei autorizzato a compiere questa azione!']);
    }
}
