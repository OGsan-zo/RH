<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Auth\RegisterController;
use App\Http\Controllers\Auth\AuthController;
use App\Http\Controllers\DepartementController;


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


    // Tableau de bord RH
    Route::get('/dashboard', function () {
        return view('rh.dashboard');
    })->middleware(['auth.custom', 'role:rh'])->name('rh.dashboard');

    // Tableau de bord Admin
    Route::get('/admin', function () {
        return view('admin.dashboard');
    })->middleware(['auth.custom', 'role:admin'])->name('admin.dashboard');

    // Espace candidat
    Route::get('/candidat', function () {
        return view('candidat.dashboard');
    })->middleware(['auth.custom', 'role:candidat'])->name('candidat.dashboard');


    // Modifier le mot de passe (candidat uniquement)
    Route::get('/change-password', [AuthController::class, 'showChangePasswordForm'])
        ->middleware(['auth.custom', 'role:candidat'])
        ->name('rh.password.form');

    Route::post('/change-password', [AuthController::class, 'updatePassword'])
        ->middleware(['auth.custom', 'role:candidat'])
        ->name('rh.password.update');



    Route::middleware(['auth.custom', 'role:rh'])->group(function () {
        Route::get('/departements', [DepartementController::class, 'index'])->name('departements.index');
        Route::get('/departements/create', [DepartementController::class, 'create'])->name('departements.create');
        Route::post('/departements', [DepartementController::class, 'store'])->name('departements.store');
        Route::get('/departements/{id}/edit', [DepartementController::class, 'edit'])->name('departements.edit');
        Route::post('/departements/{id}/update', [DepartementController::class, 'update'])->name('departements.update');
        Route::get('/departements/{id}/delete', [DepartementController::class, 'destroy'])->name('departements.delete');
    });


});
