@extends('layouts.app')
@section('title','Entretiens')
@section('page-title','Gestion des entretiens')

@section('content')
@include('layouts.alerts')

<div class="card p-3 shadow-sm mb-3">
    <h5>Candidats éligibles (note ≥ {{ $seuil }})</h5>
    <form action="{{ route('entretiens.create') }}" method="get">
        <select name="candidature_id" class="form-select" required>
            <option value="">-- Sélectionner un candidat --</option>
            @foreach($candidatsEligibles as $c)
                <option value="{{ $c->id }}">
                    {{ $c->candidat->nom }} {{ $c->candidat->prenom }} — {{ $c->annonce->titre }}
                </option>
            @endforeach
        </select>
        <button type="submit" class="btn btn-success mt-2">Planifier un entretien</button>
    </form>
</div>

<h5>Entretiens planifiés</h5>
<table class="table table-striped">
    <thead>
        <tr>
            <th>Candidat</th>
            <th>Poste</th>
            <th>Date</th>
            <th>Durée</th>
            <th>Lieu</th>
            <th>Statut</th>
            <th></th>
        </tr>
    </thead>
    <tbody>
        @foreach($entretiens as $e)
        <tr>
            <td>{{ $e->candidature->candidat->nom }} {{ $e->candidature->candidat->prenom }}</td>
            <td>{{ $e->candidature->annonce->titre }}</td>
            <td>{{ $e->date_entretien }}</td>
            <td>{{ $e->duree }} min</td>
            <td>{{ $e->lieu }}</td>
            <td>{{ $e->statut }}</td>
            <td>
                <a href="{{ route('entretiens.delete',$e->id) }}" class="btn btn-danger btn-sm"
                    onclick="return confirm('Supprimer cet entretien ?')">Supprimer</a>
            </td>
        </tr>
        @endforeach
    </tbody>
</table>
@endsection
