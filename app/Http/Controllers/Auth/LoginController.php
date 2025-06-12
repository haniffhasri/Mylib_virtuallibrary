<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Foundation\Auth\AuthenticatesUsers;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class LoginController extends Controller
{
    use AuthenticatesUsers;

    /**
     * Where to redirect users after login.
     *
     * @var string
     */
    protected $redirectTo = '/dashboard';

    /**
     * Create a new controller instance.
     */
    public function __construct()
    {
        $this->middleware('guest')->except('logout');
        $this->middleware('auth')->only('logout');
    }

    /**
     * Use 'login' instead of 'email' for the login form field name.
     */
    public function username()
    {
        return 'login';
    }

    protected function authenticated(Request $request, $user){
        if (!$user->is_active) {
            Auth::logout();
            return redirect('/login')->withErrors([
                'login' => 'Your account has been deactivated.'
            ]);
        }
    }


    /**
     * Get the needed authorization credentials from the request.
     */
    protected function credentials(Request $request)
    {
        $login = $request->input('login');
        $field = filter_var($login, FILTER_VALIDATE_EMAIL) ? 'email' : 'username';

        return [
            $field => $login,
            'password' => $request->input('password'),
        ];
    }
}
