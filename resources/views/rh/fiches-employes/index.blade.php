@extends('layouts.adminlte')

@section('title', 'Fiches Employés')
@section('page-title', 'Fiches Employés')

@section('breadcrumb')
    <li class="breadcrumb-item active">Fiches Employés</li>
@endsection

@section('sidebar')
    @include('layouts.partials.sidebar-rh')
@endsection

@section('content')
    <div class="card">
        <div class="card-header">
            <h3 class="card-title">Liste des Fiches Employés</h3>
            <div class="card-tools">
                <a href="{{ route('fiches-employes.create') }}" class="btn btn-primary btn-sm">
                    <i class="fas fa-plus"></i> Nouvelle Fiche
                </a>
            </div>
        </div>
        <div class="card-body">
            @if($fiches->isEmpty())
                <div class="alert alert-info">
                    <i class="fas fa-info-circle"></i> Aucune fiche employé trouvée.
                </div>
            @else
                <div class="table-responsive">
                    <table class="table table-striped table-hover">
                        <thead>
                            <tr>
                                <th>Employé</th>
                                <th>CIN</th>
                                <th>Poste</th>
                                <th>Téléphone</th>
                                <th>Ville</th>
                                <th>Date d'Embauche</th>
                                <th>Actions</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($fiches as $fiche)
                                <tr>
                                    <td>
                                        <strong>{{ $fiche->employe->candidat->nom ?? 'N/A' }} {{ $fiche->employe->candidat->prenom ?? '' }}</strong>
                                    </td>
                                    <td>{{ $fiche->cin ?? '-' }}</td>
                                    <td>{{ $fiche->poste->titre ?? '-' }}</td>
                                    <td>{{ $fiche->telephone ?? '-' }}</td>
                                    <td>{{ $fiche->ville ?? '-' }}</td>
                                    <td>
                                        @if($fiche->date_embauche)
                                            {{ \Carbon\Carbon::parse($fiche->date_embauche)->format('d/m/Y') }}
                                        @else
                                            -
                                        @endif
                                    </td>
                                    <td>
                                        <a href="{{ route('fiches-employes.show', $fiche->id) }}" class="btn btn-info btn-xs">
                                            <i class="fas fa-eye"></i>
                                        </a>
                                        <a href="{{ route('fiches-employes.edit', $fiche->id) }}" class="btn btn-warning btn-xs">
                                            <i class="fas fa-edit"></i>
                                        </a>
                                        <a href="{{ route('fiches-employes.delete', $fiche->id) }}" class="btn btn-danger btn-xs" onclick="return confirm('Êtes-vous sûr ?')">
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
