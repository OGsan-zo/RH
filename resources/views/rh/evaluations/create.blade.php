@extends('layouts.app')
@section('title','Évaluer entretien')
@section('page-title','Évaluation entretien')

@section('content')
@include('layouts.alerts')

<div class="card p-4 shadow-sm">
    <h5>{{ $entretien->candidature->candidat->nom }} {{ $entretien->candidature->candidat->prenom }}</h5>
    <p><strong>Poste :</strong> {{ $entretien->candidature->annonce->titre }}</p>
    <p><strong>Date entretien :</strong> {{ $entretien->date_entretien }}</p>

    <form method="POST" action="{{ route('evaluations.store', $entretien->id) }}">
        @csrf
        <div class="mb-3">
            <label>Note (sur 20) :</label>
            <input type="number" step="0.01" name="note" class="form-control" required min="0" max="20">
        </div>
        <div class="mb-3">
            <label>Remarques :</label>
            <textarea name="remarques" class="form-control" rows="3"></textarea>
        </div>
        <button type="submit" class="btn btn-success">Enregistrer</button>
        <a href="{{ route('evaluations.index') }}" class="btn btn-secondary">Annuler</a>
    </form>
</div>
@endsection
