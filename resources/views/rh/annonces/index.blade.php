@extends('layouts.app')

@section('title', 'Liste des annonces')
@section('page-title', 'Gestion des annonces')

@section('content')
<a href="{{ route('annonces.create') }}" class="btn btn-primary mb-3">+ Nouvelle annonce</a>

@if(session('success'))
    <div class="alert alert-success">{{ session('success') }}</div>
@endif

<table class="table table-bordered table-striped">
    <thead class="table-light">
        <tr>
            <th>ID</th>
            <th>Département</th>
            <th>Titre</th>
            <th>Date limite</th>
            <th>Statut</th>
            <th>Actions</th>
        </tr>
    </thead>
    <tbody>
        @foreach($annonces as $a)
        <tr>
            <td>{{ $a->id }}</td>
            <td>{{ $a->departement->nom ?? '-' }}</td>
            <td>{{ $a->titre }}</td>
            <td>{{ $a->date_limite ?? '—' }}</td>
            <td>
                @if($a->statut === 'ouverte')
                    <span class="badge bg-success">Ouverte</span>
                @else
                    <span class="badge bg-secondary">Fermée</span>
                @endif
            </td>
            <td>
                <a href="{{ route('annonces.edit', $a->id) }}" class="btn btn-warning btn-sm">Modifier</a>
                <a href="{{ route('annonces.delete', $a->id) }}" class="btn btn-danger btn-sm"
                   onclick="return confirm('Supprimer cette annonce ?')">Supprimer</a>

                @if($a->statut === 'ouverte')
                    <a href="{{ route('annonces.close', $a->id) }}" class="btn btn-secondary btn-sm"
                       onclick="return confirm('Fermer cette annonce ?')">Fermer</a>
                @endif
            </td>
        </tr>
        @endforeach
    </tbody>
</table>
@endsection
