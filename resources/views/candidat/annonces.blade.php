@extends('layouts.app')
@section('title','Annonces disponibles')
@section('page-title','Liste des annonces ouvertes')

@section('content')

@include('layouts.alerts')

<table class="table table-striped">
    <thead>
        <tr>
            <th>Titre</th>
            <th>Département</th>
            <th>Date limite</th>
            <th></th>
        </tr>
    </thead>
    <tbody>
    @foreach($annonces as $a)
        <tr>
            <td>{{ $a->titre }}</td>
            <td>{{ $a->departement->nom ?? '-' }}</td>
            <td>{{ $a->date_limite }}</td>
            <td><a href="{{ route('candidatures.show',$a->id) }}" class="btn btn-primary btn-sm">Détails</a></td>
        </tr>
    @endforeach
    </tbody>
</table>
@endsection
