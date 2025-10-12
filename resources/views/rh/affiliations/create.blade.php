@extends('layouts.app')
@section('title','Nouvelle affiliation sociale')
@section('page-title','Créer une affiliation')

@section('content')
@include('layouts.alerts')

<form method="POST" action="{{ route('affiliations.create') }}" class="card p-4 shadow-sm">
    @csrf
    <div class="mb-3">
        <label>Contrat actif :</label>
        <select name="contrat_id" class="form-select" required>
            <option value="">-- Sélectionner un contrat --</option>
            @foreach($contratsActifs as $c)
                <option value="{{ $c->id }}">
                    {{ $c->candidature->candidat->nom }} {{ $c->candidature->candidat->prenom }}
                    — {{ $c->candidature->annonce->titre }} ({{ $c->type_contrat }})
                </option>
            @endforeach
        </select>
    </div>

    <div class="mb-3">
        <label>Organisme :</label>
        <select name="organisme" class="form-select" required>
            <option value="CNAPS">CNAPS</option>
            <option value="OSTIE">OSTIE</option>
            <option value="AMIT">AMIT</option>
        </select>
    </div>

    <div class="mb-3">
        <label>Numéro d’affiliation :</label>
        <input type="text" name="numero_affiliation" class="form-control" required>
    </div>

    <div class="mb-3">
        <label>Taux de cotisation (%) :</label>
        <input type="number" name="taux_cotisation" class="form-control" step="0.01" value="1.00">
    </div>

    <button type="submit" class="btn btn-success">Enregistrer</button>
    <a href="{{ route('affiliations.index') }}" class="btn btn-secondary">Annuler</a>
</form>
@endsection
