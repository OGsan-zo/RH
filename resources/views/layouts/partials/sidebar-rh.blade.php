<ul class="nav nav-pills nav-sidebar flex-column" data-widget="treeview" role="menu" data-accordion="false">
    <!-- Dashboard -->
    <li class="nav-item">
        <a href="{{ route('rh.dashboard') }}" class="nav-link {{ request()->routeIs('rh.dashboard') ? 'active' : '' }}">
            <i class="nav-icon fas fa-tachometer-alt"></i>
            <p>Dashboard RH</p>
        </a>
    </li>

    <!-- Départements -->
    <li class="nav-item">
        <a href="{{ route('departements.index') }}" class="nav-link {{ request()->routeIs('departements.*') ? 'active' : '' }}">
            <i class="nav-icon fas fa-building"></i>
            <p>Départements</p>
        </a>
    </li>

    <li class="nav-header">RECRUTEMENT</li>

    <!-- Annonces -->
    <li class="nav-item {{ request()->routeIs('annonces.*') ? 'menu-open' : '' }}">
        <a href="#" class="nav-link {{ request()->routeIs('annonces.*') ? 'active' : '' }}">
            <i class="nav-icon fas fa-bullhorn"></i>
            <p>
                Annonces
                <i class="right fas fa-angle-left"></i>
            </p>
        </a>
        <ul class="nav nav-treeview">
            <li class="nav-item">
                <a href="{{ route('annonces.index') }}" class="nav-link {{ request()->routeIs('annonces.index') ? 'active' : '' }}">
                    <i class="far fa-circle nav-icon"></i>
                    <p>Liste des annonces</p>
                </a>
            </li>
            <li class="nav-item">
                <a href="{{ route('annonces.create') }}" class="nav-link {{ request()->routeIs('annonces.create') ? 'active' : '' }}">
                    <i class="far fa-circle nav-icon"></i>
                    <p>Créer une annonce</p>
                </a>
            </li>
        </ul>
    </li>

    <!-- Tri des Candidats -->
    <li class="nav-item">
        <a href="{{ route('tri.index') }}" class="nav-link {{ request()->routeIs('tri.*') ? 'active' : '' }}">
            <i class="nav-icon fas fa-sort-amount-down"></i>
            <p>Tri des Candidats</p>
        </a>
    </li>

    <!-- Tests QCM -->
    <li class="nav-item {{ request()->routeIs('tests.*') || request()->routeIs('resultats.*') ? 'menu-open' : '' }}">
        <a href="#" class="nav-link {{ request()->routeIs('tests.*') || request()->routeIs('resultats.*') ? 'active' : '' }}">
            <i class="nav-icon fas fa-clipboard-check"></i>
            <p>
                Tests QCM
                <i class="right fas fa-angle-left"></i>
            </p>
        </a>
        <ul class="nav nav-treeview">
            <li class="nav-item">
                <a href="{{ route('tests.create') }}" class="nav-link {{ request()->routeIs('tests.create') ? 'active' : '' }}">
                    <i class="far fa-circle nav-icon"></i>
                    <p>Créer un test QCM</p>
                </a>
            </li>
            <li class="nav-item">
                <a href="{{ route('tests.view') }}" class="nav-link {{ request()->routeIs('tests.view') ? 'active' : '' }}">
                    <i class="far fa-circle nav-icon"></i>
                    <p>Voir les tests QCM</p>
                </a>
            </li>
            <li class="nav-item">
                <a href="{{ route('resultats.select') }}" class="nav-link {{ request()->routeIs('resultats.*') ? 'active' : '' }}">
                    <i class="far fa-circle nav-icon"></i>
                    <p>Résultats QCM candidats</p>
                </a>
            </li>
        </ul>
    </li>

    <!-- Entretiens -->
    <li class="nav-item {{ request()->routeIs('entretiens.*') || request()->routeIs('evaluations.*') ? 'menu-open' : '' }}">
        <a href="#" class="nav-link {{ request()->routeIs('entretiens.*') || request()->routeIs('evaluations.*') ? 'active' : '' }}">
            <i class="nav-icon fas fa-calendar-alt"></i>
            <p>
                Entretiens
                <i class="right fas fa-angle-left"></i>
            </p>
        </a>
        <ul class="nav nav-treeview">
            <li class="nav-item">
                <a href="{{ route('entretiens.index') }}" class="nav-link {{ request()->routeIs('entretiens.index') ? 'active' : '' }}">
                    <i class="far fa-circle nav-icon"></i>
                    <p>Gestion des entretiens</p>
                </a>
            </li>
            <li class="nav-item">
                <a href="{{ route('entretiens.calendrier') }}" class="nav-link {{ request()->routeIs('entretiens.calendrier') ? 'active' : '' }}">
                    <i class="far fa-circle nav-icon"></i>
                    <p>Calendrier des entretiens</p>
                </a>
            </li>
            <li class="nav-item">
                <a href="{{ route('evaluations.index') }}" class="nav-link {{ request()->routeIs('evaluations.index') ? 'active' : '' }}">
                    <i class="far fa-circle nav-icon"></i>
                    <p>Évaluer les entretiens</p>
                </a>
            </li>
            <li class="nav-item">
                <a href="{{ route('evaluations.resultats') }}" class="nav-link {{ request()->routeIs('evaluations.resultats') ? 'active' : '' }}">
                    <i class="far fa-circle nav-icon"></i>
                    <p>Résultats globaux</p>
                </a>
            </li>
        </ul>
    </li>

    <!-- Décision de recrutement -->
    <li class="nav-item">
        <a href="{{ route('evaluations.resultats') }}" class="nav-link {{ request()->routeIs('decisions.*') ? 'active' : '' }}">
            <i class="nav-icon fas fa-gavel"></i>
            <p>Décision de recrutement</p>
        </a>
    </li>

    <!-- Contrats -->
    <li class="nav-item {{ request()->routeIs('contrats.*') ? 'menu-open' : '' }}">
        <a href="#" class="nav-link {{ request()->routeIs('contrats.*') ? 'active' : '' }}">
            <i class="nav-icon fas fa-file-contract"></i>
            <p>
                Contrats
                <i class="right fas fa-angle-left"></i>
            </p>
        </a>
        <ul class="nav nav-treeview">
            <li class="nav-item">
                <a href="{{ route('contrats.index') }}" class="nav-link {{ request()->routeIs('contrats.index') ? 'active' : '' }}">
                    <i class="far fa-circle nav-icon"></i>
                    <p>Contrats</p>
                </a>
            </li>
            <li class="nav-item">
                <a href="{{ route('contrats.status') }}" class="nav-link {{ request()->routeIs('contrats.status') ? 'active' : '' }}">
                    <i class="far fa-circle nav-icon"></i>
                    <p>Statut des contrats</p>
                </a>
            </li>
        </ul>
    </li>

    <!-- Affiliations sociales -->
    <li class="nav-item">
        <a href="{{ route('affiliations.index') }}" class="nav-link {{ request()->routeIs('affiliations.*') ? 'active' : '' }}">
            <i class="nav-icon fas fa-hospital"></i>
            <p>Affiliations sociales</p>
        </a>
    </li>

    <!-- GESTION DU PERSONNEL - Menu Principal Déroulant -->
    <li class="nav-item {{ request()->routeIs('fiches-employes.*', 'historique-postes.*', 'promotions.*', 'mobilites.*', 'documents-rh.*') ? 'menu-open' : '' }}">
        <a href="#" class="nav-link {{ request()->routeIs('fiches-employes.*', 'historique-postes.*', 'promotions.*', 'mobilites.*', 'documents-rh.*') ? 'active' : '' }}" style="background-color: #e7f3ff; border-left: 4px solid #007bff;">
            <i class="nav-icon fas fa-briefcase" style="color: #007bff; font-weight: bold;"></i>
            <p style="font-weight: bold; color: #0056b3;">
                📋 GESTION DU PERSONNEL
                <i class="right fas fa-angle-left"></i>
            </p>
        </a>
        <ul class="nav nav-treeview">
            <!-- A. Fiche Employé Complète -->
            <li class="nav-item {{ request()->routeIs('fiches-employes.*') ? 'menu-open' : '' }}">
                <a href="#" class="nav-link {{ request()->routeIs('fiches-employes.*') ? 'active' : '' }}">
                    <i class="nav-icon fas fa-id-card" style="color: #17a2b8;"></i>
                    <p>
                        Fiche Employé
                        <i class="right fas fa-angle-left"></i>
                    </p>
                </a>
                <ul class="nav nav-treeview">
                    <li class="nav-item">
                        <a href="{{ route('fiches-employes.index') }}" class="nav-link {{ request()->routeIs('fiches-employes.index') ? 'active' : '' }}">
                            <i class="far fa-circle nav-icon"></i>
                            <p>Liste des fiches</p>
                        </a>
                    </li>
                    <li class="nav-item">
                        <a href="{{ route('fiches-employes.create') }}" class="nav-link {{ request()->routeIs('fiches-employes.create') ? 'active' : '' }}">
                            <i class="far fa-circle nav-icon"></i>
                            <p>Créer une fiche</p>
                        </a>
                    </li>
                </ul>
            </li>

            <!-- B. Suivi du Contrat de Travail -->
            <li class="nav-item">
                <a href="#" class="nav-link" style="color: #666;">
                    <i class="nav-icon fas fa-file-contract" style="color: #ffc107;"></i>
                    <p>
                        Suivi du Contrat
                        <span class="badge badge-warning right">À venir</span>
                    </p>
                </a>
            </li>

            <!-- C. Historique des Postes, Promotions, Mobilités -->
            <li class="nav-item {{ request()->routeIs('historique-postes.*', 'promotions.*', 'mobilites.*') ? 'menu-open' : '' }}">
                <a href="#" class="nav-link {{ request()->routeIs('historique-postes.*', 'promotions.*', 'mobilites.*') ? 'active' : '' }}">
                    <i class="nav-icon fas fa-history" style="color: #6f42c1;"></i>
                    <p>
                        Carrière & Mobilité
                        <i class="right fas fa-angle-left"></i>
                    </p>
                </a>
                <ul class="nav nav-treeview">
                    <li class="nav-item">
                        <a href="{{ route('historique-postes.index') }}" class="nav-link {{ request()->routeIs('historique-postes.index') ? 'active' : '' }}">
                            <i class="far fa-circle nav-icon"></i>
                            <p>Historique des Postes</p>
                        </a>
                    </li>
                    <li class="nav-item">
                        <a href="{{ route('promotions.index') }}" class="nav-link {{ request()->routeIs('promotions.*') ? 'active' : '' }}">
                            <i class="far fa-circle nav-icon"></i>
                            <p>Promotions</p>
                        </a>
                    </li>
                    <li class="nav-item">
                        <a href="{{ route('mobilites.index') }}" class="nav-link {{ request()->routeIs('mobilites.*') ? 'active' : '' }}">
                            <i class="far fa-circle nav-icon"></i>
                            <p>Mobilités</p>
                        </a>
                    </li>
                </ul>
            </li>

            <!-- D. Gestion des Documents RH -->
            <li class="nav-item {{ request()->routeIs('documents-rh.*') ? 'menu-open' : '' }}">
                <a href="#" class="nav-link {{ request()->routeIs('documents-rh.*') ? 'active' : '' }}">
                    <i class="nav-icon fas fa-file-pdf" style="color: #dc3545;"></i>
                    <p>
                        Documents RH
                        <i class="right fas fa-angle-left"></i>
                    </p>
                </a>
                <ul class="nav nav-treeview">
                    <li class="nav-item">
                        <a href="{{ route('documents-rh.index') }}" class="nav-link {{ request()->routeIs('documents-rh.index') ? 'active' : '' }}">
                            <i class="far fa-circle nav-icon"></i>
                            <p>Tous les documents</p>
                        </a>
                    </li>
                    <li class="nav-item">
                        <a href="{{ route('documents-rh.create') }}" class="nav-link {{ request()->routeIs('documents-rh.create') ? 'active' : '' }}">
                            <i class="far fa-circle nav-icon"></i>
                            <p>Ajouter un document</p>
                        </a>
                    </li>
                </ul>
            </li>
        </ul>
    </li>

    <!-- GESTION DES CONGÉS ET ABSENCES - Menu Principal Déroulant -->
    <li class="nav-item {{ request()->routeIs('demandes-conges.*', 'soldes-conges.*', 'historique-conges.*') ? 'menu-open' : '' }}">
        <a href="#" class="nav-link {{ request()->routeIs('demandes-conges.*', 'soldes-conges.*', 'historique-conges.*') ? 'active' : '' }}" style="background-color: #e8f5e9; border-left: 4px solid #28a745;">
            <i class="nav-icon fas fa-calendar-check" style="color: #28a745; font-weight: bold;"></i>
            <p style="font-weight: bold; color: #1b5e20;">
                🗓️ GESTION DES CONGÉS
                <i class="right fas fa-angle-left"></i>
            </p>
        </a>
        <ul class="nav nav-treeview">
            <!-- A. Demandes de Congés -->
            <li class="nav-item {{ request()->routeIs('demandes-conges.*') ? 'menu-open' : '' }}">
                <a href="#" class="nav-link {{ request()->routeIs('demandes-conges.*') ? 'active' : '' }}">
                    <i class="nav-icon fas fa-file-alt" style="color: #17a2b8;"></i>
                    <p>
                        Demandes de Congés
                        <i class="right fas fa-angle-left"></i>
                    </p>
                </a>
                <ul class="nav nav-treeview">
                    <li class="nav-item">
                        <a href="{{ route('demandes-conges.index') }}" class="nav-link {{ request()->routeIs('demandes-conges.index') ? 'active' : '' }}">
                            <i class="far fa-circle nav-icon"></i>
                            <p>Liste des demandes</p>
                        </a>
                    </li>
                    <li class="nav-item">
                        <a href="{{ route('demandes-conges.create') }}" class="nav-link {{ request()->routeIs('demandes-conges.create') ? 'active' : '' }}">
                            <i class="far fa-circle nav-icon"></i>
                            <p>Créer une demande</p>
                        </a>
                    </li>
                </ul>
            </li>

            <!-- B. Suivi des Soldes -->
            <li class="nav-item {{ request()->routeIs('soldes-conges.*') ? 'menu-open' : '' }}">
                <a href="#" class="nav-link {{ request()->routeIs('soldes-conges.*') ? 'active' : '' }}">
                    <i class="nav-icon fas fa-chart-bar" style="color: #ffc107;"></i>
                    <p>
                        Suivi des Soldes
                        <i class="right fas fa-angle-left"></i>
                    </p>
                </a>
                <ul class="nav nav-treeview">
                    <li class="nav-item">
                        <a href="{{ route('soldes-conges.index') }}" class="nav-link {{ request()->routeIs('soldes-conges.index') ? 'active' : '' }}">
                            <i class="far fa-circle nav-icon"></i>
                            <p>Tous les soldes</p>
                        </a>
                    </li>
                </ul>
            </li>

            <!-- C. Historique des Congés -->
            <li class="nav-item {{ request()->routeIs('historique-conges.*') ? 'menu-open' : '' }}">
                <a href="#" class="nav-link {{ request()->routeIs('historique-conges.*') ? 'active' : '' }}">
                    <i class="nav-icon fas fa-history" style="color: #6f42c1;"></i>
                    <p>
                        Historique
                        <i class="right fas fa-angle-left"></i>
                    </p>
                </a>
                <ul class="nav nav-treeview">
                    <li class="nav-item">
                        <a href="{{ route('historique-conges.index') }}" class="nav-link {{ request()->routeIs('historique-conges.index') ? 'active' : '' }}">
                            <i class="far fa-circle nav-icon"></i>
                            <p>Tous les historiques</p>
                        </a>
                    </li>
                </ul>
            </li>
        </ul>
    </li>

    <!-- Employés -->
    <li class="nav-item">
        <a href="{{ route('employes.index') }}" class="nav-link {{ request()->routeIs('employes.*') ? 'active' : '' }}">
            <i class="nav-icon fas fa-user-tie"></i>
            <p>Employés</p>
        </a>
    </li>

    <!-- Notifications -->
    <li class="nav-item">
        <a href="{{ route('notifications.index') }}" class="nav-link {{ request()->routeIs('notifications.*') ? 'active' : '' }}">
            <i class="nav-icon fas fa-bell"></i>
            <p>Notifications</p>
        </a>
    </li>

    <li class="nav-header">OUTILS</li>

    <!-- Export CV -->
    <li class="nav-item">
        <a href="{{ route('export.cv') }}" class="nav-link {{ request()->routeIs('export.cv*') ? 'active' : '' }}">
            <i class="nav-icon fas fa-file-excel text-success"></i>
            <p>Exporter les CV</p>
        </a>
    </li>

    <li class="nav-header">PARAMÈTRES</li>

    <!-- Profil -->
    <li class="nav-item">
        <a href="#" class="nav-link">
            <i class="nav-icon fas fa-user-cog"></i>
            <p>Mon Profil</p>
        </a>
    </li>

    <!-- Déconnexion -->
    <li class="nav-item">
        <a href="{{ route('rh.logout') }}" class="nav-link">
            <i class="nav-icon fas fa-sign-out-alt"></i>
            <p>Déconnexion</p>
        </a>
    </li>
</ul>
