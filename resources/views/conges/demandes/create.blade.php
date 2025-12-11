@extends('layouts.adminlte')

@section('title', 'Créer une Demande de Congé')
@section('page-title', 'Créer une Demande de Congé')

@section('breadcrumb')
    <li class="breadcrumb-item"><a href="{{ route('demandes-conges.index') }}">Demandes de Congés</a></li>
    <li class="breadcrumb-item active">Créer</li>
@endsection

@section('sidebar')
    @include('layouts.partials.sidebar-rh')
@endsection

@section('content')
<div class="card">
    <div class="card-header">
        <h3 class="card-title">Formulaire de Demande</h3>
    </div>
    <div class="card-body">
            <form action="{{ route('demandes-conges.store') }}" method="POST" enctype="multipart/form-data">
                @csrf

                <div class="form-group">
                    <label for="employe_id">Employé <span class="text-danger">*</span></label>
                    <select name="employe_id" id="employe_id" class="form-control @error('employe_id') is-invalid @enderror" required>
                        <option value="">-- Sélectionner un employé --</option>
                        @foreach($employes as $employe)
                            <option value="{{ $employe->id }}" {{ old('employe_id') == $employe->id ? 'selected' : '' }}>
                                {{ $employe->nom ?? 'N/A' }}
                            </option>
                        @endforeach
                    </select>
                    @error('employe_id')
                        <span class="invalid-feedback">{{ $message }}</span>
                    @enderror
                </div>

                <div class="form-group">
                    <label for="type_conge_id">Type de Congé <span class="text-danger">*</span></label>
                    <select name="type_conge_id" id="type_conge_id" class="form-control @error('type_conge_id') is-invalid @enderror" required>
                        <option value="">-- Sélectionner un type --</option>
                        @foreach($typesConges as $type)
                            <option value="{{ $type->id }}" {{ old('type_conge_id') == $type->id ? 'selected' : '' }}>
                                {{ $type->nom }}
                            </option>
                        @endforeach
                    </select>
                    @error('type_conge_id')
                        <span class="invalid-feedback">{{ $message }}</span>
                    @enderror
                </div>

                <div class="row">
                    <div class="col-md-6">
                        <div class="form-group">
                            <label for="date_debut">Date de Début <span class="text-danger">*</span></label>
                            <input type="date" name="date_debut" id="date_debut" class="form-control @error('date_debut') is-invalid @enderror" value="{{ old('date_debut') }}" required>
                            @error('date_debut')
                                <span class="invalid-feedback">{{ $message }}</span>
                            @enderror
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="form-group">
                            <label for="date_fin">Date de Fin <span class="text-danger">*</span></label>
                            <input type="date" name="date_fin" id="date_fin" class="form-control @error('date_fin') is-invalid @enderror" value="{{ old('date_fin') }}" required>
                            @error('date_fin')
                                <span class="invalid-feedback">{{ $message }}</span>
                            @enderror
                        </div>
                    </div>
                </div>

                <div class="form-group">
                    <label for="motif">Motif</label>
                    <textarea name="motif" id="motif" class="form-control @error('motif') is-invalid @enderror" rows="3">{{ old('motif') }}</textarea>
                    @error('motif')
                        <span class="invalid-feedback">{{ $message }}</span>
                    @enderror
                </div>

                <div class="form-group">
                    <label for="certificat_medical">Certificat Médical (si applicable)</label>
                    <input type="file" name="certificat_medical" id="certificat_medical" class="form-control @error('certificat_medical') is-invalid @enderror">
                    <small class="form-text text-muted">PDF, JPG, PNG (max 2MB)</small>
                    @error('certificat_medical')
                        <span class="invalid-feedback">{{ $message }}</span>
                    @enderror
                </div>

                <div class="form-group">
                    <button type="submit" class="btn btn-primary">
                        <i class="fas fa-save"></i> Créer la Demande
                    </button>
                    <a href="{{ route('demandes-conges.index') }}" class="btn btn-secondary">
                        <i class="fas fa-times"></i> Annuler
                    </a>
                </div>
            </form>
    </div>
</div>
@endsection
