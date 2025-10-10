@extends('layouts.app')

@section('title', 'Générer un test QCM')
@section('page-title', 'Création de test QCM automatique')

@section('content')
<form action="{{ route('tests.store') }}" method="POST" class="card p-4 shadow-sm">
    @csrf

    <div class="mb-3">
        <label>Annonce liée</label>
        <select name="annonce_id" class="form-select" required>
            <option value="">-- Choisir une annonce --</option>
            @foreach($annonces as $a)
                <option value="{{ $a->id }}">{{ $a->titre }}</option>
            @endforeach
        </select>
    </div>

    <div class="row">
        <div class="col-md-6 mb-3">
            <label>Nombre de questions</label>
            <input type="number" name="nombre_questions" class="form-control" min="1" max="20" required>
        </div>
        <div class="col-md-6 mb-3">
            <label>Nombre de réponses par question</label><br>
            <div class="form-check form-check-inline">
                <input class="form-check-input" type="radio" name="nombre_reponses" value="3" required>
                <label class="form-check-label">3 réponses</label>
            </div>
            <div class="form-check form-check-inline">
                <input class="form-check-input" type="radio" name="nombre_reponses" value="4" required checked>
                <label class="form-check-label">4 réponses</label>
            </div>
        </div>
    </div>

    <button class="btn btn-success">Générer avec Gemini</button>
</form>

@if(session('error'))
    <div class="alert alert-danger mt-3">{{ session('error') }}</div>
@endif
@if(session('success'))
    <div class="alert alert-success mt-3">{{ session('success') }}</div>
@endif
@endsection
