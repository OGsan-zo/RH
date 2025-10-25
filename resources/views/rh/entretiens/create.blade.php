@extends('layouts.adminlte')

@section('title', 'Planifier un entretien')
@section('page-title', 'Planification Entretien')

@section('breadcrumb')
    <li class="breadcrumb-item"><a href="{{ route('rh.dashboard') }}">Dashboard</a></li>
    <li class="breadcrumb-item"><a href="{{ route('entretiens.index') }}">Entretiens</a></li>
    <li class="breadcrumb-item active">Planifier</li>
@endsection

@section('sidebar')
    @include('layouts.partials.sidebar-rh')
@endsection

@section('content')
    <div class="row">
        <div class="col-md-8 offset-md-2">
            <div class="card card-primary">
                <div class="card-header">
                    <h3 class="card-title"><i class="fas fa-calendar-plus mr-2"></i>Planifier un Entretien</h3>
                </div>
                <form method="POST" action="{{ route('entretiens.create') }}">
                    @csrf
                    <div class="card-body">
                        <div class="form-group">
                            <label for="candidature_id"><i class="fas fa-user mr-1"></i>Candidat <span class="text-danger">*</span></label>
                            <select name="candidature_id" id="candidature_id" class="form-control @error('candidature_id') is-invalid @enderror" required>
                                <option value="">-- Sélectionnez un candidat --</option>
                                @foreach($candidatures as $c)
                                    <option value="{{ $c->id }}" {{ old('candidature_id') == $c->id ? 'selected' : '' }}>
                                        {{ $c->candidat->nom }} {{ $c->candidat->prenom }} — {{ $c->annonce->titre }}
                                    </option>
                                @endforeach
                            </select>
                            @error('candidature_id')
                                <span class="invalid-feedback">{{ $message }}</span>
                            @enderror
                        </div>

                        <div class="row">
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label for="date_entretien"><i class="far fa-calendar-alt mr-1"></i>Date & Heure <span class="text-danger">*</span></label>
                                    <input type="datetime-local" 
                                           name="date_entretien" 
                                           id="date_entretien"
                                           class="form-control @error('date_entretien') is-invalid @enderror" 
                                           value="{{ old('date_entretien') }}"
                                           required>
                                    @error('date_entretien')
                                        <span class="invalid-feedback">{{ $message }}</span>
                                    @enderror
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label for="duree"><i class="far fa-clock mr-1"></i>Durée (minutes) <span class="text-danger">*</span></label>
                                    <input type="number" 
                                           name="duree" 
                                           id="duree"
                                           class="form-control @error('duree') is-invalid @enderror" 
                                           value="{{ old('duree', 60) }}" 
                                           min="15" 
                                           max="240"
                                           required>
                                    @error('duree')
                                        <span class="invalid-feedback">{{ $message }}</span>
                                    @enderror
                                    <small class="form-text text-muted">Entre 15 et 240 minutes</small>
                                </div>
                            </div>
                        </div>

                        <div class="form-group">
                            <label for="lieu"><i class="fas fa-map-marker-alt mr-1"></i>Lieu <span class="text-danger">*</span></label>
                            <input type="text" 
                                   name="lieu" 
                                   id="lieu"
                                   class="form-control @error('lieu') is-invalid @enderror" 
                                   placeholder="Ex: Salle de conférence A, Visioconférence, etc."
                                   value="{{ old('lieu') }}"
                                   required>
                            @error('lieu')
                                <span class="invalid-feedback">{{ $message }}</span>
                            @enderror
                        </div>
                    </div>
                    <div class="card-footer">
                        <button type="submit" class="btn btn-success">
                            <i class="fas fa-save"></i> Enregistrer
                        </button>
                        <a href="{{ route('entretiens.index') }}" class="btn btn-secondary">
                            <i class="fas fa-times"></i> Annuler
                        </a>
                    </div>
                </form>
            </div>
        </div>
    </div>
@endsection
