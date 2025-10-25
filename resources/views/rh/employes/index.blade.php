@extends('layouts.adminlte')

@section('title', 'Employés')

@section('breadcrumb')
<ol class="breadcrumb float-sm-right">
    <li class="breadcrumb-item"><a href="{{ route('rh.dashboard') }}">Accueil</a></li>
    <li class="breadcrumb-item active">Employés</li>
</ol>
@endsection

@section('sidebar')
    @include('layouts.partials.sidebar-rh')
@endsection

@section('content')
    <div class="row">
        <div class="col-12">
            <!-- Info Box -->
            <div class="info-box bg-info">
                <span class="info-box-icon"><i class="fas fa-users"></i></span>
                <div class="info-box-content">
                    <span class="info-box-text">Total Employés Actifs</span>
                    <span class="info-box-number">{{ $employes->count() }}</span>
                </div>
            </div>
        </div>
    </div>

    <div class="row">
        <div class="col-12">
            <div class="card card-primary">
                <div class="card-header">
                    <h3 class="card-title"><i class="fas fa-users mr-2"></i>Liste des Employés Actifs</h3>
                </div>
                <div class="card-body">
                    @include('layouts.alerts')
                    
                    @if($employes->isEmpty())
                        <div class="alert alert-info">
                            <i class="fas fa-info-circle mr-2"></i>
                            Aucun employé enregistré.
                        </div>
                    @else
                        <div class="table-responsive">
                            <table class="table table-bordered table-striped table-hover">
                                <thead class="thead-light">
                                    <tr>
                                        <th><i class="fas fa-id-card mr-1"></i>Matricule</th>
                                        <th><i class="fas fa-user mr-1"></i>Nom Complet</th>
                                        <th><i class="fas fa-briefcase mr-1"></i>Poste</th>
                                        <th><i class="fas fa-calendar-check mr-1"></i>Date Embauche</th>
                                        <th><i class="fas fa-check-circle mr-1"></i>Statut</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach($employes as $e)
                                    <tr>
                                        <td><strong>{{ $e->matricule }}</strong></td>
                                        <td>{{ $e->candidat->nom }} {{ $e->candidat->prenom }}</td>
                                        <td>{{ $e->contrat->candidature->annonce->titre }}</td>
                                        <td>{{ \Carbon\Carbon::parse($e->date_embauche)->format('d/m/Y') }}</td>
                                        <td>
                                            @if($e->statut == 'actif')
                                                <span class="badge badge-success">
                                                    <i class="fas fa-check mr-1"></i>{{ ucfirst($e->statut) }}
                                                </span>
                                            @elseif($e->statut == 'suspendu')
                                                <span class="badge badge-warning">
                                                    <i class="fas fa-pause mr-1"></i>{{ ucfirst($e->statut) }}
                                                </span>
                                            @else
                                                <span class="badge badge-danger">
                                                    <i class="fas fa-times mr-1"></i>{{ ucfirst($e->statut) }}
                                                </span>
                                            @endif
                                        </td>
                                    </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                    @endif
                </div>
            </div>
        </div>
    </div>
@endsection
