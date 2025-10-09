@extends('layouts.app')

@section('title', 'Liste des départements')
@section('page-title', 'Liste des départements')

@section('content')
<a href="{{ route('departements.create') }}" class="btn btn-primary mb-3">+ Nouveau département</a>

@if(session('success'))
    <div class="alert alert-success">{{ session('success') }}</div>
@endif

<table class="table table-bordered table-striped">
    <thead class="table-light">
        <tr>
            <th>ID</th>
            <th>Nom</th>
            <th>Actions</th>
        </tr>
    </thead>
    <tbody>
        @foreach($departements as $dep)
        <tr>
            <td>{{ $dep->id }}</td>
            <td>{{ $dep->nom }}</td>
            <td>
                <a href="{{ route('departements.edit', $dep->id) }}" class="btn btn-warning btn-sm">Modifier</a>
                <a href="{{ route('departements.delete', $dep->id) }}" class="btn btn-danger btn-sm"
                   onclick="return confirm('Confirmer la suppression ?')">Supprimer</a>
            </td>
        </tr>
        @endforeach
    </tbody>
</table>
@endsection
