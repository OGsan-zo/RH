@extends('layouts.app')
@section('title','Résultats entretiens')
@section('page-title','Scores cumulés par poste')

@section('content')
@include('layouts.alerts')

<form method="GET" action="{{ route('evaluations.resultats') }}" class="mb-4">
    <div class="row g-2 align-items-center">
        <div class="col-md-6">
            <select name="annonce_id" class="form-select" required>
                <option value="">-- Sélectionner un poste --</option>
                @foreach($annonces as $a)
                    <option value="{{ $a->id }}" @if($posteId == $a->id) selected @endif>
                        {{ $a->titre }}
                    </option>
                @endforeach
            </select>
        </div>
        <div class="col-md-2">
            <button type="submit" class="btn btn-primary">Voir</button>
        </div>
    </div>
</form>

@if(!empty($candidatures))
<table class="table table-striped">
    <thead>
        <tr>
            <th>Candidat</th>
            <th>Poste</th>
            <th>Score QCM</th>
            <th>Note entretien</th>
            <th>Score global (%)</th>
            <th>Action</th>
        </tr>
    </thead>
    <tbody>
        @foreach($candidatures as $c)
            @php
                $evaluation = \App\Models\EvaluationEntretien::whereHas('entretien', function($q) use ($c) {
                    $q->where('candidature_id', $c->id);
                })->first();
            @endphp
            <tr>
                <td>{{ $c->candidat->nom }} {{ $c->candidat->prenom }}</td>
                <td>{{ $c->annonce->titre }}</td>
                
                @php
                    $resultatTest = \App\Models\ResultatTest::where('candidature_id', $c->id)->first();
                @endphp
                <td>{{ $resultatTest ? $resultatTest->score : '-' }}%</td>  

                @php
                    $evaluation = \App\Models\EvaluationEntretien::whereHas('entretien', function($q) use ($c) {
                        $q->where('candidature_id', $c->id);
                    })->first();
                    $noteEntretienPourcent = $evaluation ? round(($evaluation->note / 20) * 100, 2) : null;
                @endphp
                <td>{{ $evaluation ? $evaluation->note : '-' }}/20 ({{ $noteEntretienPourcent ?? '-' }}%)</td>

                <td><strong>{{ $c->score_global ?? '-' }}%</strong></td>

                <td>
                    <a href="{{ route('decisions.show', $c->id) }}" class="btn btn-outline-primary btn-sm">
                        Voir profil
                    </a>
                </td>
            </tr>
        @endforeach
    </tbody>
</table>
@endif
@endsection
