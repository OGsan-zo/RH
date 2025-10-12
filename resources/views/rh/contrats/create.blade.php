@extends('layouts.app')
@section('title','Créer un contrat')
@section('page-title','Création de contrat')

@section('content')
@include('layouts.alerts')

<form method="POST" action="{{ route('contrats.create') }}" class="card p-4 shadow-sm">
@csrf
@if(request('candidature_id'))
<input type="hidden" name="candidature_id" value="{{ request('candidature_id') }}">
@else
<div class="mb-3">
    <label>Candidat :</label>
    <select name="candidature_id" class="form-select" required>
        @foreach($candidats as $c)
            <option value="{{ $c->id }}">{{ $c->candidat->nom }} {{ $c->candidat->prenom }} — {{ $c->annonce->titre }}</option>
        @endforeach
    </select>
</div>
@endif
<div class="mb-3">
    <label>Type de contrat :</label>
    <select name="type_contrat" class="form-select" required>
        <option value="essai">Essai</option>
        <option value="CDD">CDD</option>
        <option value="CDI">CDI</option>
    </select>
</div>
<div class="mb-3">
    <label>Salaire (en Ar) :</label>
    <input type="number" step="0.01" name="salaire" class="form-control" required>
</div>
<div class="mb-3">
    <label>Date début :</label>
    <input type="date" name="date_debut" class="form-control" required>
</div>
<div class="mb-3">
    <label>Date fin :</label>
    <input type="date" name="date_fin" class="form-control">
</div>
<div class="mb-3">
    <select name="statut" class="form-select">
        @foreach(\App\Models\Contrat::STATUTS as $statut)
            <option value="{{ $statut }}">{{ ucfirst(str_replace('_',' ', $statut)) }}</option>
        @endforeach
    </select>
</div>

<button type="submit" class="btn btn-success">Créer</button>
<a href="{{ route('contrats.index') }}" class="btn btn-secondary">Annuler</a>
</form>
@endsection
