<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Auth\RegisterController;
use App\Http\Controllers\Auth\AuthController;
use App\Http\Controllers\DepartementController;
use App\Http\Controllers\AnnonceController;
use App\Http\Controllers\TestController;
use App\Http\Controllers\CandidatureController;
use App\Http\Controllers\TestEnLigneController;
use App\Http\Controllers\ResultatController;
use App\Http\Controllers\EntretienController;
use App\Http\Controllers\EntretienCandidatController;
use App\Http\Controllers\EvaluationEntretienController;
use App\Http\Controllers\DecisionRecrutementController;


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



    Route::middleware(['auth.custom', 'role:rh'])->group(function () {
        Route::get('/annonces', [AnnonceController::class, 'index'])->name('annonces.index');
        Route::get('/annonces/create', [AnnonceController::class, 'create'])->name('annonces.create');
        Route::post('/annonces', [AnnonceController::class, 'store'])->name('annonces.store');
        Route::get('/annonces/{id}/edit', [AnnonceController::class, 'edit'])->name('annonces.edit');
        Route::post('/annonces/{id}/update', [AnnonceController::class, 'update'])->name('annonces.update');
        Route::get('/annonces/{id}/delete', [AnnonceController::class, 'destroy'])->name('annonces.delete');
        Route::get('/annonces/{id}/close', [AnnonceController::class, 'close'])->name('annonces.close');
    });




    Route::middleware(['auth.custom', 'role:rh'])->group(function () {
        Route::get('/tests/create', [TestController::class, 'create'])->name('tests.create');
        Route::post('/tests', [TestController::class, 'store'])->name('tests.store');
        Route::get('/tests/view', [TestController::class, 'view'])->name('tests.view');
        Route::get('/tests/delete/{id}', [TestController::class, 'destroy'])->name('tests.delete');
    });



    Route::middleware(['auth.custom', 'role:candidat'])->group(function () {
        Route::get('/candidatures', [CandidatureController::class, 'index'])->name('candidatures.index');
        Route::get('/candidature/{id}', [CandidatureController::class, 'show'])->name('candidatures.show');
        Route::get('/candidature/{id}/postuler', [CandidatureController::class, 'postuler'])->name('candidatures.postuler');
        Route::get('/candidatures/suivi', [CandidatureController::class, 'suivi'])->name('candidatures.suivi');
    });



    // CANDIDAT
    Route::middleware(['auth.custom', 'role:candidat'])->prefix('RH')->group(function () {
        Route::get('/tests/choisir', [TestEnLigneController::class, 'selectTest'])->name('tests.select');
        Route::get('/tests/{testId}/passer', [TestEnLigneController::class, 'show'])->name('tests.passer');
        Route::post('/tests/{testId}/submit', [TestEnLigneController::class, 'submit'])->name('tests.submit');
    });

    // RH
    Route::middleware(['auth.custom', 'role:rh'])->prefix('RH')->group(function () {
        Route::get('/resultats/choisir', [ResultatController::class, 'selectResult'])->name('resultats.select');
        Route::get('/resultats/{candidatureId}', [ResultatController::class, 'details'])->name('resultats.details');
    });



    // RH
    Route::middleware(['auth.custom', 'role:rh'])->prefix('RH')->group(function () {
        Route::get('/entretiens', [EntretienController::class, 'index'])->name('entretiens.index');
        Route::match(['get','post'], '/entretiens/planifier', [EntretienController::class, 'create'])->name('entretiens.create');
        Route::get('/entretiens/calendrier', [EntretienController::class, 'calendrier'])->name('entretiens.calendrier');
        Route::get('/entretiens/delete/{id}', [EntretienController::class, 'delete'])->name('entretiens.delete');
    });

    // CANDIDAT
    Route::middleware(['auth.custom', 'role:candidat'])->prefix('RH')->group(function () {
        Route::get('/entretiens/notifications', [EntretienCandidatController::class, 'index'])->name('entretiens.notifications');
        Route::get('/entretiens/{id}/{decision}', [EntretienCandidatController::class, 'reponse'])->name('entretiens.reponse');
    });


    Route::middleware(['auth.custom', 'role:rh'])->prefix('RH')->group(function () {
        Route::get('/evaluations', [EvaluationEntretienController::class, 'index'])->name('evaluations.index');
        Route::get('/evaluations/{id}/create', [EvaluationEntretienController::class, 'create'])->name('evaluations.create');
        Route::post('/evaluations/{id}/store', [EvaluationEntretienController::class, 'store'])->name('evaluations.store');
        Route::get('/evaluations/resultats', [EvaluationEntretienController::class, 'resultats'])->name('evaluations.resultats');
    });



    Route::middleware(['auth.custom', 'role:rh'])->prefix('RH')->group(function () {
        Route::get('/decisions/{candidatureId}', [DecisionRecrutementController::class, 'show'])->name('decisions.show');
        Route::get('/decisions/{candidatureId}/{decision}', [DecisionRecrutementController::class, 'update'])->name('decisions.update');
    });



});
