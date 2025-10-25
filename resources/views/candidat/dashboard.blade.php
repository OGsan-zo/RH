@extends('layouts.adminlte')

@section('title', 'Tableau de bord - Candidat')

@section('breadcrumb')
<ol class="breadcrumb float-sm-right">
    <li class="breadcrumb-item active">Tableau de Bord</li>
</ol>
@endsection

@section('sidebar')
    @include('layouts.partials.sidebar-candidat')
@endsection

@section('content')
    <!-- Welcome Card -->
    <div class="row">
        <div class="col-12">
            <div class="callout callout-info">
                <h5><i class="fas fa-user-circle mr-2"></i>Bienvenue, {{ \App\Models\User::find(session('user_id'))->name ?? 'Candidat' }} !</h5>
                <p>Vous pouvez consulter les offres d'emploi, passer les tests et suivre l'état de votre candidature.</p>
            </div>
        </div>
    </div>

    <!-- Info Boxes -->
    <div class="row">
        <div class="col-lg-4 col-6">
            <div class="small-box bg-info">
                <div class="inner">
                    <h3>{{ \App\Models\Annonce::where('statut', 'ouverte')->count() }}</h3>
                    <p>Annonces Disponibles</p>
                </div>
                <div class="icon">
                    <i class="fas fa-briefcase"></i>
                </div>
                <a href="{{ route('candidatures.index') }}" class="small-box-footer">
                    Voir les annonces <i class="fas fa-arrow-circle-right"></i>
                </a>
            </div>
        </div>

        <div class="col-lg-4 col-6">
            <div class="small-box bg-success">
                <div class="inner">
                    <h3>{{ \App\Models\Candidature::where('candidat_id', session('user_id'))->count() }}</h3>
                    <p>Mes Candidatures</p>
                </div>
                <div class="icon">
                    <i class="fas fa-tasks"></i>
                </div>
                <a href="{{ route('candidatures.suivi') }}" class="small-box-footer">
                    Voir mon suivi <i class="fas fa-arrow-circle-right"></i>
                </a>
            </div>
        </div>

        <div class="col-lg-4 col-6">
            <div class="small-box bg-warning">
                <div class="inner">
                    <h3>{{ \App\Models\Entretien::whereHas('candidature', function($q) { $q->where('candidat_id', session('user_id')); })->where('statut', 'planifie')->count() }}</h3>
                    <p>Entretiens Planifiés</p>
                </div>
                <div class="icon">
                    <i class="fas fa-calendar-alt"></i>
                </div>
                <a href="{{ route('entretiens.notifications') }}" class="small-box-footer">
                    Voir mes entretiens <i class="fas fa-arrow-circle-right"></i>
                </a>
            </div>
        </div>
    </div>

    <!-- Quick Actions -->
    <div class="row">
        <div class="col-12">
            <div class="card card-primary">
                <div class="card-header">
                    <h3 class="card-title"><i class="fas fa-bolt mr-2"></i>Actions Rapides</h3>
                </div>
                <div class="card-body">
                    <div class="row">
                        <div class="col-md-4 mb-3">
                            <a href="{{ route('candidatures.index') }}" class="btn btn-app btn-primary w-100">
                                <i class="fas fa-briefcase"></i> Voir les Annonces
                            </a>
                        </div>
                        <div class="col-md-4 mb-3">
                            <a href="{{ route('candidatures.suivi') }}" class="btn btn-app btn-success w-100">
                                <i class="fas fa-tasks"></i> Mes Candidatures
                            </a>
                        </div>
                        <div class="col-md-4 mb-3">
                            <a href="{{ route('tests.select') }}" class="btn btn-app btn-info w-100">
                                <i class="fas fa-clipboard-check"></i> Passer un Test
                            </a>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-4 mb-3">
                            <a href="{{ route('entretiens.notifications') }}" class="btn btn-app btn-warning w-100">
                                <i class="fas fa-calendar-alt"></i> Mes Entretiens
                            </a>
                        </div>
                        <div class="col-md-4 mb-3">
                            <a href="{{ route('contrat.details') }}" class="btn btn-app btn-dark w-100">
                                <i class="fas fa-file-contract"></i> Mon Contrat
                            </a>
                        </div>
                        <div class="col-md-4 mb-3">
                            <a href="{{ route('rh.password.form') }}" class="btn btn-app btn-secondary w-100">
                                <i class="fas fa-key"></i> Changer Mot de Passe
                            </a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
