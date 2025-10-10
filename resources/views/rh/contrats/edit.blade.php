@extends('layouts.app')
@section('title','Modifier / Renouveler le contrat')
@section('page-title','Renouvellement ou changement de type de contrat')

@section('content')
@include('layouts.alerts')

<div class="card p-4 shadow-sm">
    <h5>Contrat de {{ $contrat->candidature->candidat->nom }} {{ $contrat->candidature->candidat->prenom }}</h5>
    <p><strong>Poste :</strong> {{ $contrat->candidature->annonce->titre }}</p>
    <p><strong>Type actuel :</strong> {{ strtoupper($contrat->type_contrat) }}</p>
    <p><strong>Renouvellements effectués :</strong> {{ $contrat->renouvellement }}</p>

    <form method="POST" action="{{ route('contrats.edit', $contrat->id) }}">
        @csrf

        <div class="mb-3">
            <label>Type de contrat :</label>
            <select name="type_contrat" class="form-select" required>
                <option value="essai" @if($contrat->type_contrat === 'essai') selected @endif>Essai</option>
                <option value="CDD" @if($contrat->type_contrat === 'CDD') selected @endif>CDD</option>
                <option value="CDI" @if($contrat->type_contrat === 'CDI') selected @endif>CDI</option>
            </select>
        </div>

        <div class="mb-3">
            <label>Salaire (Ar)</label>
            <input type="number" step="0.01" name="salaire" class="form-control"
                   value="{{ $contrat->salaire }}" required>
        </div>

        <div class="mb-3">
            <label>Nouvelle date de fin (optionnel pour CDI)</label>
            <input type="date" name="date_fin" class="form-control"
                   value="{{ $contrat->date_fin }}">
        </div>

        <button type="submit" class="btn btn-success">Enregistrer les modifications</button>
        <a href="{{ route('contrats.index') }}" class="btn btn-secondary">Annuler</a>
    </form>
</div>
@endsection
