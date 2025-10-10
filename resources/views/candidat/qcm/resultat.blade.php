@extends('layouts.app')
@section('title','Résultat du test')
@section('page-title','Résultat de votre test')

@section('content')
<div class="card p-4 shadow-sm text-center">
    <h5>{{ $test->titre }}</h5>
    <p>Score obtenu : <strong>{{ $pourcentage }}%</strong></p>
    @if($pourcentage >= 70)
        <div class="alert alert-success">Félicitations, test réussi !</div>
    @else
        <div class="alert alert-danger">Test non réussi.</div>
    @endif
    <a href="{{ route('candidatures.suivi') }}" class="btn btn-primary mt-3">Voir mon suivi</a>
</div>
@endsection
