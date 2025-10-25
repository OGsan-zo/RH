@extends('layouts.adminlte')

@section('title', 'Détails de l\'annonce')

@section('breadcrumb')
<ol class="breadcrumb float-sm-right">
    <li class="breadcrumb-item"><a href="{{ route('candidat.dashboard') }}">Accueil</a></li>
    <li class="breadcrumb-item"><a href="{{ route('candidatures.index') }}">Annonces</a></li>
    <li class="breadcrumb-item active">Détails</li>
</ol>
@endsection

@section('sidebar')
    @include('layouts.partials.sidebar-candidat')
@endsection

@section('content')
    @include('layouts.alerts')

    <div class="row">
        <!-- Détails de l'annonce -->
        <div class="col-md-8">
            <div class="card card-primary">
                <div class="card-header">
                    <h3 class="card-title"><i class="fas fa-briefcase mr-2"></i>{{ $annonce->titre }}</h3>
                </div>
                <div class="card-body">
                    <dl class="row">
                        <dt class="col-sm-4"><i class="fas fa-building mr-2"></i>Département</dt>
                        <dd class="col-sm-8">
                            <span class="badge badge-primary">{{ $annonce->departement->nom ?? '-' }}</span>
                        </dd>

                        <dt class="col-sm-4"><i class="fas fa-align-left mr-2"></i>Description</dt>
                        <dd class="col-sm-8">{{ $annonce->description }}</dd>

                        <dt class="col-sm-4"><i class="fas fa-tools mr-2"></i>Compétences requises</dt>
                        <dd class="col-sm-8">{{ $annonce->competences_requises }}</dd>

                        <dt class="col-sm-4"><i class="fas fa-graduation-cap mr-2"></i>Niveau requis</dt>
                        <dd class="col-sm-8">
                            <span class="badge badge-info">{{ $annonce->niveau_requis }}</span>
                        </dd>

                        <dt class="col-sm-4"><i class="fas fa-calendar-times mr-2"></i>Date limite</dt>
                        <dd class="col-sm-8">
                            {{ \Carbon\Carbon::parse($annonce->date_limite)->format('d/m/Y') }}
                            @php
                                $daysLeft = \Carbon\Carbon::now()->diffInDays(\Carbon\Carbon::parse($annonce->date_limite), false);
                            @endphp
                            @if($daysLeft < 0)
                                <span class="badge badge-danger ml-2">Expirée</span>
                            @elseif($daysLeft <= 3)
                                <span class="badge badge-warning ml-2">{{ $daysLeft }} jour(s) restant(s)</span>
                            @else
                                <span class="badge badge-success ml-2">{{ $daysLeft }} jour(s) restant(s)</span>
                            @endif
                        </dd>

                        <dt class="col-sm-4"><i class="fas fa-info-circle mr-2"></i>Statut</dt>
                        <dd class="col-sm-8">
                            @if($annonce->statut == 'ouverte')
                                <span class="badge badge-success"><i class="fas fa-check mr-1"></i>Ouverte</span>
                            @else
                                <span class="badge badge-danger"><i class="fas fa-times mr-1"></i>Fermée</span>
                            @endif
                        </dd>
                    </dl>

                    <hr>

                    <div class="row">
                        <div class="col-md-6">
                            <a href="{{ route('candidatures.postuler', $annonce->id) }}" class="btn btn-success btn-block">
                                <i class="fas fa-paper-plane mr-2"></i>Postuler à cette offre
                            </a>
                        </div>
                        <div class="col-md-6">
                            <a href="{{ route('candidatures.index') }}" class="btn btn-secondary btn-block">
                                <i class="fas fa-arrow-left mr-2"></i>Retour aux annonces
                            </a>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Informations complémentaires -->
        <div class="col-md-4">
            <!-- Statut de l'annonce -->
            <div class="info-box bg-success">
                <span class="info-box-icon"><i class="fas fa-check-circle"></i></span>
                <div class="info-box-content">
                    <span class="info-box-text">Statut</span>
                    <span class="info-box-number">{{ ucfirst($annonce->statut) }}</span>
                </div>
            </div>

            <!-- Date limite -->
            <div class="info-box bg-warning">
                <span class="info-box-icon"><i class="fas fa-calendar-alt"></i></span>
                <div class="info-box-content">
                    <span class="info-box-text">Date Limite</span>
                    <span class="info-box-number">{{ \Carbon\Carbon::parse($annonce->date_limite)->format('d/m/Y') }}</span>
                </div>
            </div>

            <!-- Conseils -->
            <div class="card card-info">
                <div class="card-header">
                    <h3 class="card-title"><i class="fas fa-lightbulb mr-2"></i>Conseils</h3>
                </div>
                <div class="card-body">
                    <ul class="mb-0">
                        <li>Vérifiez que vous remplissez les critères</li>
                        <li>Préparez votre CV à jour</li>
                        <li>Lisez attentivement la description</li>
                        <li>Postulez avant la date limite</li>
                    </ul>
                </div>
            </div>
        </div>
    </div>
@endsection
