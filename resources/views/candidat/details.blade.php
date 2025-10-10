@extends('layouts.app')
@section('title','Détails de l\'annonce')
@section('page-title',$annonce->titre)

@section('content')

@include('layouts.alerts')


<div class="card p-4 shadow-sm">
    <h5>{{ $annonce->titre }}</h5>
    <p><strong>Département :</strong> {{ $annonce->departement->nom ?? '-' }}</p>
    <p><strong>Description :</strong> {{ $annonce->description }}</p>
    <p><strong>Compétences requises :</strong> {{ $annonce->competences_requises }}</p>
    <p><strong>Niveau requis :</strong> {{ $annonce->niveau_requis }}</p>

    <a href="{{ route('candidatures.postuler',$annonce->id) }}" class="btn btn-success">Postuler</a>
    <a href="{{ route('candidatures.index') }}" class="btn btn-secondary">Retour</a>
</div>

@endsection
