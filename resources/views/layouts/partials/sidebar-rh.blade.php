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

    <!-- Notifications -->
    <li class="nav-item">
        <a href="{{ route('notifications.index') }}" class="nav-link {{ request()->routeIs('notifications.*') ? 'active' : '' }}">
            <i class="nav-icon fas fa-bell"></i>
            <p>Notifications</p>
        </a>
    </li>

    <!-- Employés -->
    <li class="nav-item">
        <a href="{{ route('employes.index') }}" class="nav-link {{ request()->routeIs('employes.*') ? 'active' : '' }}">
            <i class="nav-icon fas fa-user-tie"></i>
            <p>Employés</p>
        </a>
    </li>

    <li class="nav-header">EXPORTS & RAPPORTS</li>

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
