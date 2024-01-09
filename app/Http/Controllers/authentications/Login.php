<?php

namespace App\Http\Controllers\authentications;

use App\Http\Controllers\Controller;
use App\Http\Requests\LoginRequest;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Session;

class Login extends Controller
{
    public function index()
    {
        return view('content.authentications.login');
    }

    public function process(LoginRequest $request)
    {
        $credentials = $request->getCredentials();

        if (!Auth::validate($credentials)) {
            return redirect()->to('/')->withErrors(trans('Email atau password salah'));
        }

        $user = Auth::getProvider()->retrieveByCredentials($credentials);

        Auth::login($user);

        return $this->authenticated($request, $user);
    }

    protected function authenticated(Request $request, $user)
    {
        return redirect()->intended('/dashboard');
    }

    public function logout()
    {
        Session::flush();

        Auth::logout();

        return redirect('/');
    }
}
