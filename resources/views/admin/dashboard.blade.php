@extends('layouts.app')

@section('title', 'Tableau de bord - Admin')
@section('page-title', 'Tableau de bord Administrateur')

@section('content')
<div class="card shadow-sm p-4">
    <h5>Bienvenue, Administrateur</h5>
    <p class="text-muted">
        Vous avez le contrôle total du système RH : gestion des utilisateurs, des rôles et supervision des départements.
    </p>

    <div class="row mt-4">
        <div class="col-md-4">
            <div class="card p-3 text-center">
                <h6>Utilisateurs enregistrés</h6>
                <p class="display-6">{{ \App\Models\User::count() }}</p>
            </div>
        </div>
        <div class="col-md-4">
            <div class="card p-3 text-center">
                <h6>Départements</h6>
                <p class="display-6">{{ \App\Models\Departement::count() }}</p>
            </div>
        </div>
        <div class="col-md-4">
            <div class="card p-3 text-center">
                <h6>Rôles disponibles</h6>
                <p class="display-6">3</p>
            </div>
        </div>
    </div>
</div>
@endsection
