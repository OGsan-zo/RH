@extends('layouts.app')
@section('title','Planifier un entretien')
@section('page-title','Planification entretien')

@section('content')
@include('layouts.alerts')

<form method="POST" action="{{ route('entretiens.create') }}" class="card p-4 shadow-sm">
    @csrf
    <div class="mb-3">
        <label for="candidature_id">Candidat :</label>
        <select name="candidature_id" class="form-select" required>
            <option value="">-- Sélectionner --</option>
            @foreach($candidatures as $c)
                <option value="{{ $c->id }}">
                    {{ $c->candidat->nom }} {{ $c->candidat->prenom }} — {{ $c->annonce->titre }}
                </option>
            @endforeach
        </select>
    </div>
    <div class="mb-3">
        <label>Date & heure :</label>
        <input type="datetime-local" name="date_entretien" class="form-control" required>
    </div>
    <div class="mb-3">
        <label>Durée (minutes) :</label>
        <input type="number" name="duree" class="form-control" value="60" min="15" required>
    </div>
    <div class="mb-3">
        <label>Lieu :</label>
        <input type="text" name="lieu" class="form-control" required>
    </div>
    <button type="submit" class="btn btn-success">Enregistrer</button>
    <a href="{{ route('entretiens.index') }}" class="btn btn-secondary">Annuler</a>
</form>
@endsection
