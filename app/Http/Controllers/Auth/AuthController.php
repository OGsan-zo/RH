<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Services\AuthService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;


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
            'password' => 'required|min:4',
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


    public function showChangePasswordForm()
    {
        return view('auth.change_password');
    }

    public function updatePassword(Request $request)
    {
        $request->validate([
            'current_password' => 'required|min:6',
            'new_password' => 'required|min:6|confirmed',
        ]);

        $user = \App\Models\User::find(session('user_id'));

        if (!$user || !Hash::check($request->current_password, $user->password)) {
            return back()->withErrors(['current_password' => 'Mot de passe actuel incorrect.']);
        }

        $user->password = Hash::make($request->new_password);
        $user->save();

        return redirect()->route('rh.candidat')->with('success', 'Mot de passe mis à jour avec succès.');
    }

}
