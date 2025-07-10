<?php

namespace App\Http\Controllers;

use App\Http\Requests\LoginFormRequest;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Session;

class BladeController extends Controller
{
    public function login(){
        return view('pages.login');
    }
    public function loginPost(LoginFormRequest $request){
        $request->authenticate();

        Session::regenerate();

        return redirect()->intended(route('dashboard'));
    }
    
    public function logout(LoginFormRequest $request){
        Auth::logout();
        session()->forget('sp_user_data');
        // session()->forget(config('auth.session'));
        Session::invalidate();
        Session::regenerateToken();
        return redirect()->route('login');
    }

}
