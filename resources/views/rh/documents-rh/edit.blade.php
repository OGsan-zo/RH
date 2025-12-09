@extends('layouts.adminlte')

@section('title', 'Modifier Document RH')
@section('page-title', 'Modifier Document RH')

@section('breadcrumb')
    <li class="breadcrumb-item"><a href="{{ route('documents-rh.index') }}">Documents RH</a></li>
    <li class="breadcrumb-item active">Modifier</li>
@endsection

@section('sidebar')
    @include('layouts.partials.sidebar-rh')
@endsection

@section('content')
    <div class="card">
        <div class="card-header">
            <h3 class="card-title">Modifier Document RH</h3>
        </div>
        <form action="{{ route('documents-rh.update', $document->id) }}" method="POST">
            @csrf
            <div class="card-body">
                <div class="row">
                    <div class="col-md-6">
                        <div class="form-group">
                            <label for="type_document_id">Type de Document <span class="text-danger">*</span></label>
                            <select class="form-control @error('type_document_id') is-invalid @enderror" id="type_document_id" name="type_document_id" required>
                                <option value="">-- Sélectionner --</option>
                                @foreach($types as $type)
                                    <option value="{{ $type->id }}" {{ old('type_document_id', $document->type_document_id) == $type->id ? 'selected' : '' }}>
                                        {{ $type->libelle }}
                                    </option>
                                @endforeach
                            </select>
                            @error('type_document_id')<span class="invalid-feedback">{{ $message }}</span>@enderror
                        </div>
                    </div>
                    <div class="col-md-6"></div>
                </div>

                <div class="row">
                    <div class="col-md-6">
                        <div class="form-group">
                            <label for="nom_fichier">Nom du Fichier <span class="text-danger">*</span></label>
                            <input type="text" class="form-control @error('nom_fichier') is-invalid @enderror" id="nom_fichier" name="nom_fichier" value="{{ old('nom_fichier', $document->nom_fichier) }}" required>
                            @error('nom_fichier')<span class="invalid-feedback">{{ $message }}</span>@enderror
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="form-group">
                            <label for="chemin_fichier">Chemin du Fichier <span class="text-danger">*</span></label>
                            <input type="text" class="form-control @error('chemin_fichier') is-invalid @enderror" id="chemin_fichier" name="chemin_fichier" value="{{ old('chemin_fichier', $document->chemin_fichier) }}" required>
                            @error('chemin_fichier')<span class="invalid-feedback">{{ $message }}</span>@enderror
                        </div>
                    </div>
                </div>

                <div class="row">
                    <div class="col-md-6">
                        <div class="form-group">
                            <label for="type_mime">Type MIME</label>
                            <input type="text" class="form-control @error('type_mime') is-invalid @enderror" id="type_mime" name="type_mime" value="{{ old('type_mime', $document->type_mime) }}">
                            @error('type_mime')<span class="invalid-feedback">{{ $message }}</span>@enderror
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="form-group">
                            <label for="taille_bytes">Taille (bytes)</label>
                            <input type="number" class="form-control @error('taille_bytes') is-invalid @enderror" id="taille_bytes" name="taille_bytes" value="{{ old('taille_bytes', $document->taille_bytes) }}" min="0">
                            @error('taille_bytes')<span class="invalid-feedback">{{ $message }}</span>@enderror
                        </div>
                    </div>
                </div>

                <div class="row">
                    <div class="col-md-6">
                        <div class="form-group">
                            <label for="date_emission">Date d'Émission</label>
                            <input type="date" class="form-control @error('date_emission') is-invalid @enderror" id="date_emission" name="date_emission" value="{{ old('date_emission', $document->date_emission) }}">
                            @error('date_emission')<span class="invalid-feedback">{{ $message }}</span>@enderror
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="form-group">
                            <label for="date_expiration">Date d'Expiration</label>
                            <input type="date" class="form-control @error('date_expiration') is-invalid @enderror" id="date_expiration" name="date_expiration" value="{{ old('date_expiration', $document->date_expiration) }}">
                            @error('date_expiration')<span class="invalid-feedback">{{ $message }}</span>@enderror
                        </div>
                    </div>
                </div>

                <div class="row">
                    <div class="col-md-6">
                        <div class="form-group">
                            <label for="valide">
                                <input type="checkbox" id="valide" name="valide" value="1" {{ old('valide', $document->valide) ? 'checked' : '' }}>
                                Document Valide
                            </label>
                        </div>
                    </div>
                    <div class="col-md-6"></div>
                </div>

                <div class="form-group">
                    <label for="remarques">Remarques</label>
                    <textarea class="form-control @error('remarques') is-invalid @enderror" id="remarques" name="remarques" rows="3">{{ old('remarques', $document->remarques) }}</textarea>
                    @error('remarques')<span class="invalid-feedback">{{ $message }}</span>@enderror
                </div>
            </div>

            <div class="card-footer">
                <button type="submit" class="btn btn-primary">
                    <i class="fas fa-save"></i> Mettre à Jour
                </button>
                <a href="{{ route('documents-rh.index') }}" class="btn btn-secondary">
                    <i class="fas fa-times"></i> Annuler
                </a>
            </div>
        </form>
    </div>
@endsection
