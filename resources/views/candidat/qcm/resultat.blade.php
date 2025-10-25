@extends('layouts.adminlte')

@section('title', 'Résultat du test')

@section('breadcrumb')
<ol class="breadcrumb float-sm-right">
    <li class="breadcrumb-item"><a href="{{ route('candidat.dashboard') }}">Accueil</a></li>
    <li class="breadcrumb-item"><a href="{{ route('tests.select') }}">Tests QCM</a></li>
    <li class="breadcrumb-item active">Résultat</li>
</ol>
@endsection

@section('sidebar')
    @include('layouts.partials.sidebar-candidat')
@endsection

@section('content')
    <div class="row">
        <div class="col-md-8 offset-md-2">
            <!-- Titre du test -->
            <div class="card card-primary">
                <div class="card-header text-center">
                    <h3 class="card-title">
                        <i class="fas fa-clipboard-check mr-2"></i>{{ $test->titre }}
                    </h3>
                </div>
                <div class="card-body text-center">
                    <!-- Score -->
                    <div class="row">
                        <div class="col-12">
                            <div class="info-box {{ $pourcentage >= 70 ? 'bg-success' : 'bg-danger' }}">
                                <span class="info-box-icon">
                                    <i class="fas {{ $pourcentage >= 70 ? 'fa-check-circle' : 'fa-times-circle' }}"></i>
                                </span>
                                <div class="info-box-content">
                                    <span class="info-box-text">Score Obtenu</span>
                                    <span class="info-box-number" style="font-size: 3rem;">{{ $pourcentage }}%</span>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Barre de progression -->
                    <div class="progress mb-4" style="height: 30px;">
                        <div class="progress-bar {{ $pourcentage >= 70 ? 'bg-success' : 'bg-danger' }}" 
                             role="progressbar" 
                             style="width: {{ $pourcentage }}%;" 
                             aria-valuenow="{{ $pourcentage }}" 
                             aria-valuemin="0" 
                             aria-valuemax="100">
                            <strong>{{ $pourcentage }}%</strong>
                        </div>
                    </div>

                    <!-- Message de résultat -->
                    @if($pourcentage >= 70)
                        <div class="callout callout-success">
                            <h4><i class="fas fa-trophy mr-2"></i>Félicitations !</h4>
                            <p class="mb-0">
                                Vous avez réussi le test avec un score de <strong>{{ $pourcentage }}%</strong>. 
                                Votre candidature passe à l'étape suivante du processus de recrutement.
                            </p>
                        </div>
                    @else
                        <div class="callout callout-danger">
                            <h4><i class="fas fa-exclamation-triangle mr-2"></i>Test non réussi</h4>
                            <p class="mb-0">
                                Votre score de <strong>{{ $pourcentage }}%</strong> est inférieur au seuil requis de 70%. 
                                Malheureusement, votre candidature ne peut pas continuer pour ce poste.
                            </p>
                        </div>
                    @endif

                    <!-- Statistiques -->
                    <div class="row mt-4">
                        <div class="col-md-6">
                            <div class="info-box bg-info">
                                <span class="info-box-icon"><i class="fas fa-question"></i></span>
                                <div class="info-box-content">
                                    <span class="info-box-text">Total Questions</span>
                                    <span class="info-box-number">{{ $test->questions->count() }}</span>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="info-box bg-warning">
                                <span class="info-box-icon"><i class="fas fa-percent"></i></span>
                                <div class="info-box-content">
                                    <span class="info-box-text">Seuil de Réussite</span>
                                    <span class="info-box-number">70%</span>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Boutons d'action -->
                    <div class="row mt-4">
                        <div class="col-md-6">
                            <a href="{{ route('candidatures.suivi') }}" class="btn btn-primary btn-block btn-lg">
                                <i class="fas fa-tasks mr-2"></i>Voir mon suivi
                            </a>
                        </div>
                        <div class="col-md-6">
                            <a href="{{ route('candidat.dashboard') }}" class="btn btn-secondary btn-block btn-lg">
                                <i class="fas fa-home mr-2"></i>Retour au dashboard
                            </a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
