<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Services\AuthService;
use Illuminate\Http\Request;

class RegisterController extends Controller
{
    protected $authService;

    public function __construct(AuthService $authService)
    {
        $this->authService = $authService;
    }

    public function showForm()
    {
        return view('auth.register');
    }

    public function store(Request $request)
    {
        $request->validate([
            'nom' => 'required|string|max:100',
            'prenom' => 'required|string|max:100',
            'email' => 'required|email',
            'password' => 'required|min:6',
            'date_naissance' => 'required|date',
            'cv' => 'required|file|mimes:pdf,doc,docx|max:2048',
        ]);

        $this->authService->registerCandidat($request->all(), $request->file('cv'));

        return redirect('/RH/login')->with('success', 'Inscription réussie ! Vous pouvez maintenant vous connecter.');
    }
}
