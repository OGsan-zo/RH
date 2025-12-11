@extends('layouts.adminlte')

@section('title', 'Soldes de Congés')
@section('page-title', 'Soldes de Congés - ' . ($employe->nom ?? 'N/A'))

@section('breadcrumb')
    <li class="breadcrumb-item"><a href="{{ route('soldes-conges.index') }}">Soldes</a></li>
    <li class="breadcrumb-item active">{{ $employe->nom ?? 'N/A' }}</li>
@endsection

@section('sidebar')
    @include('layouts.partials.sidebar-rh')
@endsection

@section('content')
<div class="card">
    <div class="card-header">
        <h3 class="card-title">Soldes de {{ $employe->nom ?? 'N/A' }}</h3>
        <div class="card-tools">
            <a href="{{ route('soldes-conges.recalculer', $employe->id) }}" class="btn btn-warning btn-sm">
                <i class="fas fa-sync"></i> Recalculer
            </a>
        </div>
    </div>
        <div class="card-body">
            <table class="table table-hover">
                <thead class="table-light">
                    <tr>
                        <th>Type de Congé</th>
                        <th>Acquis</th>
                        <th>Utilisés</th>
                        <th>Restants</th>
                        <th>Reportés</th>
                        <th>Période</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($soldes as $solde)
                        <tr>
                            <td><strong>{{ $solde->typeCongé->nom ?? 'N/A' }}</strong></td>
                            <td><span class="badge badge-info">{{ $solde->jours_acquis }}</span></td>
                            <td><span class="badge badge-warning">{{ $solde->jours_utilises }}</span></td>
                            <td><span class="badge badge-success">{{ $solde->jours_restants }}</span></td>
                            <td><span class="badge badge-secondary">{{ $solde->jours_reportes }}</span></td>
                            <td>{{ \Carbon\Carbon::parse($solde->date_debut_periode)->format('d/m/Y') }} - {{ \Carbon\Carbon::parse($solde->date_fin_periode)->format('d/m/Y') }}</td>
                        </tr>
                    @empty
                        <tr><td colspan="6" class="text-center text-muted">Aucun solde</td></tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>
@endsection
