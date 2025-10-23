@extends('layouts.app')
@section('title','Résultats du test')
@section('page-title','Résultats du candidat')

@section('content')
<div class="card p-4 shadow-sm">
    <h5>{{ $candidature->candidat->nom }} {{ $candidature->candidat->prenom }}</h5>
    <p><strong>Annonce :</strong> {{ $candidature->annonce->titre }}</p>
    
    <div class="row mb-3">
        <div class="col-md-4">
            <strong>Note CV (IA) :</strong> 
            <span class="badge bg-info">{{ $candidature->note_cv ?? 'N/A' }}%</span>
        </div>
        <div class="col-md-4">
            <strong>Score Test :</strong> 
            <span class="badge bg-primary">{{ $resultat->score ?? 'N/A' }}%</span>
        </div>
        <div class="col-md-4">
            <strong>Score Global :</strong> 
            <span class="badge bg-success">{{ $candidature->score_global ?? 'N/A' }}%</span>
        </div>
    </div>

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
