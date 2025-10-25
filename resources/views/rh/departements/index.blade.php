@extends('layouts.adminlte')

@section('title', 'Liste des départements')
@section('page-title', 'Départements')

@section('breadcrumb')
    <li class="breadcrumb-item"><a href="{{ route('rh.dashboard') }}">Dashboard</a></li>
    <li class="breadcrumb-item active">Départements</li>
@endsection

@section('sidebar')
    @include('layouts.partials.sidebar-rh')
@endsection

@section('content')
    <div class="row">
        <div class="col-12">
            <div class="card">
                <div class="card-header">
                    <h3 class="card-title"><i class="fas fa-building mr-2"></i>Liste des Départements</h3>
                    <div class="card-tools">
                        <a href="{{ route('departements.create') }}" class="btn btn-primary btn-sm">
                            <i class="fas fa-plus"></i> Nouveau département
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
                                    <th style="width: 80px">ID</th>
                                    <th>Nom du Département</th>
                                    <th style="width: 200px" class="text-center">Actions</th>
                                </tr>
                            </thead>
                            <tbody>
                                @forelse($departements as $dep)
                                <tr>
                                    <td><span class="badge badge-info">{{ $dep->id }}</span></td>
                                    <td><strong>{{ $dep->nom }}</strong></td>
                                    <td class="text-center">
                                        <a href="{{ route('departements.edit', $dep->id) }}" class="btn btn-warning btn-sm" title="Modifier">
                                            <i class="fas fa-edit"></i>
                                        </a>
                                        <a href="{{ route('departements.delete', $dep->id) }}" 
                                           class="btn btn-danger btn-sm" 
                                           title="Supprimer"
                                           onclick="return confirm('Êtes-vous sûr de vouloir supprimer ce département ?')">
                                            <i class="fas fa-trash"></i>
                                        </a>
                                    </td>
                                </tr>
                                @empty
                                <tr>
                                    <td colspan="3" class="text-center text-muted">
                                        <i class="fas fa-info-circle"></i> Aucun département enregistré
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
