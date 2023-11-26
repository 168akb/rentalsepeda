<?php

namespace App\Http\Controllers\Auth;
//© 2020 Copyright: Tahu Coding
use App\Http\Controllers\Controller;
use App\Providers\RouteServiceProvider;
use Illuminate\Foundation\Auth\AuthenticatesUsers;
use Illuminate\Support\Facades\Auth;
use App\User;
use  Illuminate\Http\Request;

class LoginController extends Controller
{
    

    use AuthenticatesUsers;

    /**
     * Where to redirect users after login.
     *
     * @var string
     * @param  \Illuminate\Http\Request $request
     */
    protected $redirectTo = RouteServiceProvider::HOME;

    /**
     * Create a new controller instance.
     *
     * @return void
     */
    // public function authenticate(Request $request){
    //     if(! \Auth::user()->active){
    //         \Auth::logout();
    //         return redirect()->back();
    //     }
    // }

    public function __construct()
    {
        $this->middleware('guest')->except('logout');
    }

    // public function credentials(Request $request){
    //     return ['email'=>$request->{$this->username()}, 'password'=>$request->password, 'active'=>'1'];
    // }
}
