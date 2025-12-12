@extends('layouts.adminlte')

@section('title', 'Historique des Congés')
@section('page-title', 'Historique des Congés')

@section('breadcrumb')
    <li class="breadcrumb-item active">Historique des Congés</li>
@endsection

@section('sidebar')
    @include('layouts.partials.sidebar-rh')
@endsection

@section('content')
<div class="card">
    <div class="card-header">
        <h3 class="card-title">Liste de l'Historique</h3>
    </div>
        <div class="card-body">
            <table class="table table-hover">
                <thead class="table-light">
                    <tr>
                        <th>Employé</th>
                        <th>Type de Congé</th>
                        <th>Dates</th>
                        <th>Jours</th>
                        <th>Validateur</th>
                        <th>Date d'Enregistrement</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($historiques as $historique)
                        <tr>
                            <td>{{ $historique->employe->candidat->nom ?? 'N/A' }} {{ $historique->employe->candidat->prenom ?? '' }}</td>
                            <td>{{ $historique->typeCongé->nom ?? 'N/A' }}</td>
                            <td>{{ \Carbon\Carbon::parse($historique->date_debut)->format('d/m/Y') }} - {{ \Carbon\Carbon::parse($historique->date_fin)->format('d/m/Y') }}</td>
                            <td><span class="badge badge-info">{{ $historique->nombre_jours_pris }}</span></td>
                            <td>{{ $historique->validateur->name ?? '-' }}</td>
                            <td>{{ \Carbon\Carbon::parse($historique->date_enregistrement)->format('d/m/Y H:i') }}</td>
                        </tr>
                    @empty
                        <tr><td colspan="6" class="text-center text-muted">Aucun historique</td></tr>
                    @endforelse
                </tbody>
            </table>
            {{ $historiques->links() }}
        </div>
    </div>
@endsection
