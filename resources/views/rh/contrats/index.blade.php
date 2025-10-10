@extends('layouts.app')
@section('title','Contrats')
@section('page-title','Gestion des contrats')

@section('content')
@include('layouts.alerts')

<h5>Candidats retenus sans contrat</h5>
<table class="table table-striped mb-4">
<thead><tr><th>Candidat</th><th>Poste</th><th></th></tr></thead>
<tbody>
@foreach($retenus as $r)
    @php $contrat = \App\Models\Contrat::where('candidature_id',$r->id)->first(); @endphp
    <tr>
        <td>{{ $r->candidat->nom }} {{ $r->candidat->prenom }}</td>
        <td>{{ $r->annonce->titre }}</td>
        <td>
            @if(!$contrat)
                <a href="{{ route('contrats.create',['candidature_id'=>$r->id]) }}" class="btn btn-success btn-sm">Créer contrat</a>
            @endif
        </td>
    </tr>
@endforeach
</tbody>
</table>

<h5>Contrats existants</h5>
<table class="table table-bordered">
<thead><tr><th>Candidat</th><th>Poste</th><th>Type</th><th>Début</th><th>Fin</th><th>Salaire</th><th>Actions</th></tr></thead>
<tbody>
@foreach($contrats as $c)
<tr>
    <td>{{ $c->candidature->candidat->nom }}</td>
    <td>{{ $c->candidature->annonce->titre }}</td>
    <td>{{ strtoupper($c->type_contrat) }}</td>
    <td>{{ $c->date_debut }}</td>
    <td>{{ $c->date_fin ?? '-' }}</td>
    <td>{{ number_format($c->salaire,2) }} Ar</td>
    <td>
        <a href="{{ route('contrats.edit',$c->id) }}" class="btn btn-primary btn-sm">Renouveler</a>
    </td>
</tr>
@endforeach
</tbody>
</table>
@endsection
