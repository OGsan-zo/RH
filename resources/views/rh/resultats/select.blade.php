@extends('layouts.app')
@section('title','Résultats des candidats')
@section('page-title','Voir les résultats QCM')

@section('content')
@include('layouts.alerts')

@if($resultats->isEmpty())
    <div class="alert alert-warning">Aucun test passé pour le moment.</div>
@else
<form method="GET" action="" onsubmit="return allerVersResultat()">
    <div class="card p-4 shadow-sm">
        <label>Choisir un candidat :</label>
        <select id="resultSelect" class="form-select" required>
            <option value="">-- Sélectionner --</option>
            @foreach($resultats as $r)
                <option value="{{ route('resultats.details', $r->candidature_id) }}">
                    {{ $r->candidature->candidat->nom }} {{ $r->candidature->candidat->prenom }}
                    — {{ $r->test->titre }}
                    ({{ $r->score }}%)
                </option>
            @endforeach
        </select>

        <button type="submit" class="btn btn-primary mt-3">Voir le résultat</button>
    </div>
</form>

<script>
function allerVersResultat() {
    const url = document.getElementById('resultSelect').value;
    if (url) window.location.href = url;
    return false;
}
</script>
@endif
@endsection
