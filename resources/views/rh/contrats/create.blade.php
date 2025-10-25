@extends('layouts.adminlte')

@section('title', 'Créer un contrat')
@section('page-title', 'Nouveau Contrat')

@section('breadcrumb')
    <li class="breadcrumb-item"><a href="{{ route('rh.dashboard') }}">Dashboard</a></li>
    <li class="breadcrumb-item"><a href="{{ route('contrats.index') }}">Contrats</a></li>
    <li class="breadcrumb-item active">Créer</li>
@endsection

@section('sidebar')
    @include('layouts.partials.sidebar-rh')
@endsection

@section('content')
    <div class="row">
        <div class="col-md-8 offset-md-2">
            <div class="card card-primary">
                <div class="card-header">
                    <h3 class="card-title"><i class="fas fa-file-contract mr-2"></i>Créer un Contrat</h3>
                </div>
                <form method="POST" action="{{ route('contrats.create') }}">
                    @csrf
                    <div class="card-body">
                        @if(request('candidature_id'))
                            <input type="hidden" name="candidature_id" value="{{ request('candidature_id') }}">
                        @else
                            <div class="form-group">
                                <label for="candidature_id"><i class="fas fa-user mr-1"></i>Candidat <span class="text-danger">*</span></label>
                                <select name="candidature_id" id="candidature_id" class="form-control @error('candidature_id') is-invalid @enderror" required>
                                    <option value="">-- Sélectionner --</option>
                                    @foreach($candidats as $c)
                                        <option value="{{ $c->id }}" {{ old('candidature_id') == $c->id ? 'selected' : '' }}>
                                            {{ $c->candidat->nom }} {{ $c->candidat->prenom }} — {{ $c->annonce->titre }}
                                        </option>
                                    @endforeach
                                </select>
                                @error('candidature_id')
                                    <span class="invalid-feedback">{{ $message }}</span>
                                @enderror
                            </div>
                        @endif

                        <div class="form-group">
                            <label for="type_contrat"><i class="fas fa-file-signature mr-1"></i>Type de contrat <span class="text-danger">*</span></label>
                            <select name="type_contrat" id="type_contrat" class="form-control @error('type_contrat') is-invalid @enderror" required>
                                <option value="essai" {{ old('type_contrat') == 'essai' ? 'selected' : '' }}>Essai</option>
                                <option value="CDD" {{ old('type_contrat') == 'CDD' ? 'selected' : '' }}>CDD</option>
                                <option value="CDI" {{ old('type_contrat') == 'CDI' ? 'selected' : '' }}>CDI</option>
                            </select>
                            @error('type_contrat')
                                <span class="invalid-feedback">{{ $message }}</span>
                            @enderror
                        </div>

                        <div class="form-group">
                            <label for="salaire"><i class="fas fa-money-bill-wave mr-1"></i>Salaire (en Ar) <span class="text-danger">*</span></label>
                            <input type="number" 
                                   step="0.01" 
                                   name="salaire" 
                                   id="salaire"
                                   class="form-control @error('salaire') is-invalid @enderror" 
                                   placeholder="Ex: 1500000"
                                   value="{{ old('salaire') }}"
                                   required>
                            @error('salaire')
                                <span class="invalid-feedback">{{ $message }}</span>
                            @enderror
                        </div>

                        <div class="row">
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label for="date_debut"><i class="far fa-calendar-alt mr-1"></i>Date début <span class="text-danger">*</span></label>
                                    <input type="date" 
                                           name="date_debut" 
                                           id="date_debut"
                                           class="form-control @error('date_debut') is-invalid @enderror" 
                                           value="{{ old('date_debut') }}"
                                           required>
                                    @error('date_debut')
                                        <span class="invalid-feedback">{{ $message }}</span>
                                    @enderror
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label for="date_fin"><i class="far fa-calendar-alt mr-1"></i>Date fin</label>
                                    <input type="date" 
                                           name="date_fin" 
                                           id="date_fin"
                                           class="form-control @error('date_fin') is-invalid @enderror" 
                                           value="{{ old('date_fin') }}">
                                    @error('date_fin')
                                        <span class="invalid-feedback">{{ $message }}</span>
                                    @enderror
                                    <small class="form-text text-muted">Optionnel pour CDI</small>
                                </div>
                            </div>
                        </div>

                        <div class="form-group">
                            <label for="statut"><i class="fas fa-info-circle mr-1"></i>Statut</label>
                            <select name="statut" id="statut" class="form-control">
                                @foreach(\App\Models\Contrat::STATUTS as $statut)
                                    <option value="{{ $statut }}" {{ old('statut', 'actif') == $statut ? 'selected' : '' }}>
                                        {{ ucfirst(str_replace('_',' ', $statut)) }}
                                    </option>
                                @endforeach
                            </select>
                        </div>
                    </div>
                    <div class="card-footer">
                        <button type="submit" class="btn btn-success">
                            <i class="fas fa-save"></i> Créer le contrat
                        </button>
                        <a href="{{ route('contrats.index') }}" class="btn btn-secondary">
                            <i class="fas fa-times"></i> Annuler
                        </a>
                    </div>
                </form>
            </div>
        </div>
    </div>
@endsection
