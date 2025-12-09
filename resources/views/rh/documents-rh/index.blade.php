@extends('layouts.adminlte')

@section('title', 'Documents RH')
@section('page-title', 'Documents RH')

@section('breadcrumb')
    <li class="breadcrumb-item active">Documents RH</li>
@endsection

@section('sidebar')
    @include('layouts.partials.sidebar-rh')
@endsection

@section('content')
    <div class="card">
        <div class="card-header">
            <h3 class="card-title">Gestion des Documents RH</h3>
            <div class="card-tools">
                <a href="{{ route('documents-rh.create') }}" class="btn btn-primary btn-sm">
                    <i class="fas fa-plus"></i> Ajouter Document
                </a>
            </div>
        </div>
        <div class="card-body">
            @if($documents->isEmpty())
                <div class="alert alert-info">
                    <i class="fas fa-info-circle"></i> Aucun document enregistré.
                </div>
            @else
                <div class="table-responsive">
                    <table class="table table-striped table-hover">
                        <thead>
                            <tr>
                                <th>Employé</th>
                                <th>Type</th>
                                <th>Nom Fichier</th>
                                <th>Date Émission</th>
                                <th>Date Expiration</th>
                                <th>Valide</th>
                                <th>Actions</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($documents as $document)
                                <tr>
                                    <td><strong>{{ $document->employe->candidat->nom ?? 'N/A' }}</strong></td>
                                    <td><span class="badge badge-primary">{{ $document->typeDocument->libelle ?? '-' }}</span></td>
                                    <td>{{ $document->nom_fichier }}</td>
                                    <td>{{ $document->date_emission ? \Carbon\Carbon::parse($document->date_emission)->format('d/m/Y') : '-' }}</td>
                                    <td>{{ $document->date_expiration ? \Carbon\Carbon::parse($document->date_expiration)->format('d/m/Y') : '-' }}</td>
                                    <td>
                                        @if($document->valide)
                                            <span class="badge badge-success">Valide</span>
                                        @else
                                            <span class="badge badge-danger">Invalide</span>
                                        @endif
                                    </td>
                                    <td>
                                        <a href="{{ route('documents-rh.edit', $document->id) }}" class="btn btn-warning btn-xs">
                                            <i class="fas fa-edit"></i>
                                        </a>
                                        <a href="{{ route('documents-rh.delete', $document->id) }}" class="btn btn-danger btn-xs" onclick="return confirm('Êtes-vous sûr ?')">
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
