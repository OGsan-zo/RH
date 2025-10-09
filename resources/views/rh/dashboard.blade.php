@extends('layouts.app')

@section('title', 'Tableau de bord - RH')
@section('page-title', 'Espace Ressources Humaines')

@section('content')
<div class="card shadow-sm p-4">
    <h5>Bienvenue, Responsable RH</h5>
    <p class="text-muted">
        Gérez les départements, les candidatures et les entretiens depuis cet espace.
    </p>

    <div class="mt-4">
        <a href="{{ route('departements.index') }}" class="btn btn-primary">Voir les départements</a>
        <a href="#" class="btn btn-outline-secondary">Voir les candidatures</a>
        <a href="#" class="btn btn-outline-secondary">Planifier un entretien</a>
    </div>
</div>
@endsection
