<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Providers\RouteServiceProvider;
use App\Models\User;
use Illuminate\Foundation\Auth\AuthenticatesUsers;
use Illuminate\Http\Request;
use Illuminate\Validation\ValidationException;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Hash;

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
     * Where to redirect users after login.
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
        $this->middleware('guest')->except('logout');
    }

    public function username()
    {
        return 'login';
    }

    protected function credentials(Request $request)
    {
        $login = $request->get('login');

        $field = filter_var($login, FILTER_VALIDATE_EMAIL) ? 'email' : 'username';

        return [
            $field => $login,
            'password' => $request->get('password'),
            'status' => 'active', // only active users
        ];
    }

    /**
     * Get the failed login response instance.
     */
    protected function sendFailedLoginResponse(Request $request)
    {
        $login = $request->get('login');
        $field = filter_var($login, FILTER_VALIDATE_EMAIL) ? 'email' : 'username';

        $user = User::where($field, $login)->first();

        $maxAttempts = 3; // or hardcode 5

        if ($user) {
            // Already inactive/locked
            if ($user->status !== 'active') {
                throw ValidationException::withMessages([
                    'login' => ['Your account is inactive. Please contact an admin or manager.'],
                ]);
            }

            // Active user: increment failed attempts
            $user->failed_login_attempts = (int) $user->failed_login_attempts + 1;

            if ($user->failed_login_attempts >= $maxAttempts) {
                // Lock account + rotate password
                $newPasswordPlain = Str::random(10); // decide how to share this if you need to

                $user->status = 'inactive';
                $user->password = Hash::make($newPasswordPlain);
                $user->failed_login_attempts = 0; // or keep at max, your choice
                $user->save();

                throw ValidationException::withMessages([
                    'login' => ['Your account has been locked due to multiple invalid login attempts. Please contact an admin or manager.'],
                ]);
            }

            $user->save();
        }

        // Generic invalid credentials
        throw ValidationException::withMessages([
            'login' => [trans('auth.failed')],
        ]);
    }


    // handels last login time
    protected function authenticated(Request $request, $user)
    {
        // increment session_version so all existing sessions become "old"
        $user->session_version = (int) $user->session_version + 1;

        $user->last_login_at = now();
        $user->failed_login_attempts = 0;
        $user->save();

        // store the new session version in this login’s session
        session(['session_version' => $user->session_version]);
    }

}
