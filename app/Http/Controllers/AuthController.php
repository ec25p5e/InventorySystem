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
            if(getUserRoles(Auth::id(), 'ADMIN') > 0) {
                return redirect('/admin');
            } else if(getUserRoles(Auth::id(), 'SEG_SPAI') > 0 || getUserRoles(Auth::id(), 'SEG_SSMT') > 0) {
                return redirect('/segretariato');
            } else if(getUserRoles(Auth::id(), 'CUSTODE_SPAI') > 0 || getUserRoles(Auth::id(), 'CUSTODE_SSMT') > 0) {
                return redirect('/custode');
            }
        }

        // Auth fallita
        return back()->withErrors(['email' => 'Credenziali non valide']);
    }

    public function logout() {
        Auth::logout();
        return redirect('/');
    }

}
