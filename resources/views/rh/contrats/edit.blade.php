@extends('layouts.adminlte')

@section('title', 'Modifier / Renouveler le contrat')
@section('page-title', 'Renouvellement Contrat')

@section('breadcrumb')
    <li class="breadcrumb-item"><a href="{{ route('rh.dashboard') }}">Dashboard</a></li>
    <li class="breadcrumb-item"><a href="{{ route('contrats.index') }}">Contrats</a></li>
    <li class="breadcrumb-item active">Renouveler</li>
@endsection

@section('sidebar')
    @include('layouts.partials.sidebar-rh')
@endsection

@section('content')
    <div class="row">
        <div class="col-md-8 offset-md-2">
            <!-- Info Contrat -->
            <div class="card card-info">
                <div class="card-header">
                    <h3 class="card-title"><i class="fas fa-info-circle mr-2"></i>Informations du Contrat</h3>
                </div>
                <div class="card-body">
                    <dl class="row">
                        <dt class="col-sm-4"><i class="fas fa-user mr-1"></i>Employé :</dt>
                        <dd class="col-sm-8"><strong>{{ $contrat->candidature->candidat->nom }} {{ $contrat->candidature->candidat->prenom }}</strong></dd>

                        <dt class="col-sm-4"><i class="fas fa-briefcase mr-1"></i>Poste :</dt>
                        <dd class="col-sm-8">{{ $contrat->candidature->annonce->titre }}</dd>

                        <dt class="col-sm-4"><i class="fas fa-file-signature mr-1"></i>Type actuel :</dt>
                        <dd class="col-sm-8"><span class="badge badge-info">{{ strtoupper($contrat->type_contrat) }}</span></dd>

                        <dt class="col-sm-4"><i class="fas fa-sync-alt mr-1"></i>Renouvellements :</dt>
                        <dd class="col-sm-8"><span class="badge badge-secondary">{{ $contrat->renouvellement }}</span></dd>
                    </dl>
                </div>
            </div>

            <!-- Formulaire Renouvellement -->
            <div class="card card-warning">
                <div class="card-header">
                    <h3 class="card-title"><i class="fas fa-sync-alt mr-2"></i>Renouveler / Modifier le Contrat</h3>
                </div>
                <form method="POST" action="{{ route('contrats.edit', $contrat->id) }}">
                    @csrf
                    <div class="card-body">
                        <div class="form-group">
                            <label for="type_contrat"><i class="fas fa-file-signature mr-1"></i>Type de contrat <span class="text-danger">*</span></label>
                            <select name="type_contrat" id="type_contrat" class="form-control @error('type_contrat') is-invalid @enderror" required>
                                <option value="essai" {{ old('type_contrat', $contrat->type_contrat) === 'essai' ? 'selected' : '' }}>Essai</option>
                                <option value="CDD" {{ old('type_contrat', $contrat->type_contrat) === 'CDD' ? 'selected' : '' }}>CDD</option>
                                <option value="CDI" {{ old('type_contrat', $contrat->type_contrat) === 'CDI' ? 'selected' : '' }}>CDI</option>
                            </select>
                            @error('type_contrat')
                                <span class="invalid-feedback">{{ $message }}</span>
                            @enderror
                        </div>

                        <div class="form-group">
                            <label for="salaire"><i class="fas fa-money-bill-wave mr-1"></i>Salaire (Ar) <span class="text-danger">*</span></label>
                            <input type="number" 
                                   step="0.01" 
                                   name="salaire" 
                                   id="salaire"
                                   class="form-control @error('salaire') is-invalid @enderror"
                                   value="{{ old('salaire', $contrat->salaire) }}" 
                                   required>
                            @error('salaire')
                                <span class="invalid-feedback">{{ $message }}</span>
                            @enderror
                        </div>

                        <div class="form-group">
                            <label for="date_fin"><i class="far fa-calendar-alt mr-1"></i>Nouvelle date de fin</label>
                            <input type="date" 
                                   name="date_fin" 
                                   id="date_fin"
                                   class="form-control @error('date_fin') is-invalid @enderror"
                                   value="{{ old('date_fin', $contrat->date_fin) }}">
                            @error('date_fin')
                                <span class="invalid-feedback">{{ $message }}</span>
                            @enderror
                            <small class="form-text text-muted">Optionnel pour CDI</small>
                        </div>
                        
                        <div class="form-group">
                            <label for="statut"><i class="fas fa-info-circle mr-1"></i>Statut</label>
                            <select name="statut" id="statut" class="form-control">
                                @foreach(\App\Models\Contrat::STATUTS as $statut)
                                    <option value="{{ $statut }}" {{ old('statut', $contrat->statut) == $statut ? 'selected' : '' }}>
                                        {{ ucfirst(str_replace('_',' ', $statut)) }}
                                    </option>
                                @endforeach
                            </select>
                        </div>
                    </div>
                    <div class="card-footer">
                        <button type="submit" class="btn btn-success">
                            <i class="fas fa-save"></i> Enregistrer les modifications
                        </button>
                        <a href="{{ route('contrats.index') }}" class="btn btn-secondary">
                            <i class="fas fa-arrow-left"></i> Retour
                        </a>
                    </div>
                </form>
            </div>
        </div>
    </div>
@endsection
