@extends('layouts.adminlte')

@section('title', 'Nouvelle affiliation sociale')
@section('page-title', 'Nouvelle Affiliation')

@section('breadcrumb')
    <li class="breadcrumb-item"><a href="{{ route('rh.dashboard') }}">Dashboard</a></li>
    <li class="breadcrumb-item"><a href="{{ route('affiliations.index') }}">Affiliations</a></li>
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
                    <h3 class="card-title"><i class="fas fa-shield-alt mr-2"></i>Créer une Affiliation Sociale</h3>
                </div>
                <form method="POST" action="{{ route('affiliations.create') }}">
                    @csrf
                    <div class="card-body">
                        <div class="callout callout-info">
                            <h5><i class="fas fa-info-circle"></i> Information</h5>
                            <p>Affiliez un employé avec un contrat actif à un organisme social (CNAPS, OSTIE, AMIT).</p>
                        </div>

                        <div class="form-group">
                            <label for="contrat_id"><i class="fas fa-file-contract mr-1"></i>Contrat actif <span class="text-danger">*</span></label>
                            <select name="contrat_id" id="contrat_id" class="form-control @error('contrat_id') is-invalid @enderror" required>
                                <option value="">-- Sélectionner un contrat --</option>
                                @foreach($contratsActifs as $c)
                                    <option value="{{ $c->id }}" {{ old('contrat_id') == $c->id ? 'selected' : '' }}>
                                        {{ $c->candidature->candidat->nom }} {{ $c->candidature->candidat->prenom }}
                                        — {{ $c->candidature->annonce->titre }} ({{ strtoupper($c->type_contrat) }})
                                    </option>
                                @endforeach
                            </select>
                            @error('contrat_id')
                                <span class="invalid-feedback">{{ $message }}</span>
                            @enderror
                        </div>

                        <div class="form-group">
                            <label for="organisme"><i class="fas fa-building mr-1"></i>Organisme <span class="text-danger">*</span></label>
                            <select name="organisme" id="organisme" class="form-control @error('organisme') is-invalid @enderror" required>
                                <option value="CNAPS" {{ old('organisme') == 'CNAPS' ? 'selected' : '' }}>CNAPS (Caisse Nationale de Prévoyance Sociale)</option>
                                <option value="OSTIE" {{ old('organisme') == 'OSTIE' ? 'selected' : '' }}>OSTIE (Office Sanitaire Tananarivien Inter-Entreprises)</option>
                                <option value="AMIT" {{ old('organisme') == 'AMIT' ? 'selected' : '' }}>AMIT (Assurance Maladie des Travailleurs)</option>
                            </select>
                            @error('organisme')
                                <span class="invalid-feedback">{{ $message }}</span>
                            @enderror
                        </div>

                        <div class="form-group">
                            <label for="numero_affiliation"><i class="fas fa-hashtag mr-1"></i>Numéro d'affiliation <span class="text-danger">*</span></label>
                            <input type="text" 
                                   name="numero_affiliation" 
                                   id="numero_affiliation"
                                   class="form-control @error('numero_affiliation') is-invalid @enderror" 
                                   placeholder="Ex: CNAPS-2024-001234"
                                   value="{{ old('numero_affiliation') }}"
                                   required>
                            @error('numero_affiliation')
                                <span class="invalid-feedback">{{ $message }}</span>
                            @enderror
                        </div>

                        <div class="form-group">
                            <label for="taux_cotisation"><i class="fas fa-percent mr-1"></i>Taux de cotisation (%)</label>
                            <input type="number" 
                                   name="taux_cotisation" 
                                   id="taux_cotisation"
                                   class="form-control @error('taux_cotisation') is-invalid @enderror" 
                                   step="0.01" 
                                   value="{{ old('taux_cotisation', '1.00') }}">
                            @error('taux_cotisation')
                                <span class="invalid-feedback">{{ $message }}</span>
                            @enderror
                            <small class="form-text text-muted">Taux de cotisation par défaut : 1%</small>
                        </div>
                    </div>
                    <div class="card-footer">
                        <button type="submit" class="btn btn-success">
                            <i class="fas fa-save"></i> Enregistrer l'affiliation
                        </button>
                        <a href="{{ route('affiliations.index') }}" class="btn btn-secondary">
                            <i class="fas fa-times"></i> Annuler
                        </a>
                    </div>
                </form>
            </div>
        </div>
    </div>
@endsection
