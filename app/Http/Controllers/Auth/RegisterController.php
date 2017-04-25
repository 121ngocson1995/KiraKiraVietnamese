<?php

namespace App\Http\Controllers\Auth;

use App\User;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Validator;
use Illuminate\Foundation\Auth\RegistersUsers;
use Illuminate\Http\UploadedFile;

class RegisterController extends Controller
{
    /*
    |--------------------------------------------------------------------------
    | Register Controller
    | 登録のコントローラー
    |--------------------------------------------------------------------------
    |
    | This controller handles the registration of new users as well as their
    | validation and creation. By default this controller uses a trait to
    | provide this functionality without requiring any additional code.　
    | このコントローラーは、新しいユーザーの登録とそのユーザーの検証と作成を処理する。
    | デフォルトで、このコントローラーは特性を使用して、追加ルールを必要とせずにこの機能を提供する。
    |
    */

    use RegistersUsers;

    /**
     * Where to redirect users after registration.
     *　登録の後にユーザーをリダイレクトするの所です。
     *
     * @var string
     */
    protected $redirectTo = '/';

    /**
     * Create a new controller instance.
     *　新しいコントローラーのインスタンスを作成する。
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('guest');
    }

    /**
     * Get a validator for an incoming registration request.
     *　着信登録要求のため、バリデータを取る。
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
            'username' => 'required|alpha_dash|min:6|max:191|unique:users',
            'email' => 'required|email|max:191|unique:users',
            'password' => 'required|min:6|max:24|confirmed',
            'gender' => 'numeric|between:0,1',
            'date-of-birth' => 'required|date|before:' . $todayDate .'|18yo',
            'cv' => 'required|file|max:10240',
            ],
            [
            '18yo' => 'You must be 18 years or older',
            ]);
    }

    /**
     * Save CV file into storage for later review..
     *　レビューのため、ストレージでCVファイルを保存する。
     *
     * @param  Request  $request
     * @return string
     */
    protected function saveCV(\Illuminate\Http\Request $request)
    {
        $t = time();
        $t = date("Y-m-d-H-i-s",$t);
        $destinationPath = 'cv'; 
        $extension = $request->cv->extension();

        $fileName = "CV_" . $request->username . "_" . $t . '.' . $extension;

        $path = $request->cv->storeAs('public/cv', $fileName);
        Storage::setVisibility($fileName, 'public');

        return $path;
    }

    /**
     * Create a new user instance after a valid registration.
     *　有効な登録の後、新しいインスタントのユーザーを作成する。
     *
     * @param  array  $data
     * @return User
     */
    protected function create(array $data, $cv_path)
    {
        return User::create([
            'username' => $data['username'],
            'first_name' => $data['first-name'],
            'last_name' => $data['last-name'],
            'email' => $data['email'],
            'password' => bcrypt($data['password']),
            'gender' => $data['gender'],
            'date_of_birth' => $data['date-of-birth'],
            'cv' => $cv_path,
            ]);
    }
}