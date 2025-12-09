@extends('layouts.adminlte')

@section('title', 'Créer une Fiche Employé')
@section('page-title', 'Créer une Fiche Employé')

@section('breadcrumb')
    <li class="breadcrumb-item"><a href="{{ route('fiches-employes.index') }}">Fiches Employés</a></li>
    <li class="breadcrumb-item active">Créer</li>
@endsection

@section('sidebar')
    @include('layouts.partials.sidebar-rh')
@endsection

@section('content')
    <div class="card">
        <div class="card-header">
            <h3 class="card-title">Nouvelle Fiche Employé</h3>
        </div>
        <form action="{{ route('fiches-employes.store') }}" method="POST">
            @csrf
            <div class="card-body">
                <div class="row">
                    <div class="col-md-6">
                        <div class="form-group">
                            <label for="employe_id">Employé <span class="text-danger">*</span></label>
                            <select class="form-control @error('employe_id') is-invalid @enderror" id="employe_id" name="employe_id" required>
                                <option value="">-- Sélectionner un employé --</option>
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
                            <label for="cin">CIN</label>
                            <input type="text" class="form-control @error('cin') is-invalid @enderror" id="cin" name="cin" value="{{ old('cin') }}">
                            @error('cin')<span class="invalid-feedback">{{ $message }}</span>@enderror
                        </div>
                    </div>
                </div>

                <div class="row">
                    <div class="col-md-6">
                        <div class="form-group">
                            <label for="date_naissance">Date de Naissance</label>
                            <input type="date" class="form-control @error('date_naissance') is-invalid @enderror" id="date_naissance" name="date_naissance" value="{{ old('date_naissance') }}">
                            @error('date_naissance')<span class="invalid-feedback">{{ $message }}</span>@enderror
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="form-group">
                            <label for="lieu_naissance">Lieu de Naissance</label>
                            <input type="text" class="form-control @error('lieu_naissance') is-invalid @enderror" id="lieu_naissance" name="lieu_naissance" value="{{ old('lieu_naissance') }}">
                            @error('lieu_naissance')<span class="invalid-feedback">{{ $message }}</span>@enderror
                        </div>
                    </div>
                </div>

                <div class="row">
                    <div class="col-md-6">
                        <div class="form-group">
                            <label for="nationalite">Nationalité</label>
                            <input type="text" class="form-control @error('nationalite') is-invalid @enderror" id="nationalite" name="nationalite" value="{{ old('nationalite') }}">
                            @error('nationalite')<span class="invalid-feedback">{{ $message }}</span>@enderror
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="form-group">
                            <label for="situation_matrimoniale_id">Situation Matrimoniale</label>
                            <select class="form-control @error('situation_matrimoniale_id') is-invalid @enderror" id="situation_matrimoniale_id" name="situation_matrimoniale_id">
                                <option value="">-- Sélectionner --</option>
                                @foreach($situations as $situation)
                                    <option value="{{ $situation->id }}" {{ old('situation_matrimoniale_id') == $situation->id ? 'selected' : '' }}>
                                        {{ ucfirst($situation->libelle) }}
                                    </option>
                                @endforeach
                            </select>
                            @error('situation_matrimoniale_id')<span class="invalid-feedback">{{ $message }}</span>@enderror
                        </div>
                    </div>
                </div>

                <div class="row">
                    <div class="col-md-6">
                        <div class="form-group">
                            <label for="nombre_enfants">Nombre d'Enfants</label>
                            <input type="number" class="form-control @error('nombre_enfants') is-invalid @enderror" id="nombre_enfants" name="nombre_enfants" value="{{ old('nombre_enfants', 0) }}" min="0">
                            @error('nombre_enfants')<span class="invalid-feedback">{{ $message }}</span>@enderror
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="form-group">
                            <label for="poste_id">Poste</label>
                            <select class="form-control @error('poste_id') is-invalid @enderror" id="poste_id" name="poste_id">
                                <option value="">-- Sélectionner un poste --</option>
                                @foreach($postes as $poste)
                                    <option value="{{ $poste->id }}" {{ old('poste_id') == $poste->id ? 'selected' : '' }}>
                                        {{ $poste->titre }}
                                    </option>
                                @endforeach
                            </select>
                            @error('poste_id')<span class="invalid-feedback">{{ $message }}</span>@enderror
                        </div>
                    </div>
                </div>

                <div class="row">
                    <div class="col-md-6">
                        <div class="form-group">
                            <label for="telephone">Téléphone</label>
                            <input type="text" class="form-control @error('telephone') is-invalid @enderror" id="telephone" name="telephone" value="{{ old('telephone') }}">
                            @error('telephone')<span class="invalid-feedback">{{ $message }}</span>@enderror
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="form-group">
                            <label for="telephone_secondaire">Téléphone Secondaire</label>
                            <input type="text" class="form-control @error('telephone_secondaire') is-invalid @enderror" id="telephone_secondaire" name="telephone_secondaire" value="{{ old('telephone_secondaire') }}">
                            @error('telephone_secondaire')<span class="invalid-feedback">{{ $message }}</span>@enderror
                        </div>
                    </div>
                </div>

                <div class="row">
                    <div class="col-md-12">
                        <div class="form-group">
                            <label for="adresse_personnelle">Adresse Personnelle</label>
                            <textarea class="form-control @error('adresse_personnelle') is-invalid @enderror" id="adresse_personnelle" name="adresse_personnelle" rows="3">{{ old('adresse_personnelle') }}</textarea>
                            @error('adresse_personnelle')<span class="invalid-feedback">{{ $message }}</span>@enderror
                        </div>
                    </div>
                </div>

                <div class="row">
                    <div class="col-md-6">
                        <div class="form-group">
                            <label for="ville">Ville</label>
                            <input type="text" class="form-control @error('ville') is-invalid @enderror" id="ville" name="ville" value="{{ old('ville') }}">
                            @error('ville')<span class="invalid-feedback">{{ $message }}</span>@enderror
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="form-group">
                            <label for="code_postal">Code Postal</label>
                            <input type="text" class="form-control @error('code_postal') is-invalid @enderror" id="code_postal" name="code_postal" value="{{ old('code_postal') }}">
                            @error('code_postal')<span class="invalid-feedback">{{ $message }}</span>@enderror
                        </div>
                    </div>
                </div>

                <div class="row">
                    <div class="col-md-6">
                        <div class="form-group">
                            <label for="date_embauche">Date d'Embauche <span class="text-danger">*</span></label>
                            <input type="date" class="form-control @error('date_embauche') is-invalid @enderror" id="date_embauche" name="date_embauche" value="{{ old('date_embauche') }}" required>
                            @error('date_embauche')<span class="invalid-feedback">{{ $message }}</span>@enderror
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="form-group">
                            <label for="date_fin_prevue">Date de Fin Prévue</label>
                            <input type="date" class="form-control @error('date_fin_prevue') is-invalid @enderror" id="date_fin_prevue" name="date_fin_prevue" value="{{ old('date_fin_prevue') }}">
                            @error('date_fin_prevue')<span class="invalid-feedback">{{ $message }}</span>@enderror
                        </div>
                    </div>
                </div>

                <div class="row">
                    <div class="col-md-6">
                        <div class="form-group">
                            <label for="iban">IBAN</label>
                            <input type="text" class="form-control @error('iban') is-invalid @enderror" id="iban" name="iban" value="{{ old('iban') }}">
                            @error('iban')<span class="invalid-feedback">{{ $message }}</span>@enderror
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="form-group">
                            <label for="bic">BIC</label>
                            <input type="text" class="form-control @error('bic') is-invalid @enderror" id="bic" name="bic" value="{{ old('bic') }}">
                            @error('bic')<span class="invalid-feedback">{{ $message }}</span>@enderror
                        </div>
                    </div>
                </div>

                <div class="form-group">
                    <label for="titulaire_compte">Titulaire du Compte</label>
                    <input type="text" class="form-control @error('titulaire_compte') is-invalid @enderror" id="titulaire_compte" name="titulaire_compte" value="{{ old('titulaire_compte') }}">
                    @error('titulaire_compte')<span class="invalid-feedback">{{ $message }}</span>@enderror
                </div>
            </div>

            <div class="card-footer">
                <button type="submit" class="btn btn-primary">
                    <i class="fas fa-save"></i> Créer la Fiche
                </button>
                <a href="{{ route('fiches-employes.index') }}" class="btn btn-secondary">
                    <i class="fas fa-times"></i> Annuler
                </a>
            </div>
        </form>
    </div>
@endsection
