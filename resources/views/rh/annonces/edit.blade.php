@extends('layouts.app')

@section('title', 'Modifier une annonce')
@section('page-title', 'Modifier une annonce')

@section('content')
<form method="POST" action="{{ route('annonces.update', $annonce->id) }}" class="card p-4 shadow-sm">
    @csrf

    <div class="mb-3">
        <label>Département</label>
        <select name="departement_id" class="form-select" required>
            @foreach($departements as $d)
                <option value="{{ $d->id }}" {{ $annonce->departement_id == $d->id ? 'selected' : '' }}>
                    {{ $d->nom }}
                </option>
            @endforeach
        </select>
    </div>

    <div class="mb-3">
        <label>Titre du poste</label>
        <input type="text" name="titre" value="{{ $annonce->titre }}" class="form-control" required>
    </div>

    <div class="mb-3">
        <label>Description</label>
        <textarea name="description" class="form-control" required>{{ $annonce->description }}</textarea>
    </div>

    <div class="mb-3">
        <label>Compétences requises</label>
        <textarea name="competences_requises" class="form-control">{{ $annonce->competences_requises }}</textarea>
    </div>

    <div class="mb-3">
        <label>Niveau requis</label>
        <input type="text" name="niveau_requis" value="{{ $annonce->niveau_requis }}" class="form-control">
    </div>

    <div class="mb-3">
        <label>Date limite</label>
        <input type="date" name="date_limite" value="{{ $annonce->date_limite }}" class="form-control">
    </div>

    <button class="btn btn-primary">Mettre à jour</button>
    <a href="{{ route('annonces.index') }}" class="btn btn-secondary">Retour</a>
</form>
@endsection
