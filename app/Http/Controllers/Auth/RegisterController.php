<?php

namespace App\Http\Controllers\Auth;

use App\User;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Validator;
use Illuminate\Foundation\Auth\RegistersUsers;

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
    protected $redirectTo = '/';

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
        $todayDate = date("Y/m/d");

        Validator::extend('18yo', function ($attribute, $value, $parameters, $validator) {
            return strtotime($value) <= strtotime('-18 years');
        });

        return Validator::make($data, [
            'first-name' => 'required|alpha|max:30',
            'last-name' => 'required|alpha|max:30',
            'username' => 'required|alpha_dash|max:255|unique:users',
            'email' => 'required|email|max:255|unique:users',
            'password' => 'required|min:6|max:24|confirmed',
            'gender' => 'numeric|between:0,1',
            'date-of-birth' => 'required|date|before:' . $todayDate .'|18yo',
        ],
        [
            '18yo' => 'You must be 18 years or older',
        ]);
    }

    /**
     * Create a new user instance after a valid registration.
     *
     * @param  array  $data
     * @return User
     */
    protected function create(array $data)
    {
        dd($data['first-name']);

        return User::create([
            'username' => $data['username'],
            'first_name' => $data['first-name'],
            'last_name' => $data['last-name'],
            'email' => $data['email'],
            'password' => bcrypt($data['password']),
            'gender' => $data['gender'],
            'date_of_birth' => $data['date-of-birth'],
        ]);
    }
}