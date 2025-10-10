@extends('layouts.app')

@section('title', 'Créer une annonce')
@section('page-title', 'Créer une annonce')

@section('content')
<form method="POST" action="{{ route('annonces.store') }}" class="card p-4 shadow-sm">
    @csrf

    <div class="mb-3">
        <label>Département</label>
        <select name="departement_id" class="form-select" required>
            <option value="">-- Choisir --</option>
            @foreach($departements as $d)
                <option value="{{ $d->id }}">{{ $d->nom }}</option>
            @endforeach
        </select>
    </div>

    <div class="mb-3">
        <label>Titre du poste</label>
        <input type="text" name="titre" class="form-control" required maxlength="150">
    </div>

    <div class="mb-3">
        <label>Description</label>
        <textarea name="description" class="form-control" required></textarea>
    </div>

    <div class="mb-3">
        <label>Compétences requises</label>
        <textarea name="competences_requises" class="form-control"></textarea>
    </div>

    <div class="mb-3">
        <label>Niveau requis</label>
        <input type="text" name="niveau_requis" class="form-control">
    </div>

    <div class="mb-3">
        <label>Date limite</label>
        <input type="date" name="date_limite" class="form-control">
    </div>

    <button class="btn btn-success">Enregistrer</button>
    <a href="{{ route('annonces.index') }}" class="btn btn-secondary">Annuler</a>
</form>
@endsection
