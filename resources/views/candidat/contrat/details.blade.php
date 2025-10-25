@extends('layouts.adminlte')

@section('title', 'Mon contrat')

@section('breadcrumb')
<ol class="breadcrumb float-sm-right">
    <li class="breadcrumb-item"><a href="{{ route('candidat.dashboard') }}">Accueil</a></li>
    <li class="breadcrumb-item active">Mon Contrat</li>
</ol>
@endsection

@section('sidebar')
    @include('layouts.partials.sidebar-candidat')
@endsection

@section('content')
    @include('layouts.alerts')

    <div class="row">
        <div class="col-12">
            @if(!$contrat)
                <div class="card card-info">
                    <div class="card-header">
                        <h3 class="card-title"><i class="fas fa-file-contract mr-2"></i>Mon Contrat</h3>
                    </div>
                    <div class="card-body">
                        <div class="alert alert-info">
                            <i class="fas fa-info-circle mr-2"></i>
                            Aucun contrat n'est encore disponible.
                        </div>
                        <a href="{{ route('candidatures.suivi') }}" class="btn btn-primary">
                            <i class="fas fa-tasks mr-2"></i>Voir mes candidatures
                        </a>
                    </div>
                </div>
            @else
                <div class="row">
                    <!-- Détails du contrat -->
                    <div class="col-md-8">
                        <div class="card card-primary">
                            <div class="card-header">
                                <h3 class="card-title">
                                    <i class="fas fa-file-contract mr-2"></i>
                                    Contrat {{ strtoupper($contrat->type_contrat) }}
                                </h3>
                                <div class="card-tools">
                                    @if($contrat->statut === 'actif')
                                        <span class="badge badge-success">
                                            <i class="fas fa-check-circle mr-1"></i>Actif
                                        </span>
                                    @elseif($contrat->statut === 'termine')
                                        <span class="badge badge-danger">
                                            <i class="fas fa-times-circle mr-1"></i>Terminé
                                        </span>
                                    @else
                                        <span class="badge badge-secondary">{{ ucfirst($contrat->statut) }}</span>
                                    @endif
                                </div>
                            </div>
                            <div class="card-body">
                                <dl class="row">
                                    <dt class="col-sm-4"><i class="fas fa-briefcase mr-2 text-primary"></i>Poste :</dt>
                                    <dd class="col-sm-8">
                                        <strong>{{ $contrat->candidature->annonce->titre }}</strong>
                                    </dd>

                                    <dt class="col-sm-4"><i class="fas fa-building mr-2 text-info"></i>Département :</dt>
                                    <dd class="col-sm-8">{{ $contrat->candidature->annonce->departement->nom ?? '-' }}</dd>

                                    <dt class="col-sm-4"><i class="fas fa-file-alt mr-2 text-warning"></i>Type de contrat :</dt>
                                    <dd class="col-sm-8">
                                        <span class="badge badge-warning">{{ strtoupper($contrat->type_contrat) }}</span>
                                    </dd>

                                    <dt class="col-sm-4"><i class="fas fa-calendar-check mr-2 text-success"></i>Date de début :</dt>
                                    <dd class="col-sm-8">{{ \Carbon\Carbon::parse($contrat->date_debut)->format('d/m/Y') }}</dd>

                                    <dt class="col-sm-4"><i class="fas fa-calendar-times mr-2 text-danger"></i>Date de fin :</dt>
                                    <dd class="col-sm-8">
                                        @if($contrat->date_fin)
                                            {{ \Carbon\Carbon::parse($contrat->date_fin)->format('d/m/Y') }}
                                        @else
                                            <span class="badge badge-secondary">Indéterminée</span>
                                        @endif
                                    </dd>

                                    <dt class="col-sm-4"><i class="fas fa-money-bill-wave mr-2 text-success"></i>Salaire :</dt>
                                    <dd class="col-sm-8">
                                        <strong class="text-success">{{ number_format($contrat->salaire, 0, ',', ' ') }} Ar</strong>
                                    </dd>

                                    <dt class="col-sm-4"><i class="fas fa-info-circle mr-2"></i>Statut :</dt>
                                    <dd class="col-sm-8">
                                        @if($contrat->statut === 'actif')
                                            <span class="badge badge-success">
                                                <i class="fas fa-check mr-1"></i>Actif
                                            </span>
                                        @elseif($contrat->statut === 'termine')
                                            <span class="badge badge-danger">
                                                <i class="fas fa-times mr-1"></i>Terminé
                                            </span>
                                        @else
                                            <span class="badge badge-secondary">{{ ucfirst($contrat->statut) }}</span>
                                        @endif
                                    </dd>
                                </dl>

                                @if($contrat->type_contrat === 'essai' && $contrat->statut === 'actif')
                                <hr>
                                <div class="callout callout-warning">
                                    <h5><i class="fas fa-exclamation-triangle"></i> Contrat d'essai</h5>
                                    <p>Vous êtes actuellement en période d'essai. Vous pouvez notifier la fin de votre contrat si nécessaire.</p>
                                </div>
                                <a href="{{ route('contrat.fin', $contrat->id) }}" 
                                   class="btn btn-danger btn-block"
                                   onclick="return confirm('Êtes-vous sûr de vouloir notifier la fin de votre contrat d\'essai ?')">
                                    <i class="fas fa-times-circle mr-2"></i>Notifier fin d'essai
                                </a>
                                @endif
                            </div>
                        </div>
                    </div>

                    <!-- Informations complémentaires -->
                    <div class="col-md-4">
                        <!-- Statut -->
                        <div class="info-box {{ $contrat->statut === 'actif' ? 'bg-success' : 'bg-danger' }}">
                            <span class="info-box-icon">
                                <i class="fas {{ $contrat->statut === 'actif' ? 'fa-check-circle' : 'fa-times-circle' }}"></i>
                            </span>
                            <div class="info-box-content">
                                <span class="info-box-text">Statut du Contrat</span>
                                <span class="info-box-number">{{ ucfirst($contrat->statut) }}</span>
                            </div>
                        </div>

                        <!-- Type de contrat -->
                        <div class="info-box bg-warning">
                            <span class="info-box-icon"><i class="fas fa-file-alt"></i></span>
                            <div class="info-box-content">
                                <span class="info-box-text">Type</span>
                                <span class="info-box-number">{{ strtoupper($contrat->type_contrat) }}</span>
                            </div>
                        </div>

                        <!-- Salaire -->
                        <div class="info-box bg-success">
                            <span class="info-box-icon"><i class="fas fa-money-bill-wave"></i></span>
                            <div class="info-box-content">
                                <span class="info-box-text">Salaire Mensuel</span>
                                <span class="info-box-number">{{ number_format($contrat->salaire / 1000, 0) }}K Ar</span>
                            </div>
                        </div>

                        <!-- Informations -->
                        <div class="card card-info">
                            <div class="card-header">
                                <h3 class="card-title"><i class="fas fa-info-circle mr-2"></i>Informations</h3>
                            </div>
                            <div class="card-body">
                                <p><strong>Date de signature :</strong></p>
                                <p>{{ \Carbon\Carbon::parse($contrat->created_at)->format('d/m/Y') }}</p>
                                
                                @if($contrat->date_fin)
                                <p><strong>Durée :</strong></p>
                                <p>
                                    {{ \Carbon\Carbon::parse($contrat->date_debut)->diffInDays(\Carbon\Carbon::parse($contrat->date_fin)) }} jours
                                </p>
                                @endif
                            </div>
                        </div>
                    </div>
                </div>
            @endif
        </div>
    </div>
@endsection
