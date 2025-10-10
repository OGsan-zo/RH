@php
    $role = session('user_role'); // récupère le rôle courant (admin, rh, candidat)
@endphp

<div class="bg-dark text-white p-3" style="width: 250px; min-height:100vh;">
    <h4 class="text-center mb-4">
        @if($role === 'admin')
            Espace Administrateur
        @elseif($role === 'rh')
            Espace RH
        @else
            Espace Candidat
        @endif
    </h4>

    <ul class="nav flex-column">

        {{-- 🧭 Liens visibles par ADMIN uniquement --}}
        @if($role === 'admin')
            <li class="nav-item mb-2">
                <a href="{{ route('admin.dashboard') }}" class="nav-link text-white">Dashboard</a>
            </li>
            <li class="nav-item mb-2">
                <a href="{{ route('departements.index') }}" class="nav-link text-white">Départements</a>
            </li>
            <li class="nav-item mb-2">
                <a href="{{ route('annonces.index') }}" class="nav-link text-white">Annonces</a>
            </li>
            {{-- <li class="nav-item mb-2">
                <a href="{{ route('admin.users') ?? '#' }}" class="nav-link text-white">Utilisateurs</a>
            </li> --}}
        @endif

        {{-- 🧭 Liens visibles par RH uniquement --}}
        @if($role === 'rh')
            <li class="nav-item mb-2">
                <a href="{{ route('rh.dashboard') }}" class="nav-link text-white">Dashboard</a>
            </li>
            <li class="nav-item mb-2">
                <a href="{{ route('departements.index') }}" class="nav-link text-white">Départements</a>
            </li>
            <li class="nav-item mb-2">
                <a href="{{ route('annonces.index') }}" class="nav-link text-white">Annonces</a>
            </li>
            <li class="nav-item mb-2">
                <a href="#" class="nav-link text-white">Entretiens</a>
            </li>
            <li class="nav-item mb-2">
                <a href="#" class="nav-link text-white">Candidatures</a>
            </li>
        @endif

        {{-- 🧭 Liens visibles par CANDIDAT uniquement --}}
        @if($role === 'candidat')
            <li class="nav-item mb-2">
                <a href="{{ route('candidat.dashboard') }}" class="nav-link text-white">Dashboard</a>
            </li>
            <li class="nav-item mb-2">
                <a href="#" class="nav-link text-white">Annonces ouvertes</a>
            </li>
            <li class="nav-item mb-2">
                <a href="#" class="nav-link text-white">Mes candidatures</a>
            </li>
            <li class="nav-item mb-2">
                <a href="{{ route('rh.password.form') }}" class="nav-link text-white">Modifier mot de passe</a>
            </li>
        @endif

        <hr class="text-white">

        {{-- 🔒 Déconnexion (visible pour tous les rôles connectés) --}}
        <li class="nav-item mb-2">
            <a href="{{ route('rh.logout') }}" class="nav-link text-danger">Déconnexion</a>
        </li>
    </ul>
</div>
