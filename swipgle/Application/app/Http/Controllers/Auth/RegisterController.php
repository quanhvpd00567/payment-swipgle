<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Models\User;
use App\Providers\RouteServiceProvider;
use Carbon\Carbon;
use DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;
use Laravel\LegacyUi\Auth\RegistersUsers;

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
    protected $redirectTo = RouteServiceProvider::HOME;

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
        if (env('NOCAPTCHA_SITEKEY') != null && env('NOCAPTCHA_SECRET') != null) {
            return Validator::make($data, [
                'name' => ['required', 'string', 'min:8', 'max:100'],
                'email' => ['required', 'string', 'email', 'max:255', 'unique:users'],
                'password' => ['required', 'string', 'min:8', 'confirmed'],
                'agree' => ['required'],
                'g-recaptcha-response' => ['required', 'captcha'],
            ]);
        } else {
            return Validator::make($data, [
                'name' => ['required', 'string', 'min:8', 'max:100'],
                'email' => ['required', 'string', 'email', 'max:255', 'unique:users'],
                'password' => ['required', 'string', 'min:8', 'confirmed'],
                'agree' => ['required'],
            ]);
        }
    }

    /**
     * Create a new user instance after a valid registration.
     *
     * @param  array  $data
     * @return \App\Models\User
     */
    protected function create(array $data)
    {
        // Get settings data
        $settings = DB::table('settings')->find(1);
        // Give users free space
        $space = $settings->free_storage;
        // check if email verification enabled
        if ($settings->email_verification == 2) {
            $email_verified_at = Carbon::now();
        } else {
            $email_verified_at = null;
        }
        // Default avatar
        $avatar = "default.png";
        return User::create([
            'name' => $data['name'],
            'email' => $data['email'],
            'avatar' => $avatar,
            'space' => $space,
            'email_verified_at' => $email_verified_at,
            'password' => Hash::make($data['password']),
        ]);
    }
}
