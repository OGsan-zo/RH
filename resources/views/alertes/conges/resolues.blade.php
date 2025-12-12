@extends('layouts.adminlte')

@section('title', 'Alertes Résolues - Congés')
@section('page-title', 'Alertes Résolues de Congés')

@section('breadcrumb')
    <li class="breadcrumb-item"><a href="{{ route('alertes-conges.index') }}">Alertes</a></li>
    <li class="breadcrumb-item active">Résolues</li>
@endsection

@section('sidebar')
    @include('layouts.partials.sidebar-rh')
@endsection

@section('content')
<div class="card">
    <div class="card-header bg-success text-white">
        <h3 class="card-title">✅ Alertes Résolues</h3>
        <div class="card-tools">
            <a href="{{ route('alertes-conges.index') }}" class="btn btn-sm btn-warning">
                <i class="fas fa-exclamation-triangle"></i> Voir les alertes actives
            </a>
        </div>
    </div>
    <div class="card-body">
        @if($alertes->count() > 0)
            <div class="table-responsive">
                <table class="table table-striped table-hover">
                    <thead class="table-light">
                        <tr>
                            <th>Type d'Alerte</th>
                            <th>Employé</th>
                            <th>Message</th>
                            <th>Créée</th>
                            <th>Résolue</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($alertes as $alerte)
                            <tr>
                                <td>
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
                                </td>
                                <td>{{ $alerte->employe->candidat->nom ?? 'N/A' }} {{ $alerte->employe->candidat->prenom ?? '' }}</td>
                                <td>{{ $alerte->message }}</td>
                                <td>{{ $alerte->date_creation->format('d/m/Y H:i') }}</td>
                                <td>{{ $alerte->date_resolution->format('d/m/Y H:i') }}</td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>

            <div class="mt-3">
                {{ $alertes->links() }}
            </div>
        @else
            <div class="alert alert-info">
                <i class="fas fa-info-circle"></i> Aucune alerte résolue pour le moment.
            </div>
        @endif
    </div>
</div>
@endsection
