@extends('layouts.app')
@section('title','Évaluation entretiens')
@section('page-title','Entretiens confirmés à évaluer')

@section('content')
@include('layouts.alerts')

@if($entretiensConfirmes->isEmpty())
    <div class="alert alert-info">Aucun entretien confirmé à évaluer.</div>
@else
<table class="table table-striped">
    <thead>
        <tr>
            <th>Candidat</th>
            <th>Poste</th>
            <th>Date</th>
            <th>Lieu</th>
            <th>Action</th>
        </tr>
    </thead>
    <tbody>
        @foreach($entretiensConfirmes as $e)
        <tr>
            <td>{{ $e->candidature->candidat->nom }} {{ $e->candidature->candidat->prenom }}</td>
            <td>{{ $e->candidature->annonce->titre }}</td>
            <td>{{ $e->date_entretien }}</td>
            <td>{{ $e->lieu }}</td>
            <td>
                <a href="{{ route('evaluations.create', $e->id) }}" class="btn btn-primary btn-sm">Évaluer</a>
            </td>
        </tr>
        @endforeach
    </tbody>
</table>
@endif
@endsection
