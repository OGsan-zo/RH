<ul class="nav nav-pills nav-sidebar flex-column" data-widget="treeview" role="menu" data-accordion="false">
    <!-- Dashboard -->
    <li class="nav-item">
        <a href="{{ route('rh.dashboard') }}" class="nav-link {{ request()->routeIs('rh.dashboard') ? 'active' : '' }}">
            <i class="nav-icon fas fa-tachometer-alt"></i>
            <p>Tableau de Bord</p>
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

    <!-- Candidatures -->
    <li class="nav-item {{ request()->routeIs('tri.*') ? 'menu-open' : '' }}">
        <a href="#" class="nav-link {{ request()->routeIs('tri.*') ? 'active' : '' }}">
            <i class="nav-icon fas fa-users"></i>
            <p>
                Candidatures
                <i class="right fas fa-angle-left"></i>
            </p>
        </a>
        <ul class="nav nav-treeview">
            <li class="nav-item">
                <a href="{{ route('tri.index') }}" class="nav-link {{ request()->routeIs('tri.*') ? 'active' : '' }}">
                    <i class="far fa-circle nav-icon"></i>
                    <p>Tri des candidats</p>
                </a>
            </li>
        </ul>
    </li>

    <!-- Tests -->
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
                <a href="{{ route('tests.view') }}" class="nav-link {{ request()->routeIs('tests.view') ? 'active' : '' }}">
                    <i class="far fa-circle nav-icon"></i>
                    <p>Liste des tests</p>
                </a>
            </li>
            <li class="nav-item">
                <a href="{{ route('tests.create') }}" class="nav-link {{ request()->routeIs('tests.create') ? 'active' : '' }}">
                    <i class="far fa-circle nav-icon"></i>
                    <p>Créer un test</p>
                </a>
            </li>
            <li class="nav-item">
                <a href="{{ route('resultats.select') }}" class="nav-link {{ request()->routeIs('resultats.*') ? 'active' : '' }}">
                    <i class="far fa-circle nav-icon"></i>
                    <p>Résultats</p>
                </a>
            </li>
        </ul>
    </li>

    <!-- Entretiens -->
    <li class="nav-item {{ request()->routeIs('entretiens.*') ? 'menu-open' : '' }}">
        <a href="#" class="nav-link {{ request()->routeIs('entretiens.*') ? 'active' : '' }}">
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
                    <p>Mes entretiens</p>
                </a>
            </li>
            <li class="nav-item">
                <a href="{{ route('entretiens.create') }}" class="nav-link {{ request()->routeIs('entretiens.create') ? 'active' : '' }}">
                    <i class="far fa-circle nav-icon"></i>
                    <p>Planifier</p>
                </a>
            </li>
        </ul>
    </li>

    <!-- Décisions -->
    <li class="nav-item">
        <a href="{{ route('resultats.select') }}" class="nav-link {{ request()->routeIs('decisions.*') ? 'active' : '' }}">
            <i class="nav-icon fas fa-gavel"></i>
            <p>Décisions</p>
        </a>
    </li>

    <!-- Employés -->
    <li class="nav-item {{ request()->routeIs('employes.*') || request()->routeIs('contrats.*') || request()->routeIs('affiliations.*') ? 'menu-open' : '' }}">
        <a href="#" class="nav-link {{ request()->routeIs('employes.*') || request()->routeIs('contrats.*') || request()->routeIs('affiliations.*') ? 'active' : '' }}">
            <i class="nav-icon fas fa-user-tie"></i>
            <p>
                Employés
                <i class="right fas fa-angle-left"></i>
            </p>
        </a>
        <ul class="nav nav-treeview">
            <li class="nav-item">
                <a href="{{ route('employes.index') }}" class="nav-link {{ request()->routeIs('employes.*') ? 'active' : '' }}">
                    <i class="far fa-circle nav-icon"></i>
                    <p>Liste des employés</p>
                </a>
            </li>
            <li class="nav-item">
                <a href="{{ route('contrats.index') }}" class="nav-link {{ request()->routeIs('contrats.*') ? 'active' : '' }}">
                    <i class="far fa-circle nav-icon"></i>
                    <p>Contrats</p>
                </a>
            </li>
            <li class="nav-item">
                <a href="{{ route('affiliations.index') }}" class="nav-link {{ request()->routeIs('affiliations.*') ? 'active' : '' }}">
                    <i class="far fa-circle nav-icon"></i>
                    <p>Affiliations</p>
                </a>
            </li>
        </ul>
    </li>

    <!-- Départements -->
    <li class="nav-item">
        <a href="{{ route('departements.index') }}" class="nav-link {{ request()->routeIs('departements.*') ? 'active' : '' }}">
            <i class="nav-icon fas fa-building"></i>
            <p>Départements</p>
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
