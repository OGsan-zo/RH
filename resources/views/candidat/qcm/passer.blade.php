@extends('layouts.app')
@section('title','Test QCM')
@section('page-title',$test->titre)
@section('content')
@include('layouts.alerts')

<form action="{{ route('tests.submit',$test->id) }}" method="POST" class="card p-4 shadow-sm">
    @csrf
    @foreach($test->questions as $q)
        <div class="mb-4">
            <strong>{{ $loop->iteration }}. {{ $q->intitule }}</strong>
            @foreach($q->reponses as $r)
                <div class="form-check">
                    <input class="form-check-input" type="radio" name="question_{{ $q->id }}" value="{{ $r->id }}" required>
                    <label class="form-check-label">{{ $r->texte }}</label>
                </div>
            @endforeach
        </div>
    @endforeach
    <button type="submit" class="btn btn-success"
        onclick="return confirm('Êtes-vous sûr de vouloir valider vos réponses ?')">
        Valider mes réponses
    </button>
</form>
@endsection
