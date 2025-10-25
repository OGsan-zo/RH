@extends('layouts.adminlte')

@section('title', 'Évaluer entretien')
@section('page-title', 'Évaluation Entretien')

@section('breadcrumb')
    <li class="breadcrumb-item"><a href="{{ route('rh.dashboard') }}">Dashboard</a></li>
    <li class="breadcrumb-item"><a href="{{ route('evaluations.index') }}">Évaluations</a></li>
    <li class="breadcrumb-item active">Évaluer</li>
@endsection

@section('sidebar')
    @include('layouts.partials.sidebar-rh')
@endsection

@section('content')
    <div class="row">
        <div class="col-md-8 offset-md-2">
            <!-- Info Entretien -->
            <div class="card card-primary">
                <div class="card-header">
                    <h3 class="card-title"><i class="fas fa-star mr-2"></i>Informations de l'Entretien</h3>
                </div>
                <div class="card-body">
                    <div class="row">
                        <div class="col-md-6">
                            <p><strong><i class="fas fa-user mr-2"></i>Candidat :</strong> {{ $entretien->candidature->candidat->nom }} {{ $entretien->candidature->candidat->prenom }}</p>
                            <p><strong><i class="fas fa-briefcase mr-2"></i>Poste :</strong> {{ $entretien->candidature->annonce->titre }}</p>
                        </div>
                        <div class="col-md-6">
                            <p><strong><i class="far fa-calendar mr-2"></i>Date entretien :</strong> {{ \Carbon\Carbon::parse($entretien->date_entretien)->format('d/m/Y H:i') }}</p>
                            <p><strong><i class="fas fa-map-marker-alt mr-2"></i>Lieu :</strong> {{ $entretien->lieu }}</p>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Formulaire Évaluation -->
            <div class="card card-success">
                <div class="card-header">
                    <h3 class="card-title"><i class="fas fa-clipboard-check mr-2"></i>Évaluer l'Entretien</h3>
                </div>
                <form method="POST" action="{{ route('evaluations.store', $entretien->id) }}">
                    @csrf
                    <div class="card-body">
                        <div class="form-group">
                            <label for="note"><i class="fas fa-star mr-1"></i>Note (sur 20) <span class="text-danger">*</span></label>
                            <input type="number" 
                                   step="0.01" 
                                   name="note" 
                                   id="note"
                                   class="form-control @error('note') is-invalid @enderror" 
                                   placeholder="Ex: 15.5"
                                   required 
                                   min="0" 
                                   max="20"
                                   value="{{ old('note') }}">
                            @error('note')
                                <span class="invalid-feedback">{{ $message }}</span>
                            @enderror
                            <small class="form-text text-muted">Entrez une note entre 0 et 20</small>
                        </div>

                        <div class="form-group">
                            <label for="remarques"><i class="fas fa-comment mr-1"></i>Remarques</label>
                            <textarea name="remarques" 
                                      id="remarques"
                                      class="form-control @error('remarques') is-invalid @enderror" 
                                      rows="5"
                                      placeholder="Commentaires sur l'entretien, points forts, points à améliorer...">{{ old('remarques') }}</textarea>
                            @error('remarques')
                                <span class="invalid-feedback">{{ $message }}</span>
                            @enderror
                        </div>
                    </div>
                    <div class="card-footer">
                        <button type="submit" class="btn btn-success">
                            <i class="fas fa-save"></i> Enregistrer l'évaluation
                        </button>
                        <a href="{{ route('evaluations.index') }}" class="btn btn-secondary">
                            <i class="fas fa-times"></i> Annuler
                        </a>
                    </div>
                </form>
            </div>
        </div>
    </div>
@endsection
