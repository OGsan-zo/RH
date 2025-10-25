@extends('layouts.adminlte')

@section('title', 'Tri des Candidats')
@section('page-title', 'Tri des Candidats')

@section('breadcrumb')
    <li class="breadcrumb-item"><a href="{{ route('rh.dashboard') }}">Dashboard</a></li>
    <li class="breadcrumb-item active">Tri Candidats</li>
@endsection

@section('sidebar')
    @include('layouts.partials.sidebar-rh')
@endsection

@section('content')
    <div class="row">
        <div class="col-12">
            <div class="card card-primary">
                <div class="card-header">
                    <h3 class="card-title"><i class="fas fa-filter mr-2"></i>Sélection du Poste</h3>
                </div>
                <div class="card-body">
                    <form method="GET" action="{{ route('tri.show', 0) }}" id="formTriCandidat">
                        <div class="row">
                            <div class="col-md-9">
                                <div class="form-group">
                                    <label for="annonce_id"><i class="fas fa-briefcase mr-1"></i>Choisissez un poste</label>
                                    <select name="annonce_id" id="annonce_id" class="form-control" required>
                                        <option value="">-- Sélectionner un poste --</option>
                                        @foreach($annonces as $a)
                                            <option value="{{ $a->id }}" @if(isset($annonce) && $annonce->id == $a->id) selected @endif>
                                                {{ $a->titre }} ({{ $a->departement->nom ?? 'N/A' }})
                                            </option>
                                        @endforeach
                                    </select>
                                </div>
                            </div>
                            <div class="col-md-3">
                                <label>&nbsp;</label>
                                <button type="button" onclick="voirCandidats()" class="btn btn-primary btn-block">
                                    <i class="fas fa-search"></i> Voir les candidats
                                </button>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>

    @if(isset($candidatures) && $candidatures->count() > 0)
    <div class="row">
        <div class="col-12">
            <div class="card card-info collapsed-card">
                <div class="card-header">
                    <h3 class="card-title"><i class="fas fa-filter mr-2"></i>Filtres de Recherche</h3>
                    <div class="card-tools">
                        <button type="button" class="btn btn-tool" data-card-widget="collapse">
                            <i class="fas fa-plus"></i>
                        </button>
                    </div>
                </div>
                <div class="card-body" style="display: none;">
                    <form method="GET" action="{{ route('tri.show', $annonce->id) }}">
                        <div class="row">
                            <div class="col-md-3">
                                <div class="form-group">
                                    <label>Nom/Prénom</label>
                                    <input type="text" name="search_nom" class="form-control" 
                                           placeholder="Rechercher..." 
                                           value="{{ request('search_nom') }}">
                                </div>
                            </div>
                            <div class="col-md-2">
                                <div class="form-group">
                                    <label>Âge min</label>
                                    <input type="number" name="age_min" class="form-control" 
                                           placeholder="25" 
                                           value="{{ request('age_min') }}">
                                </div>
                            </div>
                            <div class="col-md-2">
                                <div class="form-group">
                                    <label>Âge max</label>
                                    <input type="number" name="age_max" class="form-control" 
                                           placeholder="35" 
                                           value="{{ request('age_max') }}">
                                </div>
                            </div>
                            <div class="col-md-3">
                                <div class="form-group">
                                    <label>Compétences</label>
                                    <input type="text" name="search_competences" class="form-control" 
                                           placeholder="PHP, Laravel" 
                                           value="{{ request('search_competences') }}">
                                </div>
                            </div>
                            <div class="col-md-2">
                                <div class="form-group">
                                    <label>Statut</label>
                                    <select name="filter_statut" class="form-control">
                                        <option value="">Tous</option>
                                        <option value="en_attente" {{ request('filter_statut') == 'en_attente' ? 'selected' : '' }}>En attente</option>
                                        <option value="test_en_cours" {{ request('filter_statut') == 'test_en_cours' ? 'selected' : '' }}>Test en cours</option>
                                        <option value="en_entretien" {{ request('filter_statut') == 'en_entretien' ? 'selected' : '' }}>En entretien</option>
                                        <option value="retenu" {{ request('filter_statut') == 'retenu' ? 'selected' : '' }}>Retenu</option>
                                        <option value="refuse" {{ request('filter_statut') == 'refuse' ? 'selected' : '' }}>Refusé</option>
                                    </select>
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-12">
                                <button type="submit" class="btn btn-primary">
                                    <i class="fas fa-search"></i> Appliquer les filtres
                                </button>
                                <a href="{{ route('tri.show', $annonce->id) }}" class="btn btn-secondary">
                                    <i class="fas fa-redo"></i> Réinitialiser
                                </a>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>

    <div class="row">
        <div class="col-12">
            <div class="card">
                <div class="card-header">
                    <h3 class="card-title">
                        <i class="fas fa-users mr-2"></i>Candidats pour : <strong>{{ $annonce->titre }}</strong>
                    </h3>
                    <div class="card-tools">
                        <span class="badge badge-secondary">{{ $candidatures->count() }} candidat(s)</span>
                    </div>
                </div>
                <div class="card-body p-0">
                    <div class="table-responsive">
                        <table class="table table-striped table-hover m-0">
                            <thead class="thead-light">
                <tr>
                    <th>#</th>
                    <th>Candidat</th>
                    <th>Âge</th>
                    <th>Compétences</th>
                    <th>Note CV</th>
                    <th>Score Test</th>
                    <th>Note Entretien</th>
                    <th>Score Global</th>
                    <th>Statut</th>
                    <th>Action</th>
                </tr>
            </thead>
            <tbody>
                @foreach($candidatures as $index => $c)
                    <tr>
                        <td>{{ $index + 1 }}</td>
                        <td>
                            <strong>{{ $c->candidat->nom }} {{ $c->candidat->prenom }}</strong>
                            <br>
                            <small class="text-muted">{{ $c->candidat->email }}</small>
                        </td>
                        
                        <!-- Âge -->
                        <td>
                            @if(isset($c->candidat->age))
                                {{ $c->candidat->age }} ans
                            @else
                                <span class="text-muted">-</span>
                            @endif
                        </td>
                        
                        <!-- Compétences -->
                        <td>
                            <small>{{ Str::limit($c->candidat->competences ?? 'Non renseigné', 30) }}</small>
                        </td>
                        
                        <!-- Note CV -->
                        <td class="text-center">
                            @if($c->note_cv)
                                <span class="badge badge-info">{{ $c->note_cv }}%</span>
                            @else
                                <span class="badge badge-secondary">-</span>
                            @endif
                        </td>
                        
                        <!-- Score Test -->
                        <td class="text-center">
                            @if($c->score_test)
                                <span class="badge badge-primary">{{ $c->score_test }}%</span>
                            @else
                                <span class="badge badge-secondary">-</span>
                            @endif
                        </td>
                        
                        <!-- Note Entretien -->
                        <td class="text-center">
                            @if($c->note_entretien)
                                <span class="badge badge-warning">{{ $c->note_entretien }}%</span>
                            @else
                                <span class="badge badge-secondary">-</span>
                            @endif
                        </td>
                        
                        <!-- Score Global -->
                        <td class="text-center">
                            @if($c->score_global)
                                <span class="badge badge-success" style="font-size: 1.1em;">{{ $c->score_global }}%</span>
                            @else
                                <span class="badge badge-secondary">-</span>
                            @endif
                        </td>
                        
                        <!-- Statut -->
                        <td class="text-center">
                            @php
                                $statutBadge = match($c->statut) {
                                    'en_attente' => 'badge-secondary',
                                    'test_en_cours' => 'badge-info',
                                    'en_entretien' => 'badge-warning',
                                    'retenu' => 'badge-success',
                                    'refuse' => 'badge-danger',
                                    default => 'badge-secondary'
                                };
                            @endphp
                            <span class="badge {{ $statutBadge }}">{{ ucfirst(str_replace('_', ' ', $c->statut)) }}</span>
                        </td>
                        
                        <!-- Action -->
                        <td class="text-center">
                            <a href="{{ route('decisions.show', $c->id) }}" class="btn btn-primary btn-sm">
                                <i class="fas fa-eye"></i> Profil
                            </a>
                        </td>
                    </tr>
                @endforeach
                            </tbody>
                        </table>
                    </div>
                </div>
                <div class="card-footer">
                    <div class="callout callout-info mb-0">
                        <p class="mb-0">
                            <i class="fas fa-info-circle mr-2"></i>
                            <strong>Note :</strong> Les candidats sont triés par score global décroissant. 
                            Le score global est la moyenne des 3 notes : CV (IA), Test et Entretien.
                        </p>
                    </div>
                </div>
            </div>
        </div>
    </div>
    @elseif(isset($candidatures))
    <div class="row">
        <div class="col-12">
            <div class="alert alert-info">
                <i class="fas fa-info-circle mr-2"></i>
                Aucun candidat n'a postulé pour ce poste.
            </div>
        </div>
    </div>
    @endif
@endsection

@push('scripts')
<script>
function voirCandidats() {
    const annonceId = document.getElementById('annonce_id').value;
    if (annonceId) {
        window.location.href = "{{ url('/RH/tri-candidats') }}/" + annonceId;
    } else {
        alert('Veuillez sélectionner un poste');
    }
}
</script>
@endpush
