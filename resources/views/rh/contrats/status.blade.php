@extends('layouts.app')
@section('title','Statut des contrats')
@section('page-title','Suivi des contrats par statut')

@section('content')
@include('layouts.alerts')

<div class="card p-4 shadow-sm mb-4">
    <form method="GET" action="{{ route('contrats.status') }}" class="row g-3 align-items-end">
        <div class="col-md-4">
            <label for="statut" class="form-label">Filtrer par statut</label>
            <select name="statut" id="statut" class="form-select">
                @foreach($statuts as $s)
                    <option value="{{ $s }}" @if($filtre === $s) selected @endif>
                        {{ ucfirst($s) }}
                    </option>
                @endforeach
            </select>
        </div>
        <div class="col-md-2">
            <button type="submit" class="btn btn-primary w-100">Filtrer</button>
        </div>
    </form>
</div>

@if($contrats->isEmpty())
<div class="alert alert-info">
    Aucun contrat avec le statut <strong>{{ $filtre }}</strong>.
</div>
@else
<table class="table table-striped table-bordered align-middle">
    <thead class="table-dark">
        <tr>
            <th>Candidat</th>
            <th>Poste</th>
            <th>Type</th>
            <th>Début</th>
            <th>Fin</th>
            <th>Salaire</th>
            <th>Renouvellements</th>
            <th>Statut</th>
        </tr>
    </thead>
    <tbody>
        @foreach($contrats as $c)
        <tr>
            <td>{{ $c->candidature->candidat->nom }} {{ $c->candidature->candidat->prenom }}</td>
            <td>{{ $c->candidature->annonce->titre }}</td>
            <td>{{ strtoupper($c->type_contrat) }}</td>
            <td>{{ $c->date_debut }}</td>
            <td>{{ $c->date_fin ?? '-' }}</td>
            <td>{{ number_format($c->salaire,2) }} Ar</td>
            <td>{{ $c->renouvellement }}</td>
            <td>
                <span class="badge 
                    @if($c->statut === 'actif') bg-success 
                    @elseif($c->statut === 'expiré') bg-warning 
                    @else bg-secondary @endif">
                    {{ ucfirst($c->statut) }}
                </span>
            </td>
        </tr>
        @endforeach
    </tbody>
</table>
@endif
@endsection
