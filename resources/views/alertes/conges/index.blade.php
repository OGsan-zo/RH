@extends('layouts.adminlte')

@section('title', 'Alertes - Congés')
@section('page-title', 'Alertes de Congés')

@section('breadcrumb')
    <li class="breadcrumb-item active">Alertes</li>
@endsection

@section('sidebar')
    @include('layouts.partials.sidebar-rh')
@endsection

@section('content')
<div class="row">
    <div class="col-md-12">
        <div class="card">
            <div class="card-header bg-danger text-white">
                <h3 class="card-title">🚨 Alertes Non Résolues</h3>
                <div class="card-tools">
                    <a href="{{ route('alertes-conges.resolues') }}" class="btn btn-sm btn-success">
                        <i class="fas fa-check"></i> Voir les alertes résolues
                    </a>
                </div>
            </div>
            <div class="card-body">
                @if($alertes->count() > 0)
                    <div class="list-group">
                        @foreach($alertes as $alerte)
                            <div class="list-group-item border-left-danger">
                                <div class="row">
                                    <div class="col-md-9">
                                        <h5 class="mb-1">
                                            @switch($alerte->type_alerte)
                                                @case('conges_non_valides')
                                                    <span class="badge badge-warning">⏳ Congés Non Validés</span>
                                                    @break
                                                @case('absences_repetees')
                                                    <span class="badge badge-danger">📊 Absences Répétées</span>
                                                    @break
                                                @case('soldes_faibles')
                                                    <span class="badge badge-info">📉 Soldes Faibles</span>
                                                    @break
                                                @case('expiration_conges')
                                                    <span class="badge badge-danger">⚠️ Expiration Imminente</span>
                                                    @break
                                            @endswitch
                                        </h5>
                                        <p class="mb-1">{{ $alerte->message }}</p>
                                        <small class="text-muted">
                                            <strong>Employé :</strong> {{ $alerte->employe->candidat->nom ?? 'N/A' }} {{ $alerte->employe->candidat->prenom ?? '' }}
                                            <br>
                                            <strong>Créée :</strong> {{ $alerte->date_creation->diffForHumans() }}
                                        </small>
                                    </div>
                                    <div class="col-md-3 text-right">
                                        <form action="{{ route('alertes-conges.resoudre', $alerte->id) }}" method="POST" style="display: inline;">
                                            @csrf
                                            <button type="submit" class="btn btn-sm btn-success">
                                                <i class="fas fa-check"></i> Résoudre
                                            </button>
                                        </form>
                                    </div>
                                </div>
                            </div>
                        @endforeach
                    </div>

                    <div class="mt-3">
                        {{ $alertes->links() }}
                    </div>
                @else
                    <div class="alert alert-success">
                        <i class="fas fa-check-circle"></i> Aucune alerte non résolue. Tout va bien ! ✅
                    </div>
                @endif
            </div>
        </div>
    </div>
</div>

<!-- Statistiques -->
<div class="row mt-4">
    <div class="col-md-3">
        <div class="info-box">
            <span class="info-box-icon bg-warning"><i class="fas fa-hourglass-half"></i></span>
            <div class="info-box-content">
                <span class="info-box-text">Congés Non Validés</span>
                <span class="info-box-number">{{ $alertes->where('type_alerte', 'conges_non_valides')->count() }}</span>
            </div>
        </div>
    </div>

    <div class="col-md-3">
        <div class="info-box">
            <span class="info-box-icon bg-danger"><i class="fas fa-chart-bar"></i></span>
            <div class="info-box-content">
                <span class="info-box-text">Absences Répétées</span>
                <span class="info-box-number">{{ $alertes->where('type_alerte', 'absences_repetees')->count() }}</span>
            </div>
        </div>
    </div>

    <div class="col-md-3">
        <div class="info-box">
            <span class="info-box-icon bg-info"><i class="fas fa-arrow-down"></i></span>
            <div class="info-box-content">
                <span class="info-box-text">Soldes Faibles</span>
                <span class="info-box-number">{{ $alertes->where('type_alerte', 'soldes_faibles')->count() }}</span>
            </div>
        </div>
    </div>

    <div class="col-md-3">
        <div class="info-box">
            <span class="info-box-icon bg-danger"><i class="fas fa-exclamation-triangle"></i></span>
            <div class="info-box-content">
                <span class="info-box-text">Expiration Imminente</span>
                <span class="info-box-number">{{ $alertes->where('type_alerte', 'expiration_conges')->count() }}</span>
            </div>
        </div>
    </div>
</div>
@endsection
