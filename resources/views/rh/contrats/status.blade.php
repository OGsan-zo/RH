@extends('layouts.adminlte')

@section('title', 'Statut des contrats')
@section('page-title', 'Suivi des Contrats')

@section('breadcrumb')
    <li class="breadcrumb-item"><a href="{{ route('rh.dashboard') }}">Dashboard</a></li>
    <li class="breadcrumb-item"><a href="{{ route('contrats.index') }}">Contrats</a></li>
    <li class="breadcrumb-item active">Statut</li>
@endsection

@section('sidebar')
    @include('layouts.partials.sidebar-rh')
@endsection

@section('content')
    <div class="row">
        <div class="col-12">
            <div class="card">
                <div class="card-header">
                    <h3 class="card-title"><i class="fas fa-chart-pie mr-2"></i>Suivi des Contrats par Statut</h3>
                </div>
                <div class="card-body">
                    <form method="GET" action="{{ route('contrats.status') }}" class="mb-4">
                        <div class="row">
                            <div class="col-md-4">
                                <div class="form-group">
                                    <label for="statut"><i class="fas fa-filter mr-1"></i>Filtrer par statut</label>
                                    <select name="statut" id="statut" class="form-control">
                                        @foreach($statuts as $s)
                                            <option value="{{ $s }}" @if($filtre === $s) selected @endif>
                                                {{ ucfirst($s) }}
                                            </option>
                                        @endforeach
                                    </select>
                                </div>
                            </div>
                            <div class="col-md-2">
                                <label>&nbsp;</label>
                                <button type="submit" class="btn btn-primary btn-block">
                                    <i class="fas fa-search"></i> Filtrer
                                </button>
                            </div>
                        </div>
                    </form>

                    @if($contrats->isEmpty())
                        <div class="alert alert-info">
                            <i class="fas fa-info-circle mr-2"></i>
                            Aucun contrat avec le statut <strong>{{ $filtre }}</strong>.
                        </div>
                    @else
                        <div class="table-responsive">
                            <table class="table table-striped table-bordered table-hover">
                                <thead class="thead-light">
                                    <tr>
                                        <th>Candidat</th>
                                        <th>Poste</th>
                                        <th>Type</th>
                                        <th>Début</th>
                                        <th>Fin</th>
                                        <th>Salaire</th>
                                        <th class="text-center">Renouvellements</th>
                                        <th class="text-center">Statut</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach($contrats as $c)
                                    <tr>
                                        <td><i class="fas fa-user text-muted mr-1"></i>{{ $c->candidature->candidat->nom }} {{ $c->candidature->candidat->prenom }}</td>
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
                                        <td class="text-center"><span class="badge badge-secondary">{{ $c->renouvellement }}</span></td>
                                        <td class="text-center">
                                            @if($c->statut === 'actif')
                                                <span class="badge badge-success"><i class="fas fa-check-circle"></i> Actif</span>
                                            @elseif($c->statut === 'expiré')
                                                <span class="badge badge-warning"><i class="fas fa-exclamation-triangle"></i> Expiré</span>
                                            @else
                                                <span class="badge badge-secondary">{{ ucfirst($c->statut) }}</span>
                                            @endif
                                        </td>
                                    </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                    @endif
                </div>
            </div>
        </div>
    </div>
@endsection
