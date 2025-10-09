@extends('layouts.app')

@section('title', 'Créer un département')
@section('page-title', 'Créer un département')

@section('content')
<form method="POST" action="{{ route('departements.store') }}" class="card p-4 shadow-sm">
    @csrf
    <div class="mb-3">
        <label>Nom du département</label>
        <input type="text" name="nom" class="form-control" required maxlength="150">
    </div>

    <button class="btn btn-success">Enregistrer</button>
    <a href="{{ route('departements.index') }}" class="btn btn-secondary">Annuler</a>
</form>
@endsection
