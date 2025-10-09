@extends('layouts.app')

@section('title', 'Modifier un département')
@section('page-title', 'Modifier le département')

@section('content')
<form method="POST" action="{{ route('departements.update', $departement->id) }}" class="card p-4 shadow-sm">
    @csrf
    <div class="mb-3">
        <label>Nom du département</label>
        <input type="text" name="nom" value="{{ $departement->nom }}" class="form-control" required maxlength="150">
    </div>

    <button class="btn btn-primary">Mettre à jour</button>
    <a href="{{ route('departements.index') }}" class="btn btn-secondary">Retour</a>
</form>
@endsection
