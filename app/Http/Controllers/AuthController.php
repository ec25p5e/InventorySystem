<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class AuthController extends Controller
{

    public function login() {
        return view('auth.login');
    }

    public function authenticate(Request $request) {
        $credentials = $request->only('email', 'password');

        if(Auth::attempt($credentials)) {
            return redirect('/dashboard');
        }

        // Auth fallita
        return back()->withErrors(['email' => 'Credenziali non valide']);
    }

    public function logout() {
        Auth::logout();
        return redirect('/');
    }

}
