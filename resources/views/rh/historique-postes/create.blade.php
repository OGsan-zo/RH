@extends('layouts.adminlte')

@section('title', 'Ajouter Historique Poste')
@section('page-title', 'Ajouter Historique Poste')

@section('breadcrumb')
    <li class="breadcrumb-item"><a href="{{ route('historique-postes.index') }}">Historique</a></li>
    <li class="breadcrumb-item active">Ajouter</li>
@endsection

@section('sidebar')
    @include('layouts.partials.sidebar-rh')
@endsection

@section('content')
    <div class="card">
        <div class="card-header">
            <h3 class="card-title">Nouvel Historique Poste</h3>
        </div>
        <form action="{{ route('historique-postes.store') }}" method="POST">
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
                            <label for="type_mouvement_id">Type de Mouvement <span class="text-danger">*</span></label>
                            <select class="form-control @error('type_mouvement_id') is-invalid @enderror" id="type_mouvement_id" name="type_mouvement_id" required>
                                <option value="">-- Sélectionner --</option>
                                @foreach($types as $type)
                                    <option value="{{ $type->id }}" {{ old('type_mouvement_id') == $type->id ? 'selected' : '' }}>
                                        {{ ucfirst($type->libelle) }}
                                    </option>
                                @endforeach
                            </select>
                            @error('type_mouvement_id')<span class="invalid-feedback">{{ $message }}</span>@enderror
                        </div>
                    </div>
                </div>

                <div class="row">
                    <div class="col-md-6">
                        <div class="form-group">
                            <label for="poste_id">Poste</label>
                            <select class="form-control @error('poste_id') is-invalid @enderror" id="poste_id" name="poste_id">
                                <option value="">-- Sélectionner --</option>
                                @foreach($postes as $poste)
                                    <option value="{{ $poste->id }}" {{ old('poste_id') == $poste->id ? 'selected' : '' }}>
                                        {{ $poste->titre }}
                                    </option>
                                @endforeach
                            </select>
                            @error('poste_id')<span class="invalid-feedback">{{ $message }}</span>@enderror
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="form-group">
                            <label for="titre_poste">Titre du Poste</label>
                            <input type="text" class="form-control @error('titre_poste') is-invalid @enderror" id="titre_poste" name="titre_poste" value="{{ old('titre_poste') }}">
                            @error('titre_poste')<span class="invalid-feedback">{{ $message }}</span>@enderror
                        </div>
                    </div>
                </div>

                <div class="row">
                    <div class="col-md-6">
                        <div class="form-group">
                            <label for="departement_id">Département</label>
                            <select class="form-control @error('departement_id') is-invalid @enderror" id="departement_id" name="departement_id">
                                <option value="">-- Sélectionner --</option>
                                @foreach($departements as $dept)
                                    <option value="{{ $dept->id }}" {{ old('departement_id') == $dept->id ? 'selected' : '' }}>
                                        {{ $dept->nom }}
                                    </option>
                                @endforeach
                            </select>
                            @error('departement_id')<span class="invalid-feedback">{{ $message }}</span>@enderror
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="form-group">
                            <label for="salaire">Salaire</label>
                            <input type="number" class="form-control @error('salaire') is-invalid @enderror" id="salaire" name="salaire" value="{{ old('salaire') }}" step="0.01" min="0">
                            @error('salaire')<span class="invalid-feedback">{{ $message }}</span>@enderror
                        </div>
                    </div>
                </div>

                <div class="row">
                    <div class="col-md-6">
                        <div class="form-group">
                            <label for="date_debut">Date Début <span class="text-danger">*</span></label>
                            <input type="date" class="form-control @error('date_debut') is-invalid @enderror" id="date_debut" name="date_debut" value="{{ old('date_debut') }}" required>
                            @error('date_debut')<span class="invalid-feedback">{{ $message }}</span>@enderror
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="form-group">
                            <label for="date_fin">Date Fin</label>
                            <input type="date" class="form-control @error('date_fin') is-invalid @enderror" id="date_fin" name="date_fin" value="{{ old('date_fin') }}">
                            @error('date_fin')<span class="invalid-feedback">{{ $message }}</span>@enderror
                        </div>
                    </div>
                </div>
            </div>

            <div class="card-footer">
                <button type="submit" class="btn btn-primary">
                    <i class="fas fa-save"></i> Ajouter
                </button>
                <a href="{{ route('historique-postes.index') }}" class="btn btn-secondary">
                    <i class="fas fa-times"></i> Annuler
                </a>
            </div>
        </form>
    </div>
@endsection
