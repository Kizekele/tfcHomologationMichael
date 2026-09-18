<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class AuthController extends Controller
{
    public function showLogin()
    {
        return view('auth.login');
    }

    public function login(Request $request)
    {
        $credentials = $request->validate([
            'identifiant' => ['required', 'string'],
            'password' => ['required', 'string'],
        ], [], [
            'identifiant' => 'identifiant',
            'password' => 'mot de passe',
        ]);

        $field = filter_var($credentials['identifiant'], FILTER_VALIDATE_EMAIL)
            ? 'email'
            : 'matricule_agent';

        $authenticated = Auth::guard('agent')->attempt([
            $field => $credentials['identifiant'],
            'password' => $credentials['password'],
        ], $request->boolean('remember'));

        if (! $authenticated) {
            return back()
                ->withErrors(['identifiant' => 'Identifiants incorrects.'])
                ->onlyInput('identifiant');
        }

        $request->session()->regenerate();

        $request->user('agent')->forceFill(['last_login_at' => now()])->save();

        return redirect()->intended(route('dashboard'));
    }

    public function logout(Request $request)
    {
        Auth::guard('agent')->logout();

        $request->session()->invalidate();
        $request->session()->regenerateToken();

        return redirect()->route('login');
    }
}
