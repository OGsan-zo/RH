@extends('layouts.app')
@section('title','Tri des Candidats')
@section('page-title','Tri des Candidats par Poste')

@section('content')
@include('layouts.alerts')

<div class="card p-4 shadow-sm mb-4">
    <h5 class="mb-3">Sélectionner un poste pour voir les candidats</h5>
    <form method="GET" action="{{ route('tri.show', 0) }}" id="formTriCandidat">
        <div class="row g-2 align-items-center">
            <div class="col-md-8">
                <select name="annonce_id" id="annonce_id" class="form-select" required>
                    <option value="">-- Sélectionner un poste --</option>
                    @foreach($annonces as $a)
                        <option value="{{ $a->id }}" @if(isset($annonce) && $annonce->id == $a->id) selected @endif>
                            {{ $a->titre }} ({{ $a->departement->nom ?? 'N/A' }})
                        </option>
                    @endforeach
                </select>
            </div>
            <div class="col-md-4">
                <button type="button" onclick="voirCandidats()" class="btn btn-primary w-100">
                    📊 Voir les candidats
                </button>
            </div>
        </div>
    </form>
</div>

@if(isset($candidatures) && $candidatures->count() > 0)
<!-- Filtres de recherche -->
<div class="card p-4 shadow-sm mb-3">
    <h6 class="mb-3">🔍 Filtres de recherche</h6>
    <form method="GET" action="{{ route('tri.show', $annonce->id) }}">
        <div class="row g-3">
            <div class="col-md-3">
                <label class="form-label">Nom/Prénom</label>
                <input type="text" name="search_nom" class="form-control" 
                       placeholder="Rechercher..." 
                       value="{{ request('search_nom') }}">
            </div>
            <div class="col-md-2">
                <label class="form-label">Âge min</label>
                <input type="number" name="age_min" class="form-control" 
                       placeholder="Ex: 25" 
                       value="{{ request('age_min') }}">
            </div>
            <div class="col-md-2">
                <label class="form-label">Âge max</label>
                <input type="number" name="age_max" class="form-control" 
                       placeholder="Ex: 35" 
                       value="{{ request('age_max') }}">
            </div>
            <div class="col-md-3">
                <label class="form-label">Compétences</label>
                <input type="text" name="search_competences" class="form-control" 
                       placeholder="Ex: PHP, Laravel" 
                       value="{{ request('search_competences') }}">
            </div>
            <div class="col-md-2">
                <label class="form-label">Statut</label>
                <select name="filter_statut" class="form-select">
                    <option value="">Tous</option>
                    <option value="en_attente" {{ request('filter_statut') == 'en_attente' ? 'selected' : '' }}>En attente</option>
                    <option value="test_en_cours" {{ request('filter_statut') == 'test_en_cours' ? 'selected' : '' }}>Test en cours</option>
                    <option value="en_entretien" {{ request('filter_statut') == 'en_entretien' ? 'selected' : '' }}>En entretien</option>
                    <option value="retenu" {{ request('filter_statut') == 'retenu' ? 'selected' : '' }}>Retenu</option>
                    <option value="refuse" {{ request('filter_statut') == 'refuse' ? 'selected' : '' }}>Refusé</option>
                </select>
            </div>
        </div>
        <div class="mt-3">
            <button type="submit" class="btn btn-primary">
                🔍 Appliquer les filtres
            </button>
            <a href="{{ route('tri.show', $annonce->id) }}" class="btn btn-secondary">
                🔄 Réinitialiser
            </a>
        </div>
    </form>
</div>

<div class="card p-4 shadow-sm">
    <h5 class="mb-3">
        Candidats pour : <strong>{{ $annonce->titre }}</strong>
        <span class="badge bg-secondary">{{ $candidatures->count() }} candidat(s)</span>
    </h5>
    
    <div class="table-responsive">
        <table class="table table-striped table-hover">
            <thead class="table-dark">
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
                        <td>
                            @if($c->note_cv)
                                <span class="badge bg-info">{{ $c->note_cv }}%</span>
                            @else
                                <span class="badge bg-secondary">-</span>
                            @endif
                        </td>
                        
                        <!-- Score Test -->
                        <td>
                            @if($c->score_test)
                                <span class="badge bg-primary">{{ $c->score_test }}%</span>
                            @else
                                <span class="badge bg-secondary">-</span>
                            @endif
                        </td>
                        
                        <!-- Note Entretien -->
                        <td>
                            @if($c->note_entretien)
                                <span class="badge bg-warning">{{ $c->note_entretien }}%</span>
                            @else
                                <span class="badge bg-secondary">-</span>
                            @endif
                        </td>
                        
                        <!-- Score Global -->
                        <td>
                            @if($c->score_global)
                                <span class="badge bg-success fs-6">{{ $c->score_global }}%</span>
                            @else
                                <span class="badge bg-secondary">-</span>
                            @endif
                        </td>
                        
                        <!-- Statut -->
                        <td>
                            @php
                                $statutBadge = match($c->statut) {
                                    'en_attente' => 'bg-secondary',
                                    'test_en_cours' => 'bg-info',
                                    'en_entretien' => 'bg-warning',
                                    'retenu' => 'bg-success',
                                    'refuse' => 'bg-danger',
                                    default => 'bg-secondary'
                                };
                            @endphp
                            <span class="badge {{ $statutBadge }}">{{ ucfirst(str_replace('_', ' ', $c->statut)) }}</span>
                        </td>
                        
                        <!-- Action -->
                        <td>
                            <a href="{{ route('decisions.show', $c->id) }}" class="btn btn-outline-primary btn-sm">
                                👁️ Voir profil
                            </a>
                        </td>
                    </tr>
                @endforeach
            </tbody>
        </table>
    </div>
    
    <div class="mt-3">
        <p class="text-muted">
            <strong>Note :</strong> Les candidats sont triés par score global décroissant. 
            Le score global est la moyenne des 3 notes : CV (IA), Test et Entretien.
        </p>
    </div>
</div>
@elseif(isset($candidatures))
<div class="alert alert-info">
    Aucun candidat n'a postulé pour ce poste.
</div>
@endif

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
@endsection
