@extends('layouts.app')
@section('title','Suivi de candidature')
@section('page-title','Suivi de votre candidature')

@section('content')

@include('layouts.alerts')

@if(count($candidatures))
    @foreach($candidatures as $c)
        <div class="card p-3 mb-3">
            <h5>{{ $c->annonce->titre ?? 'Annonce supprimée' }}</h5>
            <p><strong>Statut :</strong>
            <span class="badge 
                    @if($c->statut=='en_attente') bg-secondary 
                        @elseif($c->statut=='test_en_cours') bg-info
                        @elseif($c->statut=='en_entretien') bg-warning
                        @elseif($c->statut=='retenu') bg-success
                        @elseif($c->statut=='refuse') bg-danger
                        @elseif($c->statut=='employe') bg-primary
                    @endif">
                {{ str_replace('_',' ',$c->statut) }}
            </span></p>
            <p><strong>Date de candidature :</strong> {{ $c->date_candidature }}</p>
        </div>
    @endforeach
@else
    <p>Aucune candidature enregistrée pour l’instant.</p>
@endif
@endsection
