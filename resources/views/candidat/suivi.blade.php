@extends('layouts.adminlte')

@section('title', 'Suivi de candidature')

@section('breadcrumb')
<ol class="breadcrumb float-sm-right">
    <li class="breadcrumb-item"><a href="{{ route('candidat.dashboard') }}">Accueil</a></li>
    <li class="breadcrumb-item active">Mes Candidatures</li>
</ol>
@endsection

@section('sidebar')
    @include('layouts.partials.sidebar-candidat')
@endsection

@section('content')
    @include('layouts.alerts')

    <div class="row">
        <div class="col-12">
            <div class="card card-success">
                <div class="card-header">
                    <h3 class="card-title"><i class="fas fa-tasks mr-2"></i>Suivi de Vos Candidatures</h3>
                    <div class="card-tools">
                        <span class="badge badge-light">{{ count($candidatures) }} candidature(s)</span>
                    </div>
                </div>
                <div class="card-body">
                    @if(count($candidatures) == 0)
                        <div class="alert alert-info">
                            <i class="fas fa-info-circle mr-2"></i>
                            Aucune candidature enregistrée pour l'instant.
                        </div>
                        <a href="{{ route('candidatures.index') }}" class="btn btn-primary">
                            <i class="fas fa-briefcase mr-2"></i>Voir les annonces disponibles
                        </a>
                    @else
                        @foreach($candidatures as $c)
                        <div class="card {{ $c->statut == 'retenu' ? 'card-success' : ($c->statut == 'refuse' ? 'card-danger' : 'card-default') }} card-outline">
                            <div class="card-header">
                                <h3 class="card-title">
                                    <i class="fas fa-briefcase mr-2"></i>
                                    <strong>{{ $c->annonce->titre ?? 'Annonce supprimée' }}</strong>
                                </h3>
                                <div class="card-tools">
                                    @if($c->statut == 'en_attente')
                                        <span class="badge badge-secondary">
                                            <i class="fas fa-clock mr-1"></i>En attente
                                        </span>
                                    @elseif($c->statut == 'test_en_cours')
                                        <span class="badge badge-info">
                                            <i class="fas fa-clipboard-check mr-1"></i>Test en cours
                                        </span>
                                    @elseif($c->statut == 'en_entretien')
                                        <span class="badge badge-warning">
                                            <i class="fas fa-calendar-alt mr-1"></i>En entretien
                                        </span>
                                    @elseif($c->statut == 'retenu')
                                        <span class="badge badge-success">
                                            <i class="fas fa-check-circle mr-1"></i>Retenu
                                        </span>
                                    @elseif($c->statut == 'refuse')
                                        <span class="badge badge-danger">
                                            <i class="fas fa-times-circle mr-1"></i>Refusé
                                        </span>
                                    @elseif($c->statut == 'employe')
                                        <span class="badge badge-primary">
                                            <i class="fas fa-user-tie mr-1"></i>Employé
                                        </span>
                                    @else
                                        <span class="badge badge-light">{{ str_replace('_', ' ', $c->statut) }}</span>
                                    @endif
                                </div>
                            </div>
                            <div class="card-body">
                                <div class="row">
                                    <div class="col-md-6">
                                        <p class="mb-2">
                                            <i class="fas fa-building mr-2 text-primary"></i>
                                            <strong>Département :</strong> {{ $c->annonce->departement->nom ?? '-' }}
                                        </p>
                                        <p class="mb-2">
                                            <i class="fas fa-calendar mr-2 text-info"></i>
                                            <strong>Date de candidature :</strong> {{ \Carbon\Carbon::parse($c->date_candidature)->format('d/m/Y') }}
                                        </p>
                                    </div>
                                    <div class="col-md-6">
                                        <!-- Timeline du statut -->
                                        <div class="progress-group">
                                            <span class="progress-text">Progression</span>
                                            <span class="float-right">
                                                @if($c->statut == 'en_attente') 20%
                                                @elseif($c->statut == 'test_en_cours') 40%
                                                @elseif($c->statut == 'en_entretien') 60%
                                                @elseif($c->statut == 'retenu') 80%
                                                @elseif($c->statut == 'employe') 100%
                                                @else 0%
                                                @endif
                                            </span>
                                            <div class="progress progress-sm">
                                                <div class="progress-bar 
                                                    @if($c->statut == 'retenu' || $c->statut == 'employe') bg-success
                                                    @elseif($c->statut == 'refuse') bg-danger
                                                    @elseif($c->statut == 'en_entretien') bg-warning
                                                    @else bg-info
                                                    @endif" 
                                                    style="width: 
                                                        @if($c->statut == 'en_attente') 20%
                                                        @elseif($c->statut == 'test_en_cours') 40%
                                                        @elseif($c->statut == 'en_entretien') 60%
                                                        @elseif($c->statut == 'retenu') 80%
                                                        @elseif($c->statut == 'employe') 100%
                                                        @else 0%
                                                        @endif">
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>

                                @if($c->statut == 'retenu')
                                <div class="callout callout-success mt-3">
                                    <h5><i class="fas fa-check mr-2"></i>Félicitations !</h5>
                                    <p>Votre candidature a été retenue. Vous serez contacté prochainement pour la suite du processus.</p>
                                </div>
                                @elseif($c->statut == 'refuse')
                                <div class="callout callout-danger mt-3">
                                    <h5><i class="fas fa-times mr-2"></i>Candidature non retenue</h5>
                                    <p>Malheureusement, votre candidature n'a pas été retenue pour ce poste. N'hésitez pas à postuler à d'autres offres.</p>
                                </div>
                                @endif
                            </div>
                        </div>
                        @endforeach
                    @endif
                </div>
            </div>
        </div>
    </div>
@endsection
