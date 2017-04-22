<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Foundation\Auth\ResetsPasswords;

class ResetPasswordController extends Controller
{
    /*
    |--------------------------------------------------------------------------
    | Password Reset Controller
    | パスワードをリセットするコントローラー
    |--------------------------------------------------------------------------
    |
    | This controller is responsible for handling password reset requests
    | and uses a simple trait to include this behavior. You're free to
    | explore this trait and override any methods you wish to tweak.　　
    | このコントローラーは、パスワードのリセット要求とユーザーの単純な処理を担当する。
    |　この特徴を自由に検索し、調整したいメソッドをオーバーライドすることができる。
    |
    */

    use ResetsPasswords;

    /**
     * Where to redirect users after resetting their password.
     *　パスワードをリセットすることの後に、ユーザーをリダイレクトするの所です。
     *
     * @var string
     */
    protected $redirectTo = '/home';

    /**
     * Create a new controller instance.
     *　新しいインスタントのコントローラーを作成する。
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('guest');
    }
}
