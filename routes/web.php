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
use App\Http\Controllers\ContratController;
use App\Http\Controllers\ContratCandidatController;
use App\Http\Controllers\AffiliationSocialeController;
use App\Http\Controllers\NotificationController;
use App\Http\Controllers\EmployeController;
use App\Http\Controllers\TriCandidatController;
use App\Http\Controllers\FicheEmployeController;
use App\Http\Controllers\HistoriquePosteController;
use App\Http\Controllers\PromotionController;
use App\Http\Controllers\MobiliteController;
use App\Http\Controllers\DocumentRhController;
use App\Http\Controllers\DemandeCongéController;
use App\Http\Controllers\SoldeCongéController;
use App\Http\Controllers\HistoriqueCongéController;
use App\Http\Controllers\CalendrierGlobalController;
use App\Http\Controllers\SoldeCongesAdminController;
use App\Http\Controllers\NotificationCongesController;
use App\Http\Controllers\AlerteCongesController;


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


    // Tableau de bord RH (AdminLTE)
    Route::get('/dashboard', [App\Http\Controllers\DashboardRhController::class, 'index'])
        ->middleware(['auth.custom', 'role:rh'])
        ->name('rh.dashboard');

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

    // Calendrier Global (Entretiens + Congés)
    Route::middleware(['auth.custom', 'role:rh'])->prefix('RH')->group(function () {
        Route::get('/calendrier-global', [CalendrierGlobalController::class, 'index'])->name('calendrier.global');
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



    // RH
    Route::middleware(['auth.custom','role:rh'])->prefix('RH')->group(function () {
        Route::get('/contrats', [ContratController::class,'index'])->name('contrats.index');
        Route::match(['get','post'], '/contrats/create', [ContratController::class,'create'])->name('contrats.create');
        Route::match(['get','post'], '/contrats/{id}/edit', [ContratController::class,'edit'])->name('contrats.edit');
        Route::get('/contrats/status', [ContratController::class,'status'])->name('contrats.status');
    });

    // CANDIDAT
    Route::middleware(['auth.custom','role:candidat'])->prefix('RH')->group(function () {
        Route::get('/contrat/details', [ContratCandidatController::class,'details'])->name('contrat.details');
        Route::get('/contrat/{id}/notifier-fin', [ContratCandidatController::class,'notifierFinEssai'])->name('contrat.fin');
    });



    Route::middleware(['auth.custom', 'role:rh'])->prefix('RH')->group(function () {
        Route::get('/affiliations', [AffiliationSocialeController::class, 'index'])->name('affiliations.index');
        Route::match(['get','post'], '/affiliations/create', [AffiliationSocialeController::class, 'create'])->name('affiliations.create');
    });



    // Notifications
    Route::middleware(['auth.custom'])->prefix('RH')->group(function () {
        Route::get('/notifications', [NotificationController::class, 'index'])->name('notifications.index');
        Route::get('/notifications/{id}/read', [NotificationController::class, 'read'])->name('notifications.read');
    });

    // Employés (RH)
    Route::middleware(['auth.custom', 'role:rh'])->prefix('RH')->group(function () {
        Route::get('/employes', [EmployeController::class, 'index'])->name('employes.index');
    });

    // Tri des candidats par poste (RH)
    Route::middleware(['auth.custom', 'role:rh'])->group(function () {
        Route::get('/tri-candidats', [TriCandidatController::class, 'index'])->name('tri.index');
        Route::get('/tri-candidats/{annonceId}', [TriCandidatController::class, 'show'])->name('tri.show');
    });

    // Export des CV en Excel (RH)
    Route::middleware(['auth.custom', 'role:rh'])->prefix('RH')->group(function () {
        Route::get('/export-cv', [App\Http\Controllers\ExportCvController::class, 'index'])->name('export.cv');
        Route::get('/export-cv/download', [App\Http\Controllers\ExportCvController::class, 'export'])->name('export.cv.download');
    });

    // GESTION DU PERSONNEL - Fiches Employes (RH)
    Route::middleware(['auth.custom', 'role:rh'])->group(function () {
        Route::get('/fiches-employes', [FicheEmployeController::class, 'index'])->name('fiches-employes.index');
        Route::get('/fiches-employes/create', [FicheEmployeController::class, 'create'])->name('fiches-employes.create');
        Route::post('/fiches-employes', [FicheEmployeController::class, 'store'])->name('fiches-employes.store');
        Route::get('/fiches-employes/{id}', [FicheEmployeController::class, 'show'])->name('fiches-employes.show');
        Route::get('/fiches-employes/{id}/edit', [FicheEmployeController::class, 'edit'])->name('fiches-employes.edit');
        Route::post('/fiches-employes/{id}/update', [FicheEmployeController::class, 'update'])->name('fiches-employes.update');
        Route::get('/fiches-employes/{id}/delete', [FicheEmployeController::class, 'destroy'])->name('fiches-employes.delete');
    });

    // Historique des Postes (RH)
    Route::middleware(['auth.custom', 'role:rh'])->group(function () {
        Route::get('/historique-postes', [HistoriquePosteController::class, 'index'])->name('historique-postes.index');
        Route::get('/historique-postes/create', [HistoriquePosteController::class, 'create'])->name('historique-postes.create');
        Route::post('/historique-postes', [HistoriquePosteController::class, 'store'])->name('historique-postes.store');
        Route::get('/historique-postes/{id}', [HistoriquePosteController::class, 'show'])->name('historique-postes.show');
        Route::get('/historique-postes/{id}/edit', [HistoriquePosteController::class, 'edit'])->name('historique-postes.edit');
        Route::post('/historique-postes/{id}/update', [HistoriquePosteController::class, 'update'])->name('historique-postes.update');
        Route::get('/historique-postes/{id}/delete', [HistoriquePosteController::class, 'destroy'])->name('historique-postes.delete');
    });

    // Promotions (RH)
    Route::middleware(['auth.custom', 'role:rh'])->group(function () {
        Route::get('/promotions', [PromotionController::class, 'index'])->name('promotions.index');
        Route::get('/promotions/create', [PromotionController::class, 'create'])->name('promotions.create');
        Route::post('/promotions', [PromotionController::class, 'store'])->name('promotions.store');
        Route::get('/promotions/{id}', [PromotionController::class, 'show'])->name('promotions.show');
        Route::get('/promotions/{id}/edit', [PromotionController::class, 'edit'])->name('promotions.edit');
        Route::post('/promotions/{id}/update', [PromotionController::class, 'update'])->name('promotions.update');
        Route::get('/promotions/{id}/delete', [PromotionController::class, 'destroy'])->name('promotions.delete');
    });

    // Mobilites (RH)
    Route::middleware(['auth.custom', 'role:rh'])->group(function () {
        Route::get('/mobilites', [MobiliteController::class, 'index'])->name('mobilites.index');
        Route::get('/mobilites/create', [MobiliteController::class, 'create'])->name('mobilites.create');
        Route::post('/mobilites', [MobiliteController::class, 'store'])->name('mobilites.store');
        Route::get('/mobilites/{id}', [MobiliteController::class, 'show'])->name('mobilites.show');
        Route::get('/mobilites/{id}/edit', [MobiliteController::class, 'edit'])->name('mobilites.edit');
        Route::post('/mobilites/{id}/update', [MobiliteController::class, 'update'])->name('mobilites.update');
        Route::get('/mobilites/{id}/delete', [MobiliteController::class, 'destroy'])->name('mobilites.delete');
    });

    // Documents RH (RH)
    Route::middleware(['auth.custom', 'role:rh'])->group(function () {
        Route::get('/documents-rh', [DocumentRhController::class, 'index'])->name('documents-rh.index');
        Route::get('/documents-rh/create', [DocumentRhController::class, 'create'])->name('documents-rh.create');
        Route::post('/documents-rh', [DocumentRhController::class, 'store'])->name('documents-rh.store');
        Route::get('/documents-rh/{id}', [DocumentRhController::class, 'show'])->name('documents-rh.show');
        Route::get('/documents-rh/{id}/edit', [DocumentRhController::class, 'edit'])->name('documents-rh.edit');
        Route::post('/documents-rh/{id}/update', [DocumentRhController::class, 'update'])->name('documents-rh.update');
        Route::get('/documents-rh/{id}/delete', [DocumentRhController::class, 'destroy'])->name('documents-rh.delete');
    });

    // Gestion des Congés - Demandes (RH + Manager)
    Route::middleware(['auth.custom', 'role:rh|manager'])->group(function () {
        Route::get('/demandes-conges', [DemandeCongéController::class, 'index'])->name('demandes-conges.index');
        Route::get('/demandes-conges/create', [DemandeCongéController::class, 'create'])->name('demandes-conges.create');
        Route::post('/demandes-conges', [DemandeCongéController::class, 'store'])->name('demandes-conges.store');
        Route::get('/demandes-conges/{demandeCongé}', [DemandeCongéController::class, 'show'])->name('demandes-conges.show');
        Route::get('/demandes-conges/{demandeCongé}/edit', [DemandeCongéController::class, 'edit'])->name('demandes-conges.edit');
        Route::put('/demandes-conges/{demandeCongé}', [DemandeCongéController::class, 'update'])->name('demandes-conges.update');
        Route::post('/demandes-conges/{demandeCongé}/approuver', [DemandeCongéController::class, 'approuver'])->middleware('can.validate.conges')->name('demandes-conges.approuver');
        Route::post('/demandes-conges/{demandeCongé}/rejeter', [DemandeCongéController::class, 'rejeter'])->middleware('can.validate.conges')->name('demandes-conges.rejeter');
        Route::delete('/demandes-conges/{demandeCongé}', [DemandeCongéController::class, 'destroy'])->name('demandes-conges.destroy');
    });

    // Soldes de Conges (RH)
    Route::middleware(['auth.custom', 'role:rh'])->group(function () {
        Route::get('/soldes-conges', [SoldeCongéController::class, 'index'])->name('soldes-conges.index');
        Route::get('/soldes-conges/{employe}', [SoldeCongéController::class, 'show'])->name('soldes-conges.show');
        Route::get('/soldes-conges/{employe}/recalculer', [SoldeCongéController::class, 'recalculer'])->name('soldes-conges.recalculer');
    });

    // Historique des Conges (RH)
    Route::middleware(['auth.custom', 'role:rh'])->group(function () {
        Route::get('/historique-conges', [HistoriqueCongéController::class, 'index'])->name('historique-conges.index');
        Route::get('/historique-conges/{employe}', [HistoriqueCongéController::class, 'show'])->name('historique-conges.show');
    });

    // Administration des Soldes de Congés
    Route::middleware(['auth.custom', 'role:rh'])->group(function () {
        Route::get('/soldes-conges-admin/statut', [SoldeCongesAdminController::class, 'statut'])->name('soldes-admin.statut');
        Route::post('/soldes-conges-admin/calculer', [SoldeCongesAdminController::class, 'calculerSoldes'])->name('soldes-admin.calculer');
    });

    // Notifications de Congés
    Route::middleware(['auth.custom'])->group(function () {
        Route::get('/notifications-conges', [NotificationCongesController::class, 'index'])->name('notifications-conges.index');
        Route::post('/notifications-conges/{id}/lue', [NotificationCongesController::class, 'marquerCommeLue'])->name('notifications-conges.lue');
        Route::post('/notifications-conges/tout-lu', [NotificationCongesController::class, 'marquerToutCommeLu'])->name('notifications-conges.tout-lu');
        Route::delete('/notifications-conges/{id}', [NotificationCongesController::class, 'supprimer'])->name('notifications-conges.supprimer');
        Route::get('/notifications-conges/count', [NotificationCongesController::class, 'compterNonLues'])->name('notifications-conges.count');
    });

    // Alertes de Congés
    Route::middleware(['auth.custom'])->group(function () {
        Route::get('/alertes-conges', [AlerteCongesController::class, 'index'])->name('alertes-conges.index');
        Route::get('/alertes-conges/resolues', [AlerteCongesController::class, 'resolues'])->name('alertes-conges.resolues');
        Route::post('/alertes-conges/{id}/resoudre', [AlerteCongesController::class, 'resoudre'])->name('alertes-conges.resoudre');
        Route::get('/alertes-conges/count', [AlerteCongesController::class, 'compterNonResolues'])->name('alertes-conges.count');
        Route::get('/alertes-conges/statistiques', [AlerteCongesController::class, 'statistiques'])->name('alertes-conges.statistiques');
    });

});
