@extends('layouts.adminlte')

@section('title', 'Contrats')
@section('page-title', 'Gestion des Contrats')

@section('breadcrumb')
    <li class="breadcrumb-item"><a href="{{ route('rh.dashboard') }}">Dashboard</a></li>
    <li class="breadcrumb-item active">Contrats</li>
@endsection

@section('sidebar')
    @include('layouts.partials.sidebar-rh')
@endsection

@section('content')
    <!-- Candidats retenus sans contrat -->
    <div class="row">
        <div class="col-12">
            <div class="card card-warning">
                <div class="card-header">
                    <h3 class="card-title"><i class="fas fa-user-plus mr-2"></i>Candidats Retenus Sans Contrat</h3>
                </div>
                <div class="card-body p-0">
                    @if($retenus->isEmpty())
                        <div class="p-3">
                            <div class="alert alert-info mb-0">
                                <i class="fas fa-info-circle mr-2"></i>Tous les candidats retenus ont un contrat.
                            </div>
                        </div>
                    @else
                        <table class="table table-striped m-0">
                            <thead>
                                <tr>
                                    <th>Candidat</th>
                                    <th>Poste</th>
                                    <th class="text-center" style="width: 150px">Action</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach($retenus as $r)
                                    @php $contrat = \App\Models\Contrat::where('candidature_id',$r->id)->first(); @endphp
                                    <tr>
                                        <td><i class="fas fa-user text-muted mr-1"></i>{{ $r->candidat->nom }} {{ $r->candidat->prenom }}</td>
                                        <td>{{ $r->annonce->titre }}</td>
                                        <td class="text-center">
                                            @if(!$contrat)
                                                <a href="{{ route('contrats.create',['candidature_id'=>$r->id]) }}" class="btn btn-success btn-sm">
                                                    <i class="fas fa-file-contract"></i> Créer contrat
                                                </a>
                                            @endif
                                        </td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                    @endif
                </div>
            </div>
        </div>
    </div>

    <!-- Contrats existants -->
    <div class="row">
        <div class="col-12">
            <div class="card">
                <div class="card-header">
                    <h3 class="card-title"><i class="fas fa-file-contract mr-2"></i>Contrats Existants</h3>
                    <div class="card-tools">
                        <a href="{{ route('contrats.status') }}" class="btn btn-primary btn-sm">
                            <i class="fas fa-chart-pie"></i> Voir par statut
                        </a>
                    </div>
                </div>
                <div class="card-body p-0">
                    <div class="table-responsive">
                        <table class="table table-striped table-hover m-0">
                            <thead class="thead-light">
                                <tr>
                                    <th>Candidat</th>
                                    <th>Poste</th>
                                    <th>Type</th>
                                    <th>Début</th>
                                    <th>Fin</th>
                                    <th>Salaire</th>
                                    <th class="text-center">Renouvellements</th>
                                    <th class="text-center">Actions</th>
                                </tr>
                            </thead>
                            <tbody>
                                @forelse($contrats as $c)
                                <tr>
                                    <td><i class="fas fa-user text-muted mr-1"></i>{{ $c->candidature->candidat->nom }}</td>
                                    <td>{{ $c->candidature->annonce->titre }}</td>
                                    <td><span class="badge badge-info">{{ strtoupper($c->type_contrat) }}</span></td>
                                    <td><i class="far fa-calendar text-muted mr-1"></i>{{ \Carbon\Carbon::parse($c->date_debut)->format('d/m/Y') }}</td>
                                    <td>
                                        @if($c->date_fin)
                                            <i class="far fa-calendar text-muted mr-1"></i>{{ \Carbon\Carbon::parse($c->date_fin)->format('d/m/Y') }}
                                        @else
                                            <span class="text-muted">-</span>
                                        @endif
                                    </td>
                                    <td><strong>{{ number_format($c->salaire, 0, ',', ' ') }} Ar</strong></td>
                                    <td class="text-center">
                                        <span class="badge badge-{{ $c->renouvellement >= 1 ? 'danger' : 'success' }}">
                                            {{ $c->renouvellement }}/1
                                        </span>
                                    </td>
                                    <td class="text-center">
                                        @if($c->peutEtreRenouvele())
                                            <a href="{{ route('contrats.edit',$c->id) }}" class="btn btn-warning btn-sm">
                                                <i class="fas fa-sync-alt"></i> Modifier
                                            </a>
                                        @else
                                            <button class="btn btn-secondary btn-sm" disabled title="Déjà modifié une fois">
                                                <i class="fas fa-ban"></i> Bloqué
                                            </button>
                                        @endif
                                    </td>
                                </tr>
                                @empty
                                <tr>
                                    <td colspan="8" class="text-center text-muted">
                                        <i class="fas fa-info-circle"></i> Aucun contrat enregistré
                                    </td>
                                </tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
