<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\User;

class AuthController extends Controller
{

    public function login() {
        $hashedPassword = bcrypt('123');
        echo $hashedPassword;
        return view('auth.login');
    }

    public function authenticate(Request $request) {
        $credentials = $request->only('email', 'password');

        if(Auth::attempt($credentials)) {
            // Auth riuscita
            return redirect()->intended('/products');
        }

        // Auth fallita
        return back()->withErrors(['email' => 'Credenziali non valide']);
    }

    public function logout() {
        Auth::logout();
        return redirect('/login');
    }

}
