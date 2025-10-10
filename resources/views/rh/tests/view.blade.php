@extends('layouts.app')

@section('title', 'Voir les tests QCM')
@section('page-title', 'Tests QCM des annonces')

@section('content')
<form method="GET" action="{{ route('tests.view') }}" class="mb-4">
    <label>Choisir une annonce</label>
    <select name="annonce_id" class="form-select" onchange="this.form.submit()">
        <option value="">-- Sélectionner --</option>
        @foreach($annonces as $a)
            <option value="{{ $a->id }}" {{ $annonceId == $a->id ? 'selected' : '' }}>
                {{ $a->titre }}
            </option>
        @endforeach
    </select>
</form>

@if($test)
    <div class="card p-4 shadow-sm">
        <h5>{{ $test->titre }}</h5>
        <p class="text-muted">{{ $test->description }}</p>

        @foreach($test->questions as $q)
            <div class="mt-3">
                <strong>{{ $loop->iteration }}. {{ $q->intitule }}</strong>
                <ul>
                    @foreach($q->reponses as $r)
                        <li @if($r->est_correcte) style="color:green;font-weight:bold" @endif>
                            {{ $r->texte }}
                            @if($r->est_correcte)
                                <span>(✔ Correcte)</span>
                            @endif
                        </li>
                    @endforeach
                </ul>
            </div>
        @endforeach
    </div>
@elseif($annonceId)
    <p class="text-danger">Aucun test généré pour cette annonce.</p>
@endif
@endsection
