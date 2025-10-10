@extends('layouts.app')
@section('title','Renouveler le contrat')
@section('page-title','Renouvellement de contrat')

@section('content')
@include('layouts.alerts')

<div class="card p-4 shadow-sm">
    <h5>Contrat de {{ $contrat->candidature->candidat->nom }} {{ $contrat->candidature->candidat->prenom }}</h5>
    <p><strong>Poste :</strong> {{ $contrat->candidature->annonce->titre }}</p>
    <p><strong>Type :</strong> {{ strtoupper($contrat->type_contrat) }}</p>
    <p><strong>Début :</strong> {{ $contrat->date_debut }}</p>
    <p><strong>Fin actuelle :</strong> {{ $contrat->date_fin ?? '-' }}</p>
    <p><strong>Renouvellements effectués :</strong> {{ $contrat->renouvellement }}</p>

    <form method="POST" action="{{ route('contrats.edit', $contrat->id) }}">
        @csrf
        <div class="mb-3">
            <label>Salaire (Ar)</label>
            <input type="number" step="0.01" name="salaire" class="form-control" value="{{ $contrat->salaire }}" required>
        </div>

        {{-- Pour CDI, laissez vide. Pour ESSAI/CDD, vous pouvez fixer une fin. --}}
        <div class="mb-3">
            <label>Nouvelle date de fin (optionnel pour CDI)</label>
            <input type="date" name="date_fin" class="form-control" value="{{ $contrat->date_fin }}">
        </div>

        <button type="submit" class="btn btn-success">Renouveler</button>
        <a href="{{ route('contrats.index') }}" class="btn btn-secondary">Annuler</a>
    </form>
</div>
@endsection
