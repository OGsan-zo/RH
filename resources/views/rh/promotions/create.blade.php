@extends('layouts.adminlte')

@section('title', 'Créer une Promotion')
@section('page-title', 'Créer une Promotion')

@section('breadcrumb')
    <li class="breadcrumb-item"><a href="{{ route('promotions.index') }}">Promotions</a></li>
    <li class="breadcrumb-item active">Créer</li>
@endsection

@section('sidebar')
    @include('layouts.partials.sidebar-rh')
@endsection

@section('content')
    <div class="card">
        <div class="card-header">
            <h3 class="card-title">Nouvelle Promotion</h3>
        </div>
        <form action="{{ route('promotions.store') }}" method="POST">
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
                </div>

                <div class="row">
                    <div class="col-md-6">
                        <div class="form-group">
                            <label for="nouveau_poste_id">Nouveau Poste <span class="text-danger">*</span></label>
                            <select class="form-control @error('nouveau_poste_id') is-invalid @enderror" id="nouveau_poste_id" name="nouveau_poste_id" required>
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
                    <div class="col-md-6"></div>
                </div>

                <div class="row">
                    <div class="col-md-6">
                        <div class="form-group">
                            <label for="ancien_salaire">Ancien Salaire</label>
                            <input type="number" class="form-control @error('ancien_salaire') is-invalid @enderror" id="ancien_salaire" name="ancien_salaire" value="{{ old('ancien_salaire') }}" step="0.01" min="0">
                            @error('ancien_salaire')<span class="invalid-feedback">{{ $message }}</span>@enderror
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="form-group">
                            <label for="nouveau_salaire">Nouveau Salaire <span class="text-danger">*</span></label>
                            <input type="number" class="form-control @error('nouveau_salaire') is-invalid @enderror" id="nouveau_salaire" name="nouveau_salaire" value="{{ old('nouveau_salaire') }}" step="0.01" min="0" required>
                            @error('nouveau_salaire')<span class="invalid-feedback">{{ $message }}</span>@enderror
                        </div>
                    </div>
                </div>

                <div class="row">
                    <div class="col-md-6">
                        <div class="form-group">
                            <label for="date_promotion">Date Promotion <span class="text-danger">*</span></label>
                            <input type="date" class="form-control @error('date_promotion') is-invalid @enderror" id="date_promotion" name="date_promotion" value="{{ old('date_promotion') }}" required>
                            @error('date_promotion')<span class="invalid-feedback">{{ $message }}</span>@enderror
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="form-group">
                            <label for="date_effet">Date d'Effet <span class="text-danger">*</span></label>
                            <input type="date" class="form-control @error('date_effet') is-invalid @enderror" id="date_effet" name="date_effet" value="{{ old('date_effet') }}" required>
                            @error('date_effet')<span class="invalid-feedback">{{ $message }}</span>@enderror
                        </div>
                    </div>
                </div>

                <div class="row">
                    <div class="col-md-6">
                        <div class="form-group">
                            <label for="decision_numero">Numéro de Décision</label>
                            <input type="text" class="form-control @error('decision_numero') is-invalid @enderror" id="decision_numero" name="decision_numero" value="{{ old('decision_numero') }}">
                            @error('decision_numero')<span class="invalid-feedback">{{ $message }}</span>@enderror
                        </div>
                    </div>
                    <div class="col-md-6"></div>
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
                <a href="{{ route('promotions.index') }}" class="btn btn-secondary">
                    <i class="fas fa-times"></i> Annuler
                </a>
            </div>
        </form>
    </div>
@endsection
