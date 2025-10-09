<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Services\AuthService;
use Illuminate\Http\Request;

class AuthController extends Controller
{
    protected $authService;

    public function __construct(AuthService $authService)
    {
        $this->authService = $authService;
    }

    // Affichage du formulaire de login
    public function showLoginForm()
    {
        return view('auth.login');
    }

    // Traitement du login
    public function login(Request $request)
    {
        $request->validate([
            'email' => 'required|email',
            'password' => 'required|min:6',
        ]);

        $user = $this->authService->attemptLogin($request->email, $request->password);

        if (!$user) {
            return back()->withErrors(['email' => 'Identifiants incorrects.']);
        }

        // Stocker l'utilisateur dans la session
        session(['user_id' => $user->id, 'user_role' => $user->role]);

        // Rediriger selon le rôle
        switch ($user->role) {
            case 'rh':
                return redirect('/RH/dashboard');
            case 'admin':
                return redirect('/RH/admin');
            default:
                return redirect('/RH/candidat');
        }
    }

    // Déconnexion
    public function logout()
    {
        session()->flush();
        return redirect('/RH/login')->with('success', 'Déconnexion réussie.');
    }
}
