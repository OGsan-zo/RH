<aside class="main-sidebar sidebar-dark-primary elevation-4">
    <!-- Brand Logo -->
    <a href="{{ route('candidat.dashboard') }}" class="brand-link">
        <img src="https://adminlte.io/themes/v3/dist/img/AdminLTELogo.png" alt="RH Logo" class="brand-image img-circle elevation-3" style="opacity: .8">
        <span class="brand-text font-weight-light"><b>RH</b>System</span>
    </a>

    <!-- Sidebar -->
    <div class="sidebar">
        <!-- Sidebar user panel -->
        <div class="user-panel mt-3 pb-3 mb-3 d-flex">
            <div class="image">
                <img src="https://adminlte.io/themes/v3/dist/img/user2-160x160.jpg" class="img-circle elevation-2" alt="User Image">
            </div>
            <div class="info">
                <a href="#" class="d-block">{{ \App\Models\User::find(session('user_id'))->name ?? 'Candidat' }}</a>
            </div>
        </div>

        <!-- Sidebar Menu -->
        <nav class="mt-2">
            <ul class="nav nav-pills nav-sidebar flex-column" data-widget="treeview" role="menu" data-accordion="false">
                
                <!-- Dashboard -->
                <li class="nav-item">
                    <a href="{{ route('candidat.dashboard') }}" class="nav-link {{ request()->routeIs('candidat.dashboard') ? 'active' : '' }}">
                        <i class="nav-icon fas fa-tachometer-alt"></i>
                        <p>Tableau de Bord</p>
                    </a>
                </li>

                <!-- Annonces -->
                <li class="nav-item">
                    <a href="{{ route('candidatures.index') }}" class="nav-link {{ request()->routeIs('candidatures.index') || request()->routeIs('candidatures.show') ? 'active' : '' }}">
                        <i class="nav-icon fas fa-briefcase"></i>
                        <p>Annonces Disponibles</p>
                    </a>
                </li>

                <!-- Suivi Candidatures -->
                <li class="nav-item">
                    <a href="{{ route('candidatures.suivi') }}" class="nav-link {{ request()->routeIs('candidatures.suivi') ? 'active' : '' }}">
                        <i class="nav-icon fas fa-tasks"></i>
                        <p>Mes Candidatures</p>
                    </a>
                </li>

                <!-- Tests QCM -->
                <li class="nav-item">
                    <a href="{{ route('tests.select') }}" class="nav-link {{ request()->routeIs('tests.select') || request()->routeIs('tests.passer') ? 'active' : '' }}">
                        <i class="nav-icon fas fa-clipboard-check"></i>
                        <p>Passer un Test</p>
                    </a>
                </li>

                <!-- Entretiens -->
                <li class="nav-item">
                    <a href="{{ route('entretiens.notifications') }}" class="nav-link {{ request()->routeIs('entretiens.notifications') ? 'active' : '' }}">
                        <i class="nav-icon fas fa-calendar-alt"></i>
                        <p>Mes Entretiens</p>
                    </a>
                </li>

                <!-- Mon Contrat -->
                <li class="nav-item">
                    <a href="{{ route('contrat.details') }}" class="nav-link {{ request()->routeIs('contrat.details') ? 'active' : '' }}">
                        <i class="nav-icon fas fa-file-contract"></i>
                        <p>Mon Contrat</p>
                    </a>
                </li>

                <!-- Notifications -->
                <li class="nav-item">
                    <a href="{{ route('notifications.index') }}" class="nav-link {{ request()->routeIs('notifications.index') ? 'active' : '' }}">
                        <i class="nav-icon fas fa-bell"></i>
                        <p>Mes Notifications</p>
                    </a>
                </li>

                <!-- Divider -->
                <li class="nav-header">PARAMÈTRES</li>

                <!-- Changer mot de passe -->
                <li class="nav-item">
                    <a href="{{ route('rh.password.form') }}" class="nav-link">
                        <i class="nav-icon fas fa-key"></i>
                        <p>Changer Mot de Passe</p>
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
        </nav>
        <!-- /.sidebar-menu -->
    </div>
    <!-- /.sidebar -->
</aside>
