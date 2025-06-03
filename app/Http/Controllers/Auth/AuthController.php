<?php

namespace App\Http\Controllers\Auth;

use App\Models\Role;
use App\Models\User;
use App\Models\WebsiteSetting;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;

class AuthController extends Controller
{
    public function loginForm()
    {
        $logoPath = WebsiteSetting::getValue('login_logo') ?? '';
        return view('auth.login',compact('logoPath'));
    }

    public function login(Request $request)
    {
        $credentials = $request->validate([
            'email' => 'required|email',
            'password' => 'required|string|min:8'
        ]);

        if (Auth::attempt($credentials)) {
            $request->session()->regenerate();

            if (Auth::attempt($credentials)) {
                $request->session()->regenerate();
                switch (auth()->user()->role_id) {
                    case 1:
                        return redirect('/admin-dashboard');
                    case 2:
                        return redirect('/agent-dashboard');
                    case 3:
                        return redirect('/client-dashboard');
                    default:
                        break;
                }
            }
        }

        return back()->withErrors([
            'email' => "Les informations d'identification fournies ne correspondent pas à nos dossiers.",
        ])->onlyInput('email');
    }
    public function logout()
    {
        Auth::logout();

        request()->session()->invalidate();

        request()->session()->regenerateToken();

        return redirect('/login')->with("success", "Vous êtes déconnecté.");
    }
}

