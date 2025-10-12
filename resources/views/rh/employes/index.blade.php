@extends('layouts.app')
@section('title','Employés')
@section('page-title','Liste des employés actifs')

@section('content')
@include('layouts.alerts')

@if($employes->isEmpty())
<div class="alert alert-info">Aucun employé enregistré.</div>
@else
<table class="table table-bordered align-middle">
    <thead class="table-dark">
        <tr>
            <th>Matricule</th>
            <th>Nom</th>
            <th>Poste</th>
            <th>Date embauche</th>
            <th>Statut</th>
        </tr>
    </thead>
    <tbody>
        @foreach($employes as $e)
        <tr>
            <td>{{ $e->matricule }}</td>
            <td>{{ $e->candidat->nom }} {{ $e->candidat->prenom }}</td>
            <td>{{ $e->contrat->candidature->annonce->titre }}</td>
            <td>{{ $e->date_embauche }}</td>
            <td><span class="badge bg-success">{{ ucfirst($e->statut) }}</span></td>
        </tr>
        @endforeach
    </tbody>
</table>
@endif
@endsection
