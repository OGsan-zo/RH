@extends('layouts.adminlte')

@section('title', 'Créer une Mobilité')
@section('page-title', 'Créer une Mobilité')

@section('breadcrumb')
    <li class="breadcrumb-item"><a href="{{ route('mobilites.index') }}">Mobilités</a></li>
    <li class="breadcrumb-item active">Créer</li>
@endsection

@section('sidebar')
    @include('layouts.partials.sidebar-rh')
@endsection

@section('content')
    <div class="card">
        <div class="card-header">
            <h3 class="card-title">Nouvelle Mobilité</h3>
        </div>
        <form action="{{ route('mobilites.store') }}" method="POST">
            @csrf
            <div class="card-body">
                <div class="row">
                    <div class="col-md-6">
                        <div class="form-group">
                            <label for="employe_id">Employé <span class="text-danger">*</span></label>
                            <select class="form-control @error('employe_id') is-invalid @enderror" id="employe_id" name="employe_id" required>
                                <option value="">-- Sélectionner --</option>
                                @foreach($employes as $employe)
                                    <option value="{{ $employe->id }}" {{ old('employe_id') == $employe->id ? 'selected' : '' }}>
                                        {{ $employe->candidat->nom }} {{ $employe->candidat->prenom }}
                                    </option>
                                @endforeach
                            </select>
                            @error('employe_id')<span class="invalid-feedback">{{ $message }}</span>@enderror
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="form-group">
                            <label for="type_mobilite_id">Type de Mobilité <span class="text-danger">*</span></label>
                            <select class="form-control @error('type_mobilite_id') is-invalid @enderror" id="type_mobilite_id" name="type_mobilite_id" required>
                                <option value="">-- Sélectionner --</option>
                                @foreach($types as $type)
                                    <option value="{{ $type->id }}" {{ old('type_mobilite_id') == $type->id ? 'selected' : '' }}>
                                        {{ ucfirst($type->libelle) }}
                                    </option>
                                @endforeach
                            </select>
                            @error('type_mobilite_id')<span class="invalid-feedback">{{ $message }}</span>@enderror
                        </div>
                    </div>
                </div>

                <div class="row">
                    <div class="col-md-6">
                        <div class="form-group">
                            <label for="ancien_departement_id">Ancien Département</label>
                            <select class="form-control @error('ancien_departement_id') is-invalid @enderror" id="ancien_departement_id" name="ancien_departement_id">
                                <option value="">-- Sélectionner --</option>
                                @foreach($departements as $dept)
                                    <option value="{{ $dept->id }}" {{ old('ancien_departement_id') == $dept->id ? 'selected' : '' }}>
                                        {{ $dept->nom }}
                                    </option>
                                @endforeach
                            </select>
                            @error('ancien_departement_id')<span class="invalid-feedback">{{ $message }}</span>@enderror
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="form-group">
                            <label for="nouveau_departement_id">Nouveau Département</label>
                            <select class="form-control @error('nouveau_departement_id') is-invalid @enderror" id="nouveau_departement_id" name="nouveau_departement_id">
                                <option value="">-- Sélectionner --</option>
                                @foreach($departements as $dept)
                                    <option value="{{ $dept->id }}" {{ old('nouveau_departement_id') == $dept->id ? 'selected' : '' }}>
                                        {{ $dept->nom }}
                                    </option>
                                @endforeach
                            </select>
                            @error('nouveau_departement_id')<span class="invalid-feedback">{{ $message }}</span>@enderror
                        </div>
                    </div>
                </div>

                <div class="row">
                    <div class="col-md-6">
                        <div class="form-group">
                            <label for="ancien_poste_id">Ancien Poste</label>
                            <select class="form-control @error('ancien_poste_id') is-invalid @enderror" id="ancien_poste_id" name="ancien_poste_id">
                                <option value="">-- Sélectionner --</option>
                                @foreach($postes as $poste)
                                    <option value="{{ $poste->id }}" {{ old('ancien_poste_id') == $poste->id ? 'selected' : '' }}>
                                        {{ $poste->titre }}
                                    </option>
                                @endforeach
                            </select>
                            @error('ancien_poste_id')<span class="invalid-feedback">{{ $message }}</span>@enderror
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="form-group">
                            <label for="nouveau_poste_id">Nouveau Poste</label>
                            <select class="form-control @error('nouveau_poste_id') is-invalid @enderror" id="nouveau_poste_id" name="nouveau_poste_id">
                                <option value="">-- Sélectionner --</option>
                                @foreach($postes as $poste)
                                    <option value="{{ $poste->id }}" {{ old('nouveau_poste_id') == $poste->id ? 'selected' : '' }}>
                                        {{ $poste->titre }}
                                    </option>
                                @endforeach
                            </select>
                            @error('nouveau_poste_id')<span class="invalid-feedback">{{ $message }}</span>@enderror
                        </div>
                    </div>
                </div>

                <div class="row">
                    <div class="col-md-6">
                        <div class="form-group">
                            <label for="date_demande">Date Demande <span class="text-danger">*</span></label>
                            <input type="date" class="form-control @error('date_demande') is-invalid @enderror" id="date_demande" name="date_demande" value="{{ old('date_demande') }}" required>
                            @error('date_demande')<span class="invalid-feedback">{{ $message }}</span>@enderror
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="form-group">
                            <label for="date_approbation">Date Approbation</label>
                            <input type="date" class="form-control @error('date_approbation') is-invalid @enderror" id="date_approbation" name="date_approbation" value="{{ old('date_approbation') }}">
                            @error('date_approbation')<span class="invalid-feedback">{{ $message }}</span>@enderror
                        </div>
                    </div>
                </div>

                <div class="row">
                    <div class="col-md-6">
                        <div class="form-group">
                            <label for="date_effet">Date d'Effet <span class="text-danger">*</span></label>
                            <input type="date" class="form-control @error('date_effet') is-invalid @enderror" id="date_effet" name="date_effet" value="{{ old('date_effet') }}" required>
                            @error('date_effet')<span class="invalid-feedback">{{ $message }}</span>@enderror
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="form-group">
                            <label for="statut_id">Statut</label>
                            <select class="form-control @error('statut_id') is-invalid @enderror" id="statut_id" name="statut_id">
                                <option value="">-- Sélectionner --</option>
                                @foreach($statuts as $statut)
                                    <option value="{{ $statut->id }}" {{ old('statut_id') == $statut->id ? 'selected' : '' }}>
                                        {{ ucfirst($statut->libelle) }}
                                    </option>
                                @endforeach
                            </select>
                            @error('statut_id')<span class="invalid-feedback">{{ $message }}</span>@enderror
                        </div>
                    </div>
                </div>

                <div class="form-group">
                    <label for="motif">Motif</label>
                    <textarea class="form-control @error('motif') is-invalid @enderror" id="motif" name="motif" rows="3">{{ old('motif') }}</textarea>
                    @error('motif')<span class="invalid-feedback">{{ $message }}</span>@enderror
                </div>
            </div>

            <div class="card-footer">
                <button type="submit" class="btn btn-primary">
                    <i class="fas fa-save"></i> Créer
                </button>
                <a href="{{ route('mobilites.index') }}" class="btn btn-secondary">
                    <i class="fas fa-times"></i> Annuler
                </a>
            </div>
        </form>
    </div>
@endsection
