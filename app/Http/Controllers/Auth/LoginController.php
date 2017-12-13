<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Http\Proxy\TokenProxy;
use Illuminate\Foundation\Auth\AuthenticatesUsers;

class LoginController extends Controller
{

    use AuthenticatesUsers;
    protected $proxy;

    protected $redirectTo = '/home';

    public function __construct(TokenProxy $proxy)
    {
        $this->middleware('guest')->except('logout');
        $this->proxy=$proxy;
    }


    public function login()
    {
//        $this->validateLogin(request());
        return $this->proxy->login(request('email'),request('password'));
    }

    public function logout(){
        return $this->proxy->logout();
    }

    public function refresh(){
        return $this->proxy->refresh();
    }
}
