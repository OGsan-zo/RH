@extends('layouts.adminlte')

@section('title', 'Liste des annonces')
@section('page-title', 'Annonces')

@section('breadcrumb')
    <li class="breadcrumb-item"><a href="{{ route('rh.dashboard') }}">Dashboard</a></li>
    <li class="breadcrumb-item active">Annonces</li>
@endsection

@section('sidebar')
    @include('layouts.partials.sidebar-rh')
@endsection

@section('content')
    <div class="row">
        <div class="col-12">
            <div class="card">
                <div class="card-header">
                    <h3 class="card-title"><i class="fas fa-bullhorn mr-2"></i>Gestion des Annonces</h3>
                    <div class="card-tools">
                        <a href="{{ route('annonces.create') }}" class="btn btn-primary btn-sm">
                            <i class="fas fa-plus"></i> Nouvelle annonce
                        </a>
                    </div>
                </div>
                <div class="card-body">
                    @if(session('success'))
                        <div class="alert alert-success alert-dismissible fade show" role="alert">
                            <i class="fas fa-check-circle"></i> {{ session('success') }}
                            <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                                <span aria-hidden="true">&times;</span>
                            </button>
                        </div>
                    @endif

                    <div class="table-responsive">
                        <table class="table table-bordered table-striped table-hover">
                            <thead class="thead-light">
                                <tr>
                                    <th style="width: 60px">ID</th>
                                    <th>Département</th>
                                    <th>Titre du Poste</th>
                                    <th style="width: 120px">Date Limite</th>
                                    <th style="width: 100px" class="text-center">Statut</th>
                                    <th style="width: 220px" class="text-center">Actions</th>
                                </tr>
                            </thead>
                            <tbody>
                                @forelse($annonces as $a)
                                <tr>
                                    <td><span class="badge badge-info">{{ $a->id }}</span></td>
                                    <td><i class="fas fa-building text-muted mr-1"></i>{{ $a->departement->nom ?? '-' }}</td>
                                    <td><strong>{{ $a->titre }}</strong></td>
                                    <td>
                                        @if($a->date_limite)
                                            <i class="far fa-calendar text-muted mr-1"></i>{{ \Carbon\Carbon::parse($a->date_limite)->format('d/m/Y') }}
                                        @else
                                            <span class="text-muted">—</span>
                                        @endif
                                    </td>
                                    <td class="text-center">
                                        @if($a->statut === 'ouverte')
                                            <span class="badge badge-success"><i class="fas fa-check-circle"></i> Ouverte</span>
                                        @else
                                            <span class="badge badge-secondary"><i class="fas fa-lock"></i> Fermée</span>
                                        @endif
                                    </td>
                                    <td class="text-center">
                                        <a href="{{ route('annonces.edit', $a->id) }}" class="btn btn-warning btn-sm" title="Modifier">
                                            <i class="fas fa-edit"></i>
                                        </a>
                                        <a href="{{ route('annonces.delete', $a->id) }}" 
                                           class="btn btn-danger btn-sm" 
                                           title="Supprimer"
                                           onclick="return confirm('Êtes-vous sûr de vouloir supprimer cette annonce ?')">
                                            <i class="fas fa-trash"></i>
                                        </a>
                                        @if($a->statut === 'ouverte')
                                            <a href="{{ route('annonces.close', $a->id) }}" 
                                               class="btn btn-secondary btn-sm" 
                                               title="Fermer l'annonce"
                                               onclick="return confirm('Voulez-vous fermer cette annonce ?')">
                                                <i class="fas fa-lock"></i>
                                            </a>
                                        @endif
                                    </td>
                                </tr>
                                @empty
                                <tr>
                                    <td colspan="6" class="text-center text-muted">
                                        <i class="fas fa-info-circle"></i> Aucune annonce enregistrée
                                    </td>
                                </tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
