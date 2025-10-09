<div class="bg-dark text-white p-3" style="width: 250px; min-height:100vh;">
    <h4 class="text-center mb-4">Espace RH</h4>
    <ul class="nav flex-column">
        <li class="nav-item mb-2">
            <a href="{{ route('departements.index') }}" class="nav-link text-white">Départements</a>
        </li>
        <li class="nav-item mb-2">
            <a href="{{ route('rh.dashboard') }}" class="nav-link text-white">Dashboard</a>
        </li>
        <li class="nav-item mb-2">
            <a href="{{ route('rh.logout') }}" class="nav-link text-danger">Déconnexion</a>
        </li>
    </ul>
</div>
