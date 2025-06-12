<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Foundation\Auth\RegistersUsers;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;
use App\Events\UserRegistered;
use App\Models\LibrarianValidationCode;
use Illuminate\Support\Facades\Mail;
use App\Mail\SendWelcomeMail;
use Illuminate\Support\Facades\Log;
class RegisterController extends Controller
{
    /*
    |--------------------------------------------------------------------------
    | Register Controller
    |--------------------------------------------------------------------------
    |
    | This controller handles the registration of new users as well as their
    | validation and creation. By default this controller uses a trait to
    | provide this functionality without requiring any additional code.
    |
    */

    use RegistersUsers;

    /**
     * Where to redirect users after registration.
     *
     * @var string
     */
    protected $redirectTo = '/profile-picture';

    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('guest');
    }

    /**
     * Get a validator for an incoming registration request.
     *
     * @param  array  $data
     * @return \Illuminate\Contracts\Validation\Validator
     */
    protected function validator(array $data)
    {
        return Validator::make($data, [
            'name' => ['required', 'string', 'max:255'],
            'username' => ['required', 'string', 'max:255', 'unique:users'],
            'email' => ['required', 'string', 'email', 'max:255', 'unique:users'],
            'password' => ['required', 'string', 'min:8', 'confirmed'],
            'validation_code' => [
                'nullable',
                'string',
                function ($attribute, $value, $fail) {
                    $code = LibrarianValidationCode::where('code', $value)->first();
                    if (!$code || $code->used) {
                        $fail('The validation code is invalid or has already been used.');
                    }
                },
            ],
        ]);
    }


    /**
     * Create a new user instance after a valid registration.
     *
     * @param  array  $data
     * @return \App\Models\User
     */
    protected function create(array $data)
    {
        Log::info('Validation Code: ' . $data['validation_code']);

        $usertype = 'user';

        if (!empty($data['validation_code'])) {
            $code = LibrarianValidationCode::where('code', $data['validation_code'])->where('used', false)->first();

            if ($code) {
                $usertype = 'librarian';
                $code->used = true;
                $code->save();
            }
        }

        Log::info('Usertype assigned: ' . $usertype);

        $user = User::create([
            'name' => $data['name'],
            'username' => $data['username'],
            'email' => $data['email'],
            'password' => Hash::make($data['password']),
            'usertype' => $usertype,
        ]);

        // Notify all admins/librarians
        $admins = User::whereIn('usertype', ['admin'])->get();

        foreach ($admins as $admin) {
            $admin->notify(new \App\Notifications\NewUserNotification($user));
        }

        // Send welcome notification (database/broadcast)
        $user->notify(new \App\Notifications\NewWelcomeNotification());

        // Also return the user
        return $user;
    }
}
