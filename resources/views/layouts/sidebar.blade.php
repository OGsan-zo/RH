@php
    $role = session('user_role'); // Rôle actuel : admin, rh, candidat
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

        {{-- ================= ADMIN ================= --}}
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
        @endif

        {{-- ================= RH ================= --}}
        @if($role === 'rh')
            <li class="nav-item mb-2">
                <a href="{{ route('rh.dashboard') }}" class="nav-link text-white">Dashboard RH</a>
            </li>
            <li class="nav-item mb-2">
                <a href="{{ route('departements.index') }}" class="nav-link text-white">Départements</a>
            </li>
            <li class="nav-item mb-2">
                <a href="{{ route('annonces.index') }}" class="nav-link text-white">Annonces</a>
            </li>
            <li class="nav-item mb-2">
                <a href="{{ route('tests.create') }}" class="nav-link text-white">Créer un test QCM</a>
            </li>
            <li class="nav-item mb-2">
                <a href="{{ route('tests.view') }}" class="nav-link text-white">Voir les tests QCM</a>
            </li>
            <li class="nav-item mb-2">
                <a href="{{ route('resultats.select') }}" class="nav-link text-white">Résultats QCM candidats</a>
            </li>
            <li class="nav-item mb-2">
                <a href="{{ route('entretiens.index') }}" class="nav-link text-white">Gestion des entretiens</a>
            </li>
            <li class="nav-item mb-2">
                <a href="{{ route('entretiens.calendrier') }}" class="nav-link text-white">Calendrier des entretiens</a>
            </li>
            <li class="nav-item mb-2">
                <a href="{{ route('evaluations.index') }}" class="nav-link text-white">Évaluer les entretiens</a>
            </li>
            <li class="nav-item mb-2">
                <a href="{{ route('evaluations.resultats') }}" class="nav-link text-white">Résultats globaux</a>
            </li>
            <li class="nav-item mb-2">
                <a href="{{ route('evaluations.resultats') }}" class="nav-link text-white">Décision de recrutement</a>
            </li>
            <li class="nav-item mb-2">
                <a href="{{ route('contrats.index') }}" class="nav-link text-white">Contrats</a>
            </li>
            <li class="nav-item mb-2">
                <a href="{{ route('contrats.status') }}" class="nav-link text-white">Statut des contrats</a>
            </li>
            <li class="nav-item mb-2">
                <a href="{{ route('affiliations.index') }}" class="nav-link text-white">Affiliations sociales</a>
            </li>
            <li class="nav-item mb-2">
                <a href="{{ route('notifications.index') }}" class="nav-link text-white">Notifications</a>
            </li>
            <li class="nav-item mb-2">
                <a href="{{ route('employes.index') }}" class="nav-link text-white">Employés</a>
            </li>


        @endif

        {{-- ================= CANDIDAT ================= --}}
        @if($role === 'candidat')
            <li class="nav-item mb-2">
                <a href="{{ route('candidat.dashboard') }}" class="nav-link text-white">Dashboard</a>
            </li>
            <li class="nav-item mb-2">
                <a href="{{ route('candidatures.index') }}" class="nav-link text-white">Annonces disponibles</a>
            </li>
            <li class="nav-item mb-2">
                <a href="{{ route('candidatures.suivi') }}" class="nav-link text-white">Suivi de candidature</a>
            </li>
            <li class="nav-item mb-2">
                <a href="{{ route('tests.select') }}" class="nav-link text-white">Passer un test</a>
            </li>
            <li class="nav-item mb-2">
                <a href="{{ route('entretiens.notifications') }}" class="nav-link text-white">Mes entretiens</a>
            </li>
            <li class="nav-item mb-2">
                <a href="{{ route('contrat.details') }}" class="nav-link text-white">Mon contrat</a>
            </li>
            <li class="nav-item mb-2">
                <a href="{{ route('notifications.index') }}" class="nav-link text-white">Mes notifications</a>
            </li>


        @endif

        <hr class="text-white">

        {{-- ================= DÉCONNEXION ================= --}}
        <li class="nav-item mb-2">
            <a href="{{ route('rh.logout') }}" class="nav-link text-danger">Déconnexion</a>
        </li>
    </ul>
</div>
