@extends('layouts.adminlte')

@section('title', 'Historique des Postes')
@section('page-title', 'Historique des Postes')

@section('breadcrumb')
    <li class="breadcrumb-item active">Historique des Postes</li>
@endsection

@section('sidebar')
    @include('layouts.partials.sidebar-rh')
@endsection

@section('content')
    <div class="card">
        <div class="card-header">
            <h3 class="card-title">Historique des Postes</h3>
            <div class="card-tools">
                <a href="{{ route('historique-postes.create') }}" class="btn btn-primary btn-sm">
                    <i class="fas fa-plus"></i> Ajouter
                </a>
            </div>
        </div>
        <div class="card-body">
            @if($historiques->isEmpty())
                <div class="alert alert-info">
                    <i class="fas fa-info-circle"></i> Aucun historique trouvé.
                </div>
            @else
                <div class="table-responsive">
                    <table class="table table-striped table-hover">
                        <thead>
                            <tr>
                                <th>Employé</th>
                                <th>Poste</th>
                                <th>Type</th>
                                <th>Date Début</th>
                                <th>Date Fin</th>
                                <th>Salaire</th>
                                <th>Actions</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($historiques as $historique)
                                <tr>
                                    <td><strong>{{ $historique->employe->candidat->nom ?? 'N/A' }}</strong></td>
                                    <td>{{ $historique->poste->titre ?? $historique->titre_poste ?? '-' }}</td>
                                    <td>
                                        <span class="badge badge-info">{{ ucfirst($historique->typeMouvement->libelle ?? '-') }}</span>
                                    </td>
                                    <td>{{ \Carbon\Carbon::parse($historique->date_debut)->format('d/m/Y') }}</td>
                                    <td>{{ $historique->date_fin ? \Carbon\Carbon::parse($historique->date_fin)->format('d/m/Y') : '-' }}</td>
                                    <td>{{ $historique->salaire ? number_format($historique->salaire, 2) . ' €' : '-' }}</td>
                                    <td>
                                        <a href="{{ route('historique-postes.edit', $historique->id) }}" class="btn btn-warning btn-xs">
                                            <i class="fas fa-edit"></i>
                                        </a>
                                        <a href="{{ route('historique-postes.delete', $historique->id) }}" class="btn btn-danger btn-xs" onclick="return confirm('Êtes-vous sûr ?')">
                                            <i class="fas fa-trash"></i>
                                        </a>
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            @endif
        </div>
    </div>
@endsection
