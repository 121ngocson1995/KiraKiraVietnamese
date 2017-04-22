<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Foundation\Auth\AuthenticatesUsers;

class LoginController extends Controller
{
    /*
    |--------------------------------------------------------------------------
    | Login Controller
    | ログインのコントローラー
    |--------------------------------------------------------------------------
    |
    | This controller handles authenticating users for the application and
    | redirecting them to your home screen. The controller uses a trait
    | to conveniently provide its functionality to your applications.
    | このコントローラーは、アプリケーションのため、認証したユーザーを処理し、あなたの画面にダイレクトする。
    | コントローラーは特性を使用して、アプリケーションにその便利な機能を提供する。
    |
    */

    use AuthenticatesUsers;

    /**
     * Where to redirect users after login.
     *　ログイン後にユーザーをリダイレクトするの所です。
     *
     * @var string
     */
    protected $redirectTo = '/';

    /**
     * Create a new controller instance.
     *　新しいインスタントのコントローラーを作成する。
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('guest', ['except' => 'logout']);
    }
}
