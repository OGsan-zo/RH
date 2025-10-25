@extends('layouts.adminlte')

@section('title', 'Modifier un département')
@section('page-title', 'Modifier le Département')

@section('breadcrumb')
    <li class="breadcrumb-item"><a href="{{ route('rh.dashboard') }}">Dashboard</a></li>
    <li class="breadcrumb-item"><a href="{{ route('departements.index') }}">Départements</a></li>
    <li class="breadcrumb-item active">Modifier</li>
@endsection

@section('sidebar')
    @include('layouts.partials.sidebar-rh')
@endsection

@section('content')
    <div class="row">
        <div class="col-md-6">
            <div class="card card-warning">
                <div class="card-header">
                    <h3 class="card-title"><i class="fas fa-edit mr-2"></i>Modifier le Département</h3>
                </div>
                <form method="POST" action="{{ route('departements.update', $departement->id) }}">
                    @csrf
                    <div class="card-body">
                        <div class="form-group">
                            <label for="nom"><i class="fas fa-building mr-1"></i>Nom du département <span class="text-danger">*</span></label>
                            <input type="text" 
                                   name="nom" 
                                   id="nom"
                                   class="form-control @error('nom') is-invalid @enderror" 
                                   value="{{ old('nom', $departement->nom) }}"
                                   required 
                                   maxlength="150">
                            @error('nom')
                                <span class="invalid-feedback">{{ $message }}</span>
                            @enderror
                            <small class="form-text text-muted">Maximum 150 caractères</small>
                        </div>
                    </div>
                    <div class="card-footer">
                        <button type="submit" class="btn btn-primary">
                            <i class="fas fa-save"></i> Mettre à jour
                        </button>
                        <a href="{{ route('departements.index') }}" class="btn btn-secondary">
                            <i class="fas fa-arrow-left"></i> Retour
                        </a>
                    </div>
                </form>
            </div>
        </div>
    </div>
@endsection
