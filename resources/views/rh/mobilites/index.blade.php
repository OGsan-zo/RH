@extends('layouts.adminlte')

@section('title', 'Mobilités')
@section('page-title', 'Mobilités')

@section('breadcrumb')
    <li class="breadcrumb-item active">Mobilités</li>
@endsection

@section('sidebar')
    @include('layouts.partials.sidebar-rh')
@endsection

@section('content')
    <div class="card">
        <div class="card-header">
            <h3 class="card-title">Gestion des Mobilités</h3>
            <div class="card-tools">
                <a href="{{ route('mobilites.create') }}" class="btn btn-primary btn-sm">
                    <i class="fas fa-plus"></i> Nouvelle Mobilité
                </a>
            </div>
        </div>
        <div class="card-body">
            @if($mobilites->isEmpty())
                <div class="alert alert-info">
                    <i class="fas fa-info-circle"></i> Aucune mobilité enregistrée.
                </div>
            @else
                <div class="table-responsive">
                    <table class="table table-striped table-hover">
                        <thead>
                            <tr>
                                <th>Employé</th>
                                <th>Type</th>
                                <th>Statut</th>
                                <th>Date Demande</th>
                                <th>Date Effet</th>
                                <th>Actions</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($mobilites as $mobilite)
                                <tr>
                                    <td><strong>{{ $mobilite->employe->candidat->nom ?? 'N/A' }}</strong></td>
                                    <td><span class="badge badge-info">{{ ucfirst($mobilite->typeMobilite->libelle ?? '-') }}</span></td>
                                    <td>
                                        @php
                                            $badgeClass = match($mobilite->statut->libelle ?? '') {
                                                'en_attente' => 'warning',
                                                'approuvee' => 'success',
                                                'rejetee' => 'danger',
                                                default => 'secondary'
                                            };
                                        @endphp
                                        <span class="badge badge-{{ $badgeClass }}">{{ ucfirst($mobilite->statut->libelle ?? '-') }}</span>
                                    </td>
                                    <td>{{ \Carbon\Carbon::parse($mobilite->date_demande)->format('d/m/Y') }}</td>
                                    <td>{{ \Carbon\Carbon::parse($mobilite->date_effet)->format('d/m/Y') }}</td>
                                    <td>
                                        <a href="{{ route('mobilites.edit', $mobilite->id) }}" class="btn btn-warning btn-xs">
                                            <i class="fas fa-edit"></i>
                                        </a>
                                        <a href="{{ route('mobilites.delete', $mobilite->id) }}" class="btn btn-danger btn-xs" onclick="return confirm('Êtes-vous sûr ?')">
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
