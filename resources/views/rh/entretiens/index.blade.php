@extends('layouts.adminlte')

@section('title', 'Entretiens')
@section('page-title', 'Gestion des Entretiens')

@section('breadcrumb')
    <li class="breadcrumb-item"><a href="{{ route('rh.dashboard') }}">Dashboard</a></li>
    <li class="breadcrumb-item active">Entretiens</li>
@endsection

@section('sidebar')
    @include('layouts.partials.sidebar-rh')
@endsection

@section('content')
    <div class="row">
        <!-- Candidats Éligibles -->
        <div class="col-md-4">
            <div class="card card-success">
                <div class="card-header">
                    <h3 class="card-title"><i class="fas fa-user-check mr-2"></i>Candidats Éligibles</h3>
                </div>
                <div class="card-body">
                    <div class="info-box bg-light mb-3">
                        <span class="info-box-icon bg-info"><i class="fas fa-chart-line"></i></span>
                        <div class="info-box-content">
                            <span class="info-box-text">Seuil actuel</span>
                            <span class="info-box-number">{{ $hasSeuil ? number_format($seuil,2) : 'N/A' }}%</span>
                        </div>
                    </div>

                    @unless($hasSeuil)
                        <div class="alert alert-warning">
                            <i class="fas fa-exclamation-triangle mr-2"></i>
                            <small>Aucun résultat QCM pour le moment. Le filtrage par seuil est inactif.</small>
                        </div>
                    @endunless

                    @if($hasSeuil)
                        <form action="{{ route('entretiens.create') }}" method="get">
                            <div class="form-group">
                                <label for="candidature_id"><i class="fas fa-users mr-1"></i>Sélectionner un candidat</label>
                                <select name="candidature_id" id="candidature_id" class="form-control" required>
                                    @forelse($eligibles as $c)
                                        <option value="{{ $c->id }}">
                                            {{ $c->candidat->nom }} {{ $c->candidat->prenom }} — {{ $c->annonce->titre }}
                                        </option>
                                    @empty
                                        <option disabled>Aucun candidat au-dessus du seuil</option>
                                    @endforelse
                                </select>
                            </div>
                            <button type="submit" class="btn btn-success btn-block">
                                <i class="fas fa-calendar-plus"></i> Planifier un entretien
                            </button>
                        </form>
                    @endif
                </div>
            </div>
        </div>

        <!-- Entretiens Planifiés -->
        <div class="col-md-8">
            <div class="card">
                <div class="card-header">
                    <h3 class="card-title"><i class="fas fa-calendar-alt mr-2"></i>Entretiens Planifiés</h3>
                    <div class="card-tools">
                        <a href="{{ route('entretiens.calendrier') }}" class="btn btn-primary btn-sm">
                            <i class="fas fa-calendar"></i> Voir le calendrier
                        </a>
                    </div>
                </div>
                <div class="card-body p-0">
                    <div class="table-responsive">
                        <table class="table table-striped table-hover m-0">
                            <thead>
                                <tr>
                                    <th>Candidat</th>
                                    <th>Poste</th>
                                    <th>Date</th>
                                    <th>Durée</th>
                                    <th>Lieu</th>
                                    <th>Statut</th>
                                    <th class="text-center">Action</th>
                                </tr>
                            </thead>
                            <tbody>
                                @forelse($entretiens as $e)
                                <tr>
                                    <td><i class="fas fa-user text-muted mr-1"></i>{{ $e->candidature->candidat->nom }} {{ $e->candidature->candidat->prenom }}</td>
                                    <td>{{ $e->candidature->annonce->titre }}</td>
                                    <td><i class="far fa-calendar text-muted mr-1"></i>{{ \Carbon\Carbon::parse($e->date_entretien)->format('d/m/Y H:i') }}</td>
                                    <td><i class="far fa-clock text-muted mr-1"></i>{{ $e->duree }} min</td>
                                    <td><i class="fas fa-map-marker-alt text-muted mr-1"></i>{{ $e->lieu }}</td>
                                    <td>
                                        @if($e->statut === 'planifie')
                                            <span class="badge badge-primary">Planifié</span>
                                        @elseif($e->statut === 'confirme')
                                            <span class="badge badge-success">Confirmé</span>
                                        @else
                                            <span class="badge badge-secondary">{{ $e->statut }}</span>
                                        @endif
                                    </td>
                                    <td class="text-center">
                                        <a href="{{ route('entretiens.delete', $e->id) }}" 
                                           class="btn btn-danger btn-sm"
                                           onclick="return confirm('Voulez-vous vraiment supprimer cet entretien ?')">
                                            <i class="fas fa-trash"></i>
                                        </a>
                                    </td>
                                </tr>
                                @empty
                                <tr>
                                    <td colspan="7" class="text-center text-muted">
                                        <i class="fas fa-info-circle"></i> Aucun entretien planifié
                                    </td>
                                </tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
