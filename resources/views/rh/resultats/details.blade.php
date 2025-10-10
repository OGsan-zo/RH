@extends('layouts.app')
@section('title','Résultats du test')
@section('page-title','Résultats du candidat')

@section('content')
<div class="card p-4 shadow-sm">
    <h5>{{ $candidature->candidat->nom }} {{ $candidature->candidat->prenom }}</h5>
    <p><strong>Annonce :</strong> {{ $candidature->annonce->titre }}</p>
    <p><strong>Score :</strong> {{ $resultat->score ?? 'N/A' }}%</p>

    <hr>
    <h6>Réponses :</h6>
    @foreach($resultat->reponsesCandidat as $rep)
        <div class="mb-3">
            <strong>{{ $loop->iteration }}. {{ $rep->question->intitule }}</strong>
            <ul>
                @foreach($rep->question->reponses as $r)
                    <li @if($r->est_correcte) style="color:green;font-weight:bold" @endif>
                        {{ $r->texte }}
                        @if($rep->reponse_id == $r->id)
                            <span style="color:blue"> ← réponse du candidat</span>
                        @endif
                    </li>
                @endforeach
            </ul>
        </div>
    @endforeach
</div>
@endsection
