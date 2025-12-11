@extends('layouts.adminlte')

@section('title', 'Soldes de Congés')
@section('page-title', 'Soldes de Congés')

@section('breadcrumb')
    <li class="breadcrumb-item active">Soldes de Congés</li>
@endsection

@section('sidebar')
    @include('layouts.partials.sidebar-rh')
@endsection

@section('content')
<div class="card">
    <div class="card-header">
        <h3 class="card-title">Liste des Soldes</h3>
    </div>
        <div class="card-body">
            <table class="table table-hover">
                <thead class="table-light">
                    <tr>
                        <th>Employé</th>
                        <th>Type de Congé</th>
                        <th>Acquis</th>
                        <th>Utilisés</th>
                        <th>Restants</th>
                        <th>Période</th>
                        <th>Actions</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($soldes as $solde)
                        <tr>
                            <td>{{ $solde->employe->nom ?? 'N/A' }}</td>
                            <td>{{ $solde->typeCongé->nom ?? 'N/A' }}</td>
                            <td><span class="badge badge-info">{{ $solde->jours_acquis }}</span></td>
                            <td><span class="badge badge-warning">{{ $solde->jours_utilises }}</span></td>
                            <td><span class="badge badge-success">{{ $solde->jours_restants }}</span></td>
                            <td>{{ \Carbon\Carbon::parse($solde->date_debut_periode)->format('d/m/Y') }} - {{ \Carbon\Carbon::parse($solde->date_fin_periode)->format('d/m/Y') }}</td>
                            <td>
                                <a href="{{ route('soldes-conges.show', $solde->employe_id) }}" class="btn btn-sm btn-info">
                                    <i class="fas fa-eye"></i>
                                </a>
                            </td>
                        </tr>
                    @empty
                        <tr><td colspan="7" class="text-center text-muted">Aucun solde</td></tr>
                    @endforelse
                </tbody>
            </table>
            {{ $soldes->links() }}
        </div>
    </div>
@endsection
