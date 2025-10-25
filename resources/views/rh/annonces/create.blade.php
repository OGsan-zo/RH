@extends('layouts.adminlte')

@section('title', 'Créer une annonce')
@section('page-title', 'Nouvelle Annonce')

@section('breadcrumb')
    <li class="breadcrumb-item"><a href="{{ route('rh.dashboard') }}">Dashboard</a></li>
    <li class="breadcrumb-item"><a href="{{ route('annonces.index') }}">Annonces</a></li>
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
                    <h3 class="card-title"><i class="fas fa-plus-circle mr-2"></i>Créer une Annonce</h3>
                </div>
                <form method="POST" action="{{ route('annonces.store') }}">
                    @csrf
                    <div class="card-body">
                        <div class="form-group">
                            <label for="departement_id"><i class="fas fa-building mr-1"></i>Département <span class="text-danger">*</span></label>
                            <select name="departement_id" id="departement_id" class="form-control @error('departement_id') is-invalid @enderror" required>
                                <option value="">-- Sélectionnez un département --</option>
                                @foreach($departements as $d)
                                    <option value="{{ $d->id }}" {{ old('departement_id') == $d->id ? 'selected' : '' }}>{{ $d->nom }}</option>
                                @endforeach
                            </select>
                            @error('departement_id')
                                <span class="invalid-feedback">{{ $message }}</span>
                            @enderror
                        </div>

                        <div class="form-group">
                            <label for="titre"><i class="fas fa-briefcase mr-1"></i>Titre du poste <span class="text-danger">*</span></label>
                            <input type="text" 
                                   name="titre" 
                                   id="titre"
                                   class="form-control @error('titre') is-invalid @enderror" 
                                   placeholder="Ex: Développeur Full Stack"
                                   required 
                                   maxlength="150"
                                   value="{{ old('titre') }}">
                            @error('titre')
                                <span class="invalid-feedback">{{ $message }}</span>
                            @enderror
                        </div>

                        <div class="form-group">
                            <label for="description"><i class="fas fa-align-left mr-1"></i>Description <span class="text-danger">*</span></label>
                            <textarea name="description" 
                                      id="description"
                                      class="form-control @error('description') is-invalid @enderror" 
                                      rows="4"
                                      placeholder="Décrivez le poste, les missions, etc."
                                      required>{{ old('description') }}</textarea>
                            @error('description')
                                <span class="invalid-feedback">{{ $message }}</span>
                            @enderror
                        </div>

                        <div class="form-group">
                            <label for="competences_requises"><i class="fas fa-star mr-1"></i>Compétences requises</label>
                            <textarea name="competences_requises" 
                                      id="competences_requises"
                                      class="form-control @error('competences_requises') is-invalid @enderror" 
                                      rows="3"
                                      placeholder="Ex: PHP, Laravel, JavaScript, etc.">{{ old('competences_requises') }}</textarea>
                            @error('competences_requises')
                                <span class="invalid-feedback">{{ $message }}</span>
                            @enderror
                        </div>

                        <div class="row">
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label for="niveau_requis"><i class="fas fa-graduation-cap mr-1"></i>Niveau requis</label>
                                    <input type="text" 
                                           name="niveau_requis" 
                                           id="niveau_requis"
                                           class="form-control @error('niveau_requis') is-invalid @enderror" 
                                           placeholder="Ex: Bac+3"
                                           value="{{ old('niveau_requis') }}">
                                    @error('niveau_requis')
                                        <span class="invalid-feedback">{{ $message }}</span>
                                    @enderror
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label for="date_limite"><i class="far fa-calendar mr-1"></i>Date limite</label>
                                    <input type="date" 
                                           name="date_limite" 
                                           id="date_limite"
                                           class="form-control @error('date_limite') is-invalid @enderror" 
                                           value="{{ old('date_limite') }}">
                                    @error('date_limite')
                                        <span class="invalid-feedback">{{ $message }}</span>
                                    @enderror
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="card-footer">
                        <button type="submit" class="btn btn-success">
                            <i class="fas fa-save"></i> Enregistrer
                        </button>
                        <a href="{{ route('annonces.index') }}" class="btn btn-secondary">
                            <i class="fas fa-times"></i> Annuler
                        </a>
                    </div>
                </form>
            </div>
        </div>
    </div>
@endsection
