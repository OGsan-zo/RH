@extends('layouts.adminlte')

@section('title', 'Détails de la Demande')
@section('page-title', 'Détails de la Demande de Congé')

@section('breadcrumb')
    <li class="breadcrumb-item"><a href="{{ route('demandes-conges.index') }}">Demandes de Congés</a></li>
    <li class="breadcrumb-item active">Détails</li>
@endsection

@section('sidebar')
    @include('layouts.partials.sidebar-rh')
@endsection

@section('content')

    @if(session('success'))
        <div class="alert alert-success alert-dismissible fade show" role="alert">
            {{ session('success') }}
            <button type="button" class="close" data-dismiss="alert"><span>&times;</span></button>
        </div>
    @endif

    <div class="row">
        <div class="col-md-8">
            <div class="card mb-3">
                <div class="card-header bg-primary text-white">
                    <h5 class="mb-0">Informations de la Demande</h5>
                </div>
                <div class="card-body">
                    <div class="row mb-3">
                        <div class="col-md-6">
                            <strong>Employé :</strong>
                            <p>{{ $demandeCongé->employe->nom ?? 'N/A' }}</p>
                        </div>
                        <div class="col-md-6">
                            <strong>Type de Congé :</strong>
                            <p>{{ $demandeCongé->typeCongé->nom ?? 'N/A' }}</p>
                        </div>
                    </div>

                    <div class="row mb-3">
                        <div class="col-md-6">
                            <strong>Date de Début :</strong>
                            <p>{{ \Carbon\Carbon::parse($demandeCongé->date_debut)->format('d/m/Y') }}</p>
                        </div>
                        <div class="col-md-6">
                            <strong>Date de Fin :</strong>
                            <p>{{ \Carbon\Carbon::parse($demandeCongé->date_fin)->format('d/m/Y') }}</p>
                        </div>
                    </div>

                    <div class="row mb-3">
                        <div class="col-md-6">
                            <strong>Nombre de Jours :</strong>
                            <p><span class="badge badge-info">{{ $demandeCongé->nombre_jours }}</span></p>
                        </div>
                        <div class="col-md-6">
                            <strong>Statut :</strong>
                            <p>
                                @if($demandeCongé->estEnAttente())
                                    <span class="badge badge-warning">En attente</span>
                                @elseif($demandeCongé->estApprouvee())
                                    <span class="badge badge-success">Approuvée</span>
                                @elseif($demandeCongé->estRejetee())
                                    <span class="badge badge-danger">Rejetée</span>
                                @else
                                    <span class="badge badge-secondary">Annulée</span>
                                @endif
                            </p>
                        </div>
                    </div>

                    @if($demandeCongé->motif)
                        <div class="mb-3">
                            <strong>Motif :</strong>
                            <p>{{ $demandeCongé->motif }}</p>
                        </div>
                    @endif

                    @if($demandeCongé->certificat_medical_path)
                        <div class="mb-3">
                            <strong>Certificat Médical :</strong>
                            <p>
                                <a href="{{ asset('storage/' . $demandeCongé->certificat_medical_path) }}" target="_blank" class="btn btn-sm btn-info">
                                    <i class="fas fa-download"></i> Télécharger
                                </a>
                            </p>
                        </div>
                    @endif
                </div>
            </div>

            @if($demandeCongé->estEnAttente())
                <div class="card">
                    <div class="card-header bg-warning text-dark">
                        <h5 class="mb-0">Actions de Validation</h5>
                    </div>
                    <div class="card-body">
                        <div class="row">
                            <div class="col-md-6">
                                <form action="{{ route('demandes-conges.approuver', $demandeCongé->id) }}" method="POST">
                                    @csrf
                                    <div class="form-group">
                                        <label for="commentaire_approuver">Commentaire (optionnel)</label>
                                        <textarea name="commentaire_validation" id="commentaire_approuver" class="form-control" rows="3"></textarea>
                                    </div>
                                    <button type="submit" class="btn btn-success btn-block">
                                        <i class="fas fa-check"></i> Approuver
                                    </button>
                                </form>
                            </div>
                            <div class="col-md-6">
                                <form action="{{ route('demandes-conges.rejeter', $demandeCongé->id) }}" method="POST">
                                    @csrf
                                    <div class="form-group">
                                        <label for="commentaire_rejeter">Motif du Rejet <span class="text-danger">*</span></label>
                                        <textarea name="commentaire_validation" id="commentaire_rejeter" class="form-control" rows="3" required></textarea>
                                    </div>
                                    <button type="submit" class="btn btn-danger btn-block">
                                        <i class="fas fa-times"></i> Rejeter
                                    </button>
                                </form>
                            </div>
                        </div>
                    </div>
                </div>
            @endif
        </div>

        <div class="col-md-4">
            <div class="card">
                <div class="card-header bg-info text-white">
                    <h5 class="mb-0">Historique de Validation</h5>
                </div>
                <div class="card-body">
                    @if($demandeCongé->date_validation)
                        <div class="mb-3">
                            <strong>Validé par :</strong>
                            <p>{{ $demandeCongé->validateur->name ?? 'N/A' }}</p>
                        </div>

                        <div class="mb-3">
                            <strong>Date de Validation :</strong>
                            <p>{{ \Carbon\Carbon::parse($demandeCongé->date_validation)->format('d/m/Y H:i') }}</p>
                        </div>

                        @if($demandeCongé->commentaire_validation)
                            <div class="mb-3">
                                <strong>Commentaire :</strong>
                                <p>{{ $demandeCongé->commentaire_validation }}</p>
                            </div>
                        @endif
                    @else
                        <p class="text-muted">En attente de validation</p>
                    @endif
                </div>
            </div>

            @if($demandeCongé->estEnAttente())
                <div class="card mt-3">
                    <div class="card-body">
                        <a href="{{ route('demandes-conges.edit', $demandeCongé->id) }}" class="btn btn-warning btn-block mb-2">
                            <i class="fas fa-edit"></i> Modifier
                        </a>
                        <form action="{{ route('demandes-conges.destroy', $demandeCongé->id) }}" method="POST" style="display:inline;">
                            @csrf
                            @method('DELETE')
                            <button type="submit" class="btn btn-danger btn-block" onclick="return confirm('Êtes-vous sûr ?')">
                                <i class="fas fa-trash"></i> Supprimer
                            </button>
                        </form>
                    </div>
                </div>
            @endif
        </div>
    </div>
@endsection
