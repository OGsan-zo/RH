<?php

namespace App\Services;

use App\Models\User;
use App\Models\Candidat;
use Illuminate\Support\Facades\Hash;
use Illuminate\Http\UploadedFile;

class AuthService
{
    public function registerCandidat(array $data, UploadedFile $cvFile)
    {
        // Créer utilisateur
        $user = User::create([
            'name' => $data['nom'] . ' ' . $data['prenom'],
            'email' => $data['email'],
            'password' => Hash::make($data['password']),
            'role' => 'candidat',
        ]);

        // Stocker le CV
        $cvPath = $cvFile->store('cv', 'public');

        // Créer profil candidat
        Candidat::create([
            'user_id' => $user->id,
            'nom' => $data['nom'],
            'prenom' => $data['prenom'],
            'email' => $data['email'],
            'date_naissance' => $data['date_naissance'],
            'cv_path' => $cvPath,
            'statut' => 'en_attente'
        ]);

        return $user;
    }
}
