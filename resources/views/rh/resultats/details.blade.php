@extends('layouts.adminlte')

@section('title', 'Résultats du test')
@section('page-title', 'Détails du Résultat')

@section('breadcrumb')
    <li class="breadcrumb-item"><a href="{{ route('rh.dashboard') }}">Dashboard</a></li>
    <li class="breadcrumb-item"><a href="{{ route('resultats.select') }}">Résultats QCM</a></li>
    <li class="breadcrumb-item active">Détails</li>
@endsection

@section('sidebar')
    @include('layouts.partials.sidebar-rh')
@endsection

@section('content')
    <div class="row">
        <div class="col-12">
            <!-- Info Candidat -->
            <div class="card card-primary">
                <div class="card-header">
                    <h3 class="card-title"><i class="fas fa-user-graduate mr-2"></i>Informations du Candidat</h3>
                    <div class="card-tools">
                        <a href="{{ route('resultats.select') }}" class="btn btn-sm btn-light">
                            <i class="fas fa-arrow-left"></i> Retour
                        </a>
                    </div>
                </div>
                <div class="card-body">
                    <div class="row">
                        <div class="col-md-6">
                            <p><strong><i class="fas fa-user mr-2"></i>Nom complet :</strong> {{ $candidature->candidat->nom }} {{ $candidature->candidat->prenom }}</p>
                            <p><strong><i class="fas fa-briefcase mr-2"></i>Annonce :</strong> {{ $candidature->annonce->titre }}</p>
                        </div>
                        <div class="col-md-6">
                            <p><strong><i class="fas fa-building mr-2"></i>Département :</strong> {{ $candidature->annonce->departement->nom ?? 'N/A' }}</p>
                            <p><strong><i class="fas fa-calendar mr-2"></i>Date candidature :</strong> {{ \Carbon\Carbon::parse($candidature->date_candidature)->format('d/m/Y') }}</p>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Scores -->
            <div class="row">
                <div class="col-md-4">
                    <div class="info-box bg-info">
                        <span class="info-box-icon"><i class="fas fa-file-alt"></i></span>
                        <div class="info-box-content">
                            <span class="info-box-text">Note CV (IA)</span>
                            <span class="info-box-number">{{ $candidature->note_cv ?? 'N/A' }}%</span>
                        </div>
                    </div>
                </div>
                <div class="col-md-4">
                    <div class="info-box bg-primary">
                        <span class="info-box-icon"><i class="fas fa-clipboard-check"></i></span>
                        <div class="info-box-content">
                            <span class="info-box-text">Score Test QCM</span>
                            <span class="info-box-number">{{ $resultat->score ?? 'N/A' }}%</span>
                        </div>
                    </div>
                </div>
                <div class="col-md-4">
                    <div class="info-box bg-success">
                        <span class="info-box-icon"><i class="fas fa-chart-line"></i></span>
                        <div class="info-box-content">
                            <span class="info-box-text">Score Global</span>
                            <span class="info-box-number">{{ $candidature->score_global ?? 'N/A' }}%</span>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Réponses Détaillées -->
            <div class="card">
                <div class="card-header">
                    <h3 class="card-title"><i class="fas fa-list-ul mr-2"></i>Réponses Détaillées</h3>
                </div>
                <div class="card-body">
                    @foreach($resultat->reponsesCandidat as $rep)
                        <div class="callout {{ $rep->reponse->est_correcte ? 'callout-success' : 'callout-danger' }} mb-3">
                            <h5>
                                <i class="fas fa-question-circle mr-2"></i>
                                Question {{ $loop->iteration }}
                                @if($rep->reponse->est_correcte)
                                    <span class="badge badge-success float-right"><i class="fas fa-check"></i> Correct</span>
                                @else
                                    <span class="badge badge-danger float-right"><i class="fas fa-times"></i> Incorrect</span>
                                @endif
                            </h5>
                            <p class="mb-3"><strong>{{ $rep->question->intitule }}</strong></p>
                            
                            <ul class="list-unstyled ml-3">
                                @foreach($rep->question->reponses as $r)
                                    <li class="mb-2">
                                        @if($r->est_correcte)
                                            <i class="fas fa-check-circle text-success mr-2"></i>
                                            <strong class="text-success">{{ $r->texte }}</strong>
                                            <span class="badge badge-success ml-2">Bonne réponse</span>
                                        @else
                                            <i class="far fa-circle text-muted mr-2"></i>
                                            {{ $r->texte }}
                                        @endif
                                        
                                        @if($rep->reponse_id == $r->id)
                                            <span class="badge badge-info ml-2">
                                                <i class="fas fa-arrow-left"></i> Réponse du candidat
                                            </span>
                                        @endif
                                    </li>
                                @endforeach
                            </ul>
                        </div>
                    @endforeach
                </div>
                <div class="card-footer">
                    <a href="{{ route('resultats.select') }}" class="btn btn-secondary">
                        <i class="fas fa-arrow-left"></i> Retour à la liste
                    </a>
                </div>
            </div>
        </div>
    </div>
@endsection
