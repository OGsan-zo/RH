@extends('layouts.app')
@section('title','Affiliations sociales')
@section('page-title','Liste des affiliations sociales')

@section('content')
@include('layouts.alerts')

<a href="{{ route('affiliations.create') }}" class="btn btn-success mb-3">+ Nouvelle affiliation</a>

@if($affiliations->isEmpty())
    <div class="alert alert-info">Aucune affiliation enregistrée.</div>
@else
<table class="table table-bordered align-middle">
    <thead class="table-dark">
        <tr>
            <th>Candidat</th>
            <th>Poste</th>
            <th>Organisme</th>
            <th>Numéro</th>
            <th>Taux (%)</th>
            <th>Date</th>
        </tr>
    </thead>
    <tbody>
        @foreach($affiliations as $a)
        <tr>
            <td>{{ $a->contrat->candidature->candidat->nom }} {{ $a->contrat->candidature->candidat->prenom }}</td>
            <td>{{ $a->contrat->candidature->annonce->titre }}</td>
            <td>{{ $a->organisme }}</td>
            <td>{{ $a->numero_affiliation }}</td>
            <td>{{ $a->taux_cotisation }}</td>
            <td>{{ $a->date_affiliation }}</td>
        </tr>
        @endforeach
    </tbody>
</table>
@endif
@endsection
