@extends('layouts.adminlte')

@section('title', 'Administration des Soldes')
@section('page-title', 'Administration des Soldes de Congés')

@section('breadcrumb')
    <li class="breadcrumb-item active">Soldes Administration</li>
@endsection

@section('sidebar')
    @include('layouts.partials.sidebar-rh')
@endsection

@section('content')
<div class="row">
    <div class="col-md-12">
        <div class="card">
            <div class="card-header bg-primary text-white">
                <h3 class="card-title">Gestion des Soldes de Congés</h3>
            </div>
            <div class="card-body">
                @if(session('success'))
                    <div class="alert alert-success alert-dismissible fade show" role="alert">
                        {{ session('success') }}
                        <button type="button" class="close" data-dismiss="alert"><span>&times;</span></button>
                    </div>
                @endif

                @if(session('error'))
                    <div class="alert alert-danger alert-dismissible fade show" role="alert">
                        {{ session('error') }}
                        <button type="button" class="close" data-dismiss="alert"><span>&times;</span></button>
                    </div>
                @endif

                <form action="{{ route('soldes-admin.calculer') }}" method="POST" style="display: inline;">
                    @csrf
                    <button type="submit" class="btn btn-success btn-lg">
                        <i class="fas fa-calculator"></i> Calculer les Soldes pour Tous les Employés
                    </button>
                </form>
            </div>
        </div>
    </div>
</div>

<!-- Statistiques -->
<div class="row mt-4">
    <div class="col-md-4">
        <div class="info-box">
            <span class="info-box-icon bg-info"><i class="fas fa-users"></i></span>
            <div class="info-box-content">
                <span class="info-box-text">Total Employés</span>
                <span class="info-box-number">{{ $stats['total_employes'] }}</span>
            </div>
        </div>
    </div>

    <div class="col-md-4">
        <div class="info-box">
            <span class="info-box-icon bg-success"><i class="fas fa-check"></i></span>
            <div class="info-box-content">
                <span class="info-box-text">Avec Soldes</span>
                <span class="info-box-number">{{ $stats['employes_avec_soldes'] }}</span>
            </div>
        </div>
    </div>

    <div class="col-md-4">
        <div class="info-box">
            <span class="info-box-icon bg-warning"><i class="fas fa-exclamation"></i></span>
            <div class="info-box-content">
                <span class="info-box-text">Sans Soldes</span>
                <span class="info-box-number">{{ $stats['employes_sans_soldes'] }}</span>
            </div>
        </div>
    </div>
</div>

<!-- Tableau des employés -->
<div class="row mt-4">
    <div class="col-md-12">
        <div class="card">
            <div class="card-header">
                <h3 class="card-title">Détail des Soldes par Employé</h3>
            </div>
            <div class="card-body">
                <div class="table-responsive">
                    <table class="table table-striped table-hover">
                        <thead class="table-light">
                            <tr>
                                <th>Employé</th>
                                <th>Type de Congé</th>
                                <th>Acquis</th>
                                <th>Utilisés</th>
                                <th>Restants</th>
                                <th>Reportés</th>
                                <th>Période</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse($employes as $employe)
                                @if($employe->soldesConges->count() > 0)
                                    @foreach($employe->soldesConges as $solde)
                                        <tr>
                                            <td>
                                                <strong>{{ $employe->candidat->nom ?? 'N/A' }} {{ $employe->candidat->prenom ?? '' }}</strong>
                                            </td>
                                            <td>{{ $solde->typeCongé->nom ?? 'N/A' }}</td>
                                            <td><span class="badge badge-info">{{ $solde->jours_acquis }}</span></td>
                                            <td><span class="badge badge-warning">{{ $solde->jours_utilises }}</span></td>
                                            <td><span class="badge badge-success">{{ $solde->jours_restants }}</span></td>
                                            <td><span class="badge badge-secondary">{{ $solde->jours_reportes }}</span></td>
                                            <td>{{ \Carbon\Carbon::parse($solde->date_debut_periode)->format('Y') }}</td>
                                        </tr>
                                    @endforeach
                                @else
                                    <tr>
                                        <td colspan="7" class="text-center text-muted">
                                            <strong>{{ $employe->candidat->nom ?? 'N/A' }} {{ $employe->candidat->prenom ?? '' }}</strong> - Aucun solde
                                        </td>
                                    </tr>
                                @endif
                            @empty
                                <tr>
                                    <td colspan="7" class="text-center text-muted">Aucun employé</td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Instructions -->
<div class="row mt-4">
    <div class="col-md-12">
        <div class="card">
            <div class="card-header bg-info text-white">
                <h5 class="card-title">ℹ️ Instructions</h5>
            </div>
            <div class="card-body">
                <p><strong>Calcul Automatique :</strong></p>
                <ul>
                    <li>Les soldes sont calculés automatiquement le <strong>1er janvier</strong> de chaque année</li>
                    <li>Chaque employé reçoit <strong>30 jours</strong> de congés payés par an (2,5 jours/mois)</li>
                    <li>Maximum <strong>5 jours</strong> peuvent être reportés à l'année suivante</li>
                </ul>

                <p class="mt-3"><strong>Calcul Manuel :</strong></p>
                <ul>
                    <li>Cliquez sur le bouton "Calculer les Soldes" pour déclencher le calcul manuellement</li>
                    <li>Utile pour tester ou recalculer les soldes</li>
                </ul>

                <p class="mt-3"><strong>Commande Artisan :</strong></p>
                <code>php artisan conges:calculer-soldes</code>
            </div>
        </div>
    </div>
</div>
@endsection
