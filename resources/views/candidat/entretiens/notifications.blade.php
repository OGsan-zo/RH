@extends('layouts.adminlte')

@section('title', 'Mes entretiens')

@section('breadcrumb')
<ol class="breadcrumb float-sm-right">
    <li class="breadcrumb-item"><a href="{{ route('candidat.dashboard') }}">Accueil</a></li>
    <li class="breadcrumb-item active">Mes Entretiens</li>
</ol>
@endsection

@section('sidebar')
    @include('layouts.partials.sidebar-candidat')
@endsection

@section('content')
    @include('layouts.alerts')

    <div class="row">
        <div class="col-12">
            <div class="card card-warning">
                <div class="card-header">
                    <h3 class="card-title"><i class="fas fa-calendar-alt mr-2"></i>Mes Notifications d'Entretien</h3>
                    <div class="card-tools">
                        <span class="badge badge-light">{{ $entretiens->count() }} entretien(s)</span>
                    </div>
                </div>
                <div class="card-body">
                    @if($entretiens->isEmpty())
                        <div class="alert alert-info">
                            <i class="fas fa-info-circle mr-2"></i>
                            Aucun entretien planifié pour le moment.
                        </div>
                        <a href="{{ route('candidatures.suivi') }}" class="btn btn-primary">
                            <i class="fas fa-tasks mr-2"></i>Voir mes candidatures
                        </a>
                    @else
                        @foreach($entretiens as $e)
                        <div class="card {{ $e->statut === 'planifie' ? 'card-warning' : ($e->statut === 'confirme' ? 'card-success' : 'card-danger') }} card-outline mb-3">
                            <div class="card-header">
                                <h3 class="card-title">
                                    <i class="fas fa-briefcase mr-2"></i>
                                    <strong>{{ $e->candidature->annonce->titre }}</strong>
                                </h3>
                                <div class="card-tools">
                                    @if($e->statut === 'planifie')
                                        <span class="badge badge-warning">
                                            <i class="fas fa-clock mr-1"></i>En attente de réponse
                                        </span>
                                    @elseif($e->statut === 'confirme')
                                        <span class="badge badge-success">
                                            <i class="fas fa-check-circle mr-1"></i>Confirmé
                                        </span>
                                    @elseif($e->statut === 'refuse')
                                        <span class="badge badge-danger">
                                            <i class="fas fa-times-circle mr-1"></i>Refusé
                                        </span>
                                    @else
                                        <span class="badge badge-secondary">{{ ucfirst($e->statut) }}</span>
                                    @endif
                                </div>
                            </div>
                            <div class="card-body">
                                <div class="row">
                                    <div class="col-md-6">
                                        <dl class="row mb-0">
                                            <dt class="col-sm-4"><i class="fas fa-calendar mr-2 text-primary"></i>Date :</dt>
                                            <dd class="col-sm-8">
                                                <strong>{{ \Carbon\Carbon::parse($e->date_entretien)->format('d/m/Y à H:i') }}</strong>
                                            </dd>

                                            <dt class="col-sm-4"><i class="fas fa-map-marker-alt mr-2 text-danger"></i>Lieu :</dt>
                                            <dd class="col-sm-8">{{ $e->lieu }}</dd>

                                            <dt class="col-sm-4"><i class="fas fa-building mr-2 text-info"></i>Département :</dt>
                                            <dd class="col-sm-8">{{ $e->candidature->annonce->departement->nom ?? '-' }}</dd>
                                        </dl>
                                    </div>
                                    <div class="col-md-6">
                                        @if($e->statut === 'planifie')
                                            <div class="callout callout-warning">
                                                <h5><i class="fas fa-exclamation-triangle"></i> Action requise !</h5>
                                                <p class="mb-0">Veuillez confirmer ou refuser cet entretien.</p>
                                            </div>
                                        @elseif($e->statut === 'confirme')
                                            <div class="callout callout-success">
                                                <h5><i class="fas fa-check"></i> Entretien confirmé</h5>
                                                <p class="mb-0">N'oubliez pas de vous présenter à l'heure indiquée.</p>
                                            </div>
                                        @elseif($e->statut === 'refuse')
                                            <div class="callout callout-danger">
                                                <h5><i class="fas fa-times"></i> Entretien refusé</h5>
                                                <p class="mb-0">Vous avez décliné cet entretien.</p>
                                            </div>
                                        @endif
                                    </div>
                                </div>

                                @if($e->statut === 'planifie')
                                <hr>
                                <div class="row">
                                    <div class="col-md-6">
                                        <a href="{{ route('entretiens.reponse', [$e->id, 'confirmer']) }}" 
                                           class="btn btn-success btn-block"
                                           onclick="return confirm('Êtes-vous sûr de vouloir confirmer cet entretien ?')">
                                            <i class="fas fa-check mr-2"></i>Confirmer l'entretien
                                        </a>
                                    </div>
                                    <div class="col-md-6">
                                        <a href="{{ route('entretiens.reponse', [$e->id, 'refuser']) }}" 
                                           class="btn btn-danger btn-block"
                                           onclick="return confirm('Êtes-vous sûr de vouloir refuser cet entretien ?')">
                                            <i class="fas fa-times mr-2"></i>Refuser l'entretien
                                        </a>
                                    </div>
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
