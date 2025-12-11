@extends('layouts.adminlte')

@section('title', 'Demandes de Congés')
@section('page-title', 'Demandes de Congés')

@section('breadcrumb')
    <li class="breadcrumb-item active">Demandes de Congés</li>
@endsection

@section('sidebar')
    @include('layouts.partials.sidebar-rh')
@endsection

@section('content')
<div class="card">
    <div class="row mb-4">
        <div class="col-md-8">
            <h1 class="h3">Demandes de Congés</h1>
        </div>
        <div class="col-md-4 text-right">
            <a href="{{ route('demandes-conges.create') }}" class="btn btn-primary">
                <i class="fas fa-plus"></i> Nouvelle Demande
            </a>
        </div>
    </div>

    @if(session('success'))
        <div class="alert alert-success alert-dismissible fade show" role="alert">
            {{ session('success') }}
            <button type="button" class="close" data-dismiss="alert"><span>&times;</span></button>
        </div>
    @endif

    <div class="card-header">
        <h3 class="card-title">Liste des Demandes</h3>
    </div>
    <div class="card-body">
            <div class="table-responsive">
                <table class="table table-hover">
                    <thead class="table-light">
                        <tr>
                            <th>Employé</th>
                            <th>Type de Congé</th>
                            <th>Dates</th>
                            <th>Jours</th>
                            <th>Statut</th>
                            <th>Validateur</th>
                            <th>Actions</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($demandes as $demande)
                            <tr>
                                <td>
                                    <strong>{{ $demande->employe->nom ?? 'N/A' }}</strong>
                                </td>
                                <td>{{ $demande->typeCongé->nom ?? 'N/A' }}</td>
                                <td>
                                    {{ \Carbon\Carbon::parse($demande->date_debut)->format('d/m/Y') }} 
                                    à 
                                    {{ \Carbon\Carbon::parse($demande->date_fin)->format('d/m/Y') }}
                                </td>
                                <td>
                                    <span class="badge badge-info">{{ $demande->nombre_jours }}</span>
                                </td>
                                <td>
                                    @if($demande->estEnAttente())
                                        <span class="badge badge-warning">En attente</span>
                                    @elseif($demande->estApprouvee())
                                        <span class="badge badge-success">Approuvée</span>
                                    @elseif($demande->estRejetee())
                                        <span class="badge badge-danger">Rejetée</span>
                                    @else
                                        <span class="badge badge-secondary">Annulée</span>
                                    @endif
                                </td>
                                <td>{{ $demande->validateur->name ?? '-' }}</td>
                                <td>
                                    <a href="{{ route('demandes-conges.show', $demande->id) }}" class="btn btn-sm btn-info">
                                        <i class="fas fa-eye"></i>
                                    </a>
                                    @if($demande->estEnAttente())
                                        <a href="{{ route('demandes-conges.edit', $demande->id) }}" class="btn btn-sm btn-warning">
                                            <i class="fas fa-edit"></i>
                                        </a>
                                    @endif
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="7" class="text-center text-muted">Aucune demande de congé</td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>

            {{ $demandes->links() }}
        </div>
    </div>
@endsection
