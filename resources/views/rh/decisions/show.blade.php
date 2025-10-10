@extends('layouts.app')
@section('title','Décision de recrutement')
@section('page-title','Profil du candidat')

@section('content')
@include('layouts.alerts')

<div class="card p-4 shadow-sm mb-4">
    <h5 class="mb-3">Informations du candidat</h5>
    <p><strong>Nom :</strong> {{ $candidature->candidat->nom }} {{ $candidature->candidat->prenom }}</p>
    <p><strong>Email :</strong> {{ $candidature->candidat->email }}</p>
    <p><strong>Date de naissance :</strong> {{ $candidature->candidat->date_naissance }}</p>
    <p><strong>Poste :</strong> {{ $candidature->annonce->titre }}</p>
    <p><strong>Département :</strong> {{ $candidature->annonce->departement->nom ?? '-' }}</p>
    <p><strong>CV :</strong>
        @if($candidature->candidat->cv_path)
            <a href="{{ asset($candidature->candidat->cv_path) }}" target="_blank">Voir le CV</a>
        @else
            Non disponible
        @endif
    </p>
</div>

<div class="card p-4 shadow-sm mb-4">
    <h5 class="mb-3">Notes du candidat</h5>
    <p><strong>Score QCM :</strong> {{ $resultatTest->score ?? '-' }}%</p>
    <p><strong>Note entretien :</strong>
        @if($evaluation)
            {{ $evaluation->note }}/20 ({{ round(($evaluation->note / 20) * 100, 2) }}%)
        @else
            -
        @endif
    </p>
    <p><strong>Score global :</strong> {{ $candidature->score_global ?? '-' }}%</p>
</div>

<div class="card p-4 shadow-sm">
    <h5 class="mb-3">Remarques RH</h5>
    <p>{{ $evaluation->remarques ?? 'Aucune remarque saisie.' }}</p>

    <div class="d-flex justify-content-between mt-4">
        <a href="{{ route('decisions.update', [$candidature->id, 'accepter']) }}"
           class="btn btn-success"
           onclick="return confirm('Confirmer l\'acceptation de ce candidat ?')">
           ✅ Accepter
        </a>

        <a href="{{ route('decisions.update', [$candidature->id, 'refuser']) }}"
           class="btn btn-danger"
           onclick="return confirm('Refuser définitivement ce candidat ?')">
           ❌ Refuser
        </a>
    </div>
</div>
@endsection
