<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Auth\RegisterController;
use App\Http\Controllers\Auth\AuthController;

/*
|--------------------------------------------------------------------------
| Routes Web – Projet RH
|--------------------------------------------------------------------------
| Toutes les routes sont regroupées sous le préfixe "RH" pour cohérence.
| Exemple : http://localhost:8000/RH/register
|--------------------------------------------------------------------------
*/

Route::get('/RH', function () {
    return view('welcome');
})->name('rh.home');

// Groupe pour les routes d’authentification
Route::prefix('RH')->group(function () {

    // Inscription candidat
    Route::get('/register', [RegisterController::class, 'showForm'])
        ->name('rh.register.form');

    Route::post('/register', [RegisterController::class, 'store'])
        ->name('rh.register.store');

    // Connexion
    Route::get('/login', [AuthController::class, 'showLoginForm'])->name('rh.login.form');
    Route::post('/login', [AuthController::class, 'login'])->name('rh.login.process');

    // Déconnexion
    Route::get('/logout', [AuthController::class, 'logout'])->name('rh.logout');

});
