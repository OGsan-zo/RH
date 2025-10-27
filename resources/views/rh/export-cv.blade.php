@extends('layouts.adminlte')

@section('title', 'Export des CV')
@section('page-title', 'Export des CV en Excel')

@section('breadcrumb')
    <li class="breadcrumb-item"><a href="{{ route('rh.dashboard') }}">Dashboard</a></li>
    <li class="breadcrumb-item active">Export CV</li>
@endsection

@section('sidebar')
    @include('layouts.partials.sidebar-rh')
@endsection

@section('content')
    <!-- Info boxes -->
    <div class="row">
        <!-- Total candidats -->
        <div class="col-12 col-sm-6 col-md-3">
            <div class="info-box">
                <span class="info-box-icon bg-info elevation-1"><i class="fas fa-users"></i></span>
                <div class="info-box-content">
                    <span class="info-box-text">Total Candidats</span>
                    <span class="info-box-number">{{ $stats['total_candidats'] }}</span>
                </div>
            </div>
        </div>

        <!-- CV disponibles -->
        <div class="col-12 col-sm-6 col-md-3">
            <div class="info-box">
                <span class="info-box-icon bg-success elevation-1"><i class="fas fa-file-pdf"></i></span>
                <div class="info-box-content">
                    <span class="info-box-text">CV Disponibles</span>
                    <span class="info-box-number">{{ $stats['cv_disponibles'] }}</span>
                </div>
            </div>
        </div>

        <!-- CV manquants -->
        <div class="col-12 col-sm-6 col-md-3">
            <div class="info-box">
                <span class="info-box-icon bg-warning elevation-1"><i class="fas fa-exclamation-triangle"></i></span>
                <div class="info-box-content">
                    <span class="info-box-text">CV Manquants</span>
                    <span class="info-box-number">{{ $stats['cv_manquants'] }}</span>
                </div>
            </div>
        </div>

        <!-- Total candidatures -->
        <div class="col-12 col-sm-6 col-md-3">
            <div class="info-box">
                <span class="info-box-icon bg-primary elevation-1"><i class="fas fa-clipboard-list"></i></span>
                <div class="info-box-content">
                    <span class="info-box-text">Candidatures</span>
                    <span class="info-box-number">{{ $stats['candidatures_total'] }}</span>
                </div>
            </div>
        </div>
    </div>

    <!-- Carte principale -->
    <div class="row">
        <div class="col-12">
            <div class="card card-success">
                <div class="card-header">
                    <h3 class="card-title">
                        <i class="fas fa-file-excel mr-2"></i>
                        Exporter les données des candidats
                    </h3>
                </div>
                <div class="card-body">
                    <div class="row">
                        <div class="col-md-8">
                            <h5 class="mb-3">📊 Contenu de l'export Excel</h5>
                            <p class="text-muted">Le fichier Excel contiendra les informations suivantes pour chaque candidat :</p>
                            
                            <div class="row">
                                <div class="col-md-6">
                                    <ul class="list-unstyled">
                                        <li><i class="fas fa-check text-success mr-2"></i> Informations personnelles (Nom, Prénom, Email)</li>
                                        <li><i class="fas fa-check text-success mr-2"></i> Date de naissance et âge</li>
                                        <li><i class="fas fa-check text-success mr-2"></i> Compétences extraites</li>
                                        <li><i class="fas fa-check text-success mr-2"></i> Statut du candidat</li>
                                    </ul>
                                </div>
                                <div class="col-md-6">
                                    <ul class="list-unstyled">
                                        <li><i class="fas fa-check text-success mr-2"></i> Disponibilité du CV (Oui/Non)</li>
                                        <li><i class="fas fa-check text-success mr-2"></i> Chemin du fichier CV</li>
                                        <li><i class="fas fa-check text-success mr-2"></i> Historique des candidatures</li>
                                        <li><i class="fas fa-check text-success mr-2"></i> Notes et statuts des candidatures</li>
                                    </ul>
                                </div>
                            </div>

                            <div class="callout callout-info mt-3">
                                <h5><i class="icon fas fa-info"></i> Note importante</h5>
                                <p class="mb-0">
                                    Si un CV n'est pas trouvé dans le système, il sera marqué comme "Non disponible" 
                                    mais toutes les autres données du candidat seront incluses dans l'export.
                                </p>
                            </div>
                        </div>

                        <div class="col-md-4">
                            <div class="card bg-light">
                                <div class="card-body text-center">
                                    <i class="fas fa-file-excel fa-5x text-success mb-3"></i>
                                    <h5>Prêt à exporter ?</h5>
                                    <p class="text-muted">
                                        Cliquez sur le bouton ci-dessous pour télécharger le fichier Excel contenant 
                                        toutes les données des {{ $stats['total_candidats'] }} candidats.
                                    </p>
                                    <a href="{{ route('export.cv.download') }}" class="btn btn-success btn-lg">
                                        <i class="fas fa-download mr-2"></i>
                                        Télécharger l'Excel
                                    </a>
                                    <p class="text-muted mt-3 small">
                                        <i class="fas fa-clock mr-1"></i>
                                        Format : XLSX<br>
                                        Nom : export_cv_candidats_[date].xlsx
                                    </p>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Prévisualisation -->
    <div class="row">
        <div class="col-12">
            <div class="card">
                <div class="card-header">
                    <h3 class="card-title">
                        <i class="fas fa-eye mr-2"></i>
                        Aperçu des données (10 derniers candidats)
                    </h3>
                </div>
                <div class="card-body p-0">
                    <div class="table-responsive">
                        <table class="table table-striped table-hover m-0">
                            <thead>
                                <tr>
                                    <th>ID</th>
                                    <th>Nom complet</th>
                                    <th>Email</th>
                                    <th>Compétences</th>
                                    <th>CV</th>
                                    <th>Statut</th>
                                    <th>Candidatures</th>
                                </tr>
                            </thead>
                            <tbody>
                                @forelse($candidats as $candidat)
                                    @php
                                        $cvDisponible = false;
                                        if ($candidat->cv_path) {
                                            $cvFullPath = storage_path('app/public/' . $candidat->cv_path);
                                            $cvDisponible = file_exists($cvFullPath);
                                        }
                                    @endphp
                                    <tr>
                                        <td><strong>{{ $candidat->id }}</strong></td>
                                        <td>{{ $candidat->nom }} {{ $candidat->prenom }}</td>
                                        <td><small>{{ $candidat->email }}</small></td>
                                        <td>
                                            <small class="text-muted">
                                                {{ Str::limit($candidat->competences ?: 'Non renseignées', 40) }}
                                            </small>
                                        </td>
                                        <td>
                                            @if($cvDisponible)
                                                <span class="badge badge-success">
                                                    <i class="fas fa-check"></i> Disponible
                                                </span>
                                            @else
                                                <span class="badge badge-warning">
                                                    <i class="fas fa-times"></i> Manquant
                                                </span>
                                            @endif
                                        </td>
                                        <td>
                                            @php
                                                $badgeClass = match($candidat->statut) {
                                                    'en_attente' => 'secondary',
                                                    'test_en_cours' => 'info',
                                                    'en_entretien' => 'warning',
                                                    'retenu' => 'success',
                                                    'refuse' => 'danger',
                                                    'employe' => 'primary',
                                                    default => 'secondary'
                                                };
                                            @endphp
                                            <span class="badge badge-{{ $badgeClass }}">
                                                {{ ucfirst(str_replace('_', ' ', $candidat->statut)) }}
                                            </span>
                                        </td>
                                        <td>
                                            <span class="badge badge-info">
                                                {{ $candidat->candidatures->count() }}
                                            </span>
                                        </td>
                                    </tr>
                                @empty
                                    <tr>
                                        <td colspan="7" class="text-center text-muted py-4">
                                            Aucun candidat trouvé
                                        </td>
                                    </tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>
                </div>
                @if($candidats->count() > 0)
                    <div class="card-footer text-muted">
                        <small>
                            <i class="fas fa-info-circle mr-1"></i>
                            Affichage des 10 derniers candidats. L'export complet contiendra tous les {{ $stats['total_candidats'] }} candidats.
                        </small>
                    </div>
                @endif
            </div>
        </div>
    </div>
@endsection
