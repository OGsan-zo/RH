@extends('layouts.app')
@section('title','Mes entretiens')
@section('page-title','Notifications d’entretien')

@section('content')
@include('layouts.alerts')

@if($entretiens->isEmpty())
<div class="alert alert-info">Aucun entretien planifié pour le moment.</div>
@else
@foreach($entretiens as $e)
<div class="card p-3 mb-3 shadow-sm">
    <h5>{{ $e->candidature->annonce->titre }}</h5>
    <p><strong>Date :</strong> {{ $e->date_entretien }}</p>
    <p><strong>Lieu :</strong> {{ $e->lieu }}</p>
    <p><strong>Statut :</strong> {{ $e->statut }}</p>

    @if($e->statut === 'planifie')
    <div>
        <a href="{{ route('entretiens.reponse', [$e->id, 'confirmer']) }}" class="btn btn-success btn-sm">Confirmer</a>
        <a href="{{ route('entretiens.reponse', [$e->id, 'refuser']) }}" class="btn btn-danger btn-sm">Refuser</a>
    </div>
    @endif
</div>
@endforeach
@endif
@endsection
