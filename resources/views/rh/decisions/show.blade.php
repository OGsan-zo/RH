@extends('layouts.adminlte')

@section('title', 'Décision de recrutement')
@section('page-title', 'Profil du Candidat')

@section('breadcrumb')
    <li class="breadcrumb-item"><a href="{{ route('rh.dashboard') }}">Dashboard</a></li>
    <li class="breadcrumb-item"><a href="{{ route('tri.index') }}">Tri Candidats</a></li>
    <li class="breadcrumb-item active">Profil</li>
@endsection

@section('sidebar')
    @include('layouts.partials.sidebar-rh')
@endsection

@section('content')
    <div class="row">
        <!-- Informations Candidat -->
        <div class="col-md-6">
            <div class="card card-primary">
                <div class="card-header">
                    <h3 class="card-title"><i class="fas fa-user mr-2"></i>Informations du Candidat</h3>
                </div>
                <div class="card-body">
                    <dl class="row">
                        <dt class="col-sm-4"><i class="fas fa-user mr-1"></i>Nom complet :</dt>
                        <dd class="col-sm-8"><strong>{{ $candidature->candidat->nom }} {{ $candidature->candidat->prenom }}</strong></dd>

                        <dt class="col-sm-4"><i class="fas fa-envelope mr-1"></i>Email :</dt>
                        <dd class="col-sm-8">{{ $candidature->candidat->email }}</dd>

                        <dt class="col-sm-4"><i class="fas fa-birthday-cake mr-1"></i>Date naissance :</dt>
                        <dd class="col-sm-8">{{ \Carbon\Carbon::parse($candidature->candidat->date_naissance)->format('d/m/Y') }}</dd>

                        <dt class="col-sm-4"><i class="fas fa-briefcase mr-1"></i>Poste :</dt>
                        <dd class="col-sm-8"><span class="badge badge-info">{{ $candidature->annonce->titre }}</span></dd>

                        <dt class="col-sm-4"><i class="fas fa-building mr-1"></i>Département :</dt>
                        <dd class="col-sm-8">{{ $candidature->annonce->departement->nom ?? '-' }}</dd>

                        <dt class="col-sm-4"><i class="fas fa-file-pdf mr-1"></i>CV :</dt>
                        <dd class="col-sm-8">
                            @if($candidature->candidat->cv_path)
                                <a href="{{ asset('storage/' . $candidature->candidat->cv_path) }}" target="_blank" class="btn btn-sm btn-outline-primary">
                                    <i class="fas fa-download"></i> Télécharger le CV
                                </a>
                            @else
                                <span class="text-muted">Non disponible</span>
                            @endif
                        </dd>
                    </dl>
                </div>
            </div>
        </div>

        <!-- Scores -->
        <div class="col-md-6">
            <div class="card card-success">
                <div class="card-header">
                    <h3 class="card-title"><i class="fas fa-chart-bar mr-2"></i>Évaluations</h3>
                </div>
                <div class="card-body">
                    <div class="row">
                        <div class="col-md-4 text-center">
                            <div class="info-box bg-info">
                                <span class="info-box-icon"><i class="fas fa-file-alt"></i></span>
                                <div class="info-box-content">
                                    <span class="info-box-text">Note CV (IA)</span>
                                    <span class="info-box-number">{{ $candidature->note_cv ?? '-' }}%</span>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-4 text-center">
                            <div class="info-box bg-primary">
                                <span class="info-box-icon"><i class="fas fa-clipboard-check"></i></span>
                                <div class="info-box-content">
                                    <span class="info-box-text">Score QCM</span>
                                    <span class="info-box-number">{{ $resultatTest->score ?? '-' }}%</span>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-4 text-center">
                            <div class="info-box bg-warning">
                                <span class="info-box-icon"><i class="fas fa-comments"></i></span>
                                <div class="info-box-content">
                                    <span class="info-box-text">Entretien</span>
                                    <span class="info-box-number">
                                        @if($evaluation)
                                            {{ $evaluation->note }}/20
                                        @else
                                            -
                                        @endif
                                    </span>
                                </div>
                            </div>
                        </div>
                    </div>
                    <hr>
                    <div class="text-center">
                        <h4>Score Global</h4>
                        <h1>
                            @if($candidature->score_global)
                                <span class="badge badge-success" style="font-size: 2em;">{{ $candidature->score_global }}%</span>
                            @else
                                <span class="badge badge-secondary" style="font-size: 2em;">-</span>
                            @endif
                        </h1>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Remarques et Décision -->
    <div class="row">
        <div class="col-12">
            <div class="card card-warning">
                <div class="card-header">
                    <h3 class="card-title"><i class="fas fa-comment mr-2"></i>Remarques RH</h3>
                </div>
                <div class="card-body">
                    <p>{{ $evaluation->remarques ?? 'Aucune remarque saisie.' }}</p>
                </div>
            </div>
        </div>
    </div>

    <!-- Décision -->
    <div class="row">
        <div class="col-12">
            <div class="card">
                <div class="card-header bg-gradient-dark">
                    <h3 class="card-title"><i class="fas fa-gavel mr-2"></i>Décision de Recrutement</h3>
                </div>
                <div class="card-body text-center">
                    <p class="lead">Prenez votre décision finale concernant ce candidat</p>
                    <div class="btn-group" role="group">
                        <a href="{{ route('decisions.update', [$candidature->id, 'accepter']) }}"
                           class="btn btn-success btn-lg"
                           onclick="return confirm('Confirmer l\'acceptation de ce candidat ?')">
                            <i class="fas fa-check-circle"></i> Accepter
                        </a>
                        <a href="{{ route('decisions.update', [$candidature->id, 'refuser']) }}"
                           class="btn btn-danger btn-lg"
                           onclick="return confirm('Refuser définitivement ce candidat ?')">
                            <i class="fas fa-times-circle"></i> Refuser
                        </a>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
