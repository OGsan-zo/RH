@extends('layouts.adminlte')

@section('title', 'Modifier une Demande')
@section('page-title', 'Modifier une Demande de Congé')

@section('breadcrumb')
    <li class="breadcrumb-item"><a href="{{ route('demandes-conges.index') }}">Demandes de Congés</a></li>
    <li class="breadcrumb-item active">Modifier</li>
@endsection

@section('sidebar')
    @include('layouts.partials.sidebar-rh')
@endsection

@section('content')
<div class="card">
    <div class="card-header">
        <h3 class="card-title">Formulaire de Modification</h3>
    </div>
        <div class="card-body">
            <form action="{{ route('demandes-conges.update', $demandeCongé->id) }}" method="POST" enctype="multipart/form-data">
                @csrf
                @method('PUT')

                <div class="form-group">
                    <label>Employé</label>
                    <input type="text" class="form-control" value="{{ $demandeCongé->employe->nom ?? 'N/A' }}" disabled>
                </div>

                <div class="form-group">
                    <label>Type de Congé</label>
                    <input type="text" class="form-control" value="{{ $demandeCongé->typeCongé->nom ?? 'N/A' }}" disabled>
                </div>

                <div class="row">
                    <div class="col-md-6">
                        <div class="form-group">
                            <label for="date_debut">Date de Début <span class="text-danger">*</span></label>
                            <input type="date" name="date_debut" class="form-control @error('date_debut') is-invalid @enderror" value="{{ $demandeCongé->date_debut }}" required>
                            @error('date_debut')<span class="invalid-feedback">{{ $message }}</span>@enderror
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="form-group">
                            <label for="date_fin">Date de Fin <span class="text-danger">*</span></label>
                            <input type="date" name="date_fin" class="form-control @error('date_fin') is-invalid @enderror" value="{{ $demandeCongé->date_fin }}" required>
                            @error('date_fin')<span class="invalid-feedback">{{ $message }}</span>@enderror
                        </div>
                    </div>
                </div>

                <div class="form-group">
                    <label for="motif">Motif</label>
                    <textarea name="motif" class="form-control @error('motif') is-invalid @enderror" rows="3">{{ $demandeCongé->motif }}</textarea>
                    @error('motif')<span class="invalid-feedback">{{ $message }}</span>@enderror
                </div>

                <div class="form-group">
                    <label for="certificat_medical">Certificat Médical</label>
                    @if($demandeCongé->certificat_medical_path)
                        <div class="mb-2">
                            <a href="{{ asset('storage/' . $demandeCongé->certificat_medical_path) }}" target="_blank" class="btn btn-sm btn-info">
                                <i class="fas fa-download"></i> Télécharger le certificat actuel
                            </a>
                        </div>
                    @endif
                    <input type="file" name="certificat_medical" class="form-control @error('certificat_medical') is-invalid @enderror">
                    <small class="form-text text-muted">PDF, JPG, PNG (max 2MB)</small>
                    @error('certificat_medical')<span class="invalid-feedback">{{ $message }}</span>@enderror
                </div>

                <div class="form-group">
                    <button type="submit" class="btn btn-primary">
                        <i class="fas fa-save"></i> Mettre à jour
                    </button>
                    <a href="{{ route('demandes-conges.show', $demandeCongé->id) }}" class="btn btn-secondary">
                        <i class="fas fa-times"></i> Annuler
                    </a>
                </div>
            </form>
        </div>
    </div>
@endsection
