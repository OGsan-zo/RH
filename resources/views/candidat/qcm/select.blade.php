@extends('layouts.app')
@section('title','Sélection du test')
@section('page-title','Choisir un test à passer')

@section('content')
@include('layouts.alerts')

@if($candidatures->isEmpty())
    <div class="alert alert-warning">Aucune candidature éligible pour un test.</div>
@else
<form method="GET" action="" onsubmit="return redirigerVersTest()">
    <div class="card p-4 shadow-sm">
        <label>Choisir un poste :</label>
        <select id="annonceSelect" class="form-select" required>
            <option value="">-- Sélectionner --</option>
            @foreach($candidatures as $c)
                @php
                    $test = \App\Models\Test::where('annonce_id', $c->annonce_id)->first();
                @endphp
                @if($test)
                    <option value="{{ route('tests.passer', $test->id) }}">
                        {{ $c->annonce->titre }} — {{ $c->annonce->departement->nom ?? '' }}
                    </option>
                @endif
            @endforeach
        </select>

        <button type="submit" class="btn btn-success mt-3">Passer le test</button>
    </div>
</form>

<script>
function redirigerVersTest() {
    const url = document.getElementById('annonceSelect').value;
    if (url) window.location.href = url;
    return false;
}
</script>
@endif
@endsection
