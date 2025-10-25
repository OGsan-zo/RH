@extends('layouts.adminlte')

@section('title', 'Générer un test QCM')
@section('page-title', 'Création de Test QCM')

@section('breadcrumb')
    <li class="breadcrumb-item"><a href="{{ route('rh.dashboard') }}">Dashboard</a></li>
    <li class="breadcrumb-item"><a href="{{ route('tests.view') }}">Tests QCM</a></li>
    <li class="breadcrumb-item active">Créer</li>
@endsection

@section('sidebar')
    @include('layouts.partials.sidebar-rh')
@endsection

@section('content')
    <div class="row">
        <div class="col-md-8">
            <div class="card card-primary">
                <div class="card-header">
                    <h3 class="card-title"><i class="fas fa-magic mr-2"></i>Génération Automatique avec Gemini AI</h3>
                </div>
                <form action="{{ route('tests.store') }}" method="POST">
                    @csrf
                    <div class="card-body">
                        @if(session('error'))
                            <div class="alert alert-danger alert-dismissible fade show" role="alert">
                                <i class="fas fa-exclamation-triangle"></i> {{ session('error') }}
                                <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                                    <span aria-hidden="true">&times;</span>
                                </button>
                            </div>
                        @endif
                        @if(session('success'))
                            <div class="alert alert-success alert-dismissible fade show" role="alert">
                                <i class="fas fa-check-circle"></i> {{ session('success') }}
                                <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                                    <span aria-hidden="true">&times;</span>
                                </button>
                            </div>
                        @endif

                        <div class="callout callout-info">
                            <h5><i class="fas fa-info-circle"></i> Information</h5>
                            <p>Le test QCM sera généré automatiquement par l'IA Gemini en fonction de l'annonce sélectionnée.</p>
                        </div>

                        <div class="form-group">
                            <label for="annonce_id"><i class="fas fa-bullhorn mr-1"></i>Annonce liée <span class="text-danger">*</span></label>
                            <select name="annonce_id" id="annonce_id" class="form-control @error('annonce_id') is-invalid @enderror" required>
                                <option value="">-- Sélectionnez une annonce --</option>
                                @foreach($annonces as $a)
                                    <option value="{{ $a->id }}" {{ old('annonce_id') == $a->id ? 'selected' : '' }}>
                                        {{ $a->titre }} ({{ $a->departement->nom ?? 'N/A' }})
                                    </option>
                                @endforeach
                            </select>
                            @error('annonce_id')
                                <span class="invalid-feedback">{{ $message }}</span>
                            @enderror
                        </div>

                        <div class="row">
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label for="nombre_questions"><i class="fas fa-list-ol mr-1"></i>Nombre de questions <span class="text-danger">*</span></label>
                                    <input type="number" 
                                           name="nombre_questions" 
                                           id="nombre_questions"
                                           class="form-control @error('nombre_questions') is-invalid @enderror" 
                                           min="1" 
                                           max="20" 
                                           value="{{ old('nombre_questions', 10) }}"
                                           required>
                                    @error('nombre_questions')
                                        <span class="invalid-feedback">{{ $message }}</span>
                                    @enderror
                                    <small class="form-text text-muted">Entre 1 et 20 questions</small>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label><i class="fas fa-check-square mr-1"></i>Réponses par question <span class="text-danger">*</span></label><br>
                                    <div class="icheck-primary d-inline mr-3">
                                        <input type="radio" 
                                               name="nombre_reponses" 
                                               id="reponses3" 
                                               value="3" 
                                               {{ old('nombre_reponses') == '3' ? 'checked' : '' }}
                                               required>
                                        <label for="reponses3">3 réponses</label>
                                    </div>
                                    <div class="icheck-primary d-inline">
                                        <input type="radio" 
                                               name="nombre_reponses" 
                                               id="reponses4" 
                                               value="4" 
                                               {{ old('nombre_reponses', '4') == '4' ? 'checked' : '' }}
                                               required>
                                        <label for="reponses4">4 réponses</label>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="card-footer">
                        <button type="submit" class="btn btn-success btn-lg">
                            <i class="fas fa-magic"></i> Générer avec Gemini AI
                        </button>
                        <a href="{{ route('tests.view') }}" class="btn btn-secondary">
                            <i class="fas fa-arrow-left"></i> Retour
                        </a>
                    </div>
                </form>
            </div>
        </div>

        <div class="col-md-4">
            <div class="card card-info">
                <div class="card-header">
                    <h3 class="card-title"><i class="fas fa-lightbulb mr-2"></i>Conseils</h3>
                </div>
                <div class="card-body">
                    <ul class="list-unstyled">
                        <li class="mb-2"><i class="fas fa-check text-success mr-2"></i>Choisissez une annonce avec une description détaillée</li>
                        <li class="mb-2"><i class="fas fa-check text-success mr-2"></i>10 questions est un bon compromis</li>
                        <li class="mb-2"><i class="fas fa-check text-success mr-2"></i>4 réponses offrent plus de choix</li>
                        <li class="mb-2"><i class="fas fa-check text-success mr-2"></i>La génération peut prendre quelques secondes</li>
                    </ul>
                </div>
            </div>
        </div>
    </div>
@endsection
