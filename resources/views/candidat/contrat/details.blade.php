@extends('layouts.app')
@section('title','Mon contrat')
@section('page-title','Détails de mon contrat')

@section('content')
@include('layouts.alerts')

@if(!$contrat)
<div class="alert alert-info">Aucun contrat n’est encore disponible.</div>
@else
<div class="card p-4 shadow-sm">
    <h5>{{ strtoupper($contrat->type_contrat) }}</h5>
    <p><strong>Poste :</strong> {{ $contrat->candidature->annonce->titre }}</p>
    <p><strong>Début :</strong> {{ $contrat->date_debut }}</p>
    <p><strong>Fin :</strong> {{ $contrat->date_fin ?? '-' }}</p>
    <p><strong>Salaire :</strong> {{ number_format($contrat->salaire, 2) }} Ar</p>
    <p><strong>Statut :</strong> {{ $contrat->statut }}</p>

    @if($contrat->type_contrat === 'essai' && $contrat->statut === 'actif')
        <a href="{{ route('contrat.fin', $contrat->id) }}" class="btn btn-danger mt-3"
           onclick="return confirm('Confirmer la fin du contrat d’essai ?')">
           Notifier fin d’essai
        </a>
    @endif
</div>
@endif
@endsection
