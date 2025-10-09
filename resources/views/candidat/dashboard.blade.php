@extends('layouts.app')

@section('title', 'Tableau de bord - Candidat')
@section('page-title', 'Espace Candidat')

@section('content')
<div class="card shadow-sm p-4">
    <h5>Bienvenue, {{ \App\Models\User::find(session('user_id'))->name ?? 'Candidat' }}</h5>
    <p class="text-muted">
        Vous pouvez consulter les offres d’emploi, passer les tests et suivre l’état de votre candidature.
    </p>

    <div class="mt-4">
        <a href="#" class="btn btn-primary">Voir les annonces disponibles</a>
        <a href="#" class="btn btn-outline-secondary">Voir mes candidatures</a>
        <a href="{{ route('rh.password.form') }}" class="btn btn-outline-secondary">Changer mon mot de passe</a>
    </div>
</div>
@endsection
