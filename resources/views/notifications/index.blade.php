@extends('layouts.adminlte')

@section('title', 'Notifications')

@section('breadcrumb')
<ol class="breadcrumb float-sm-right">
    <li class="breadcrumb-item"><a href="{{ route('rh.dashboard') }}">Accueil</a></li>
    <li class="breadcrumb-item active">Notifications</li>
</ol>
@endsection

@section('sidebar')
    @include('layouts.partials.sidebar-rh')
@endsection

@section('content')
    <div class="row">
        <div class="col-12">
            <!-- Info Boxes -->
            <div class="row">
                <div class="col-md-6">
                    <div class="info-box bg-warning">
                        <span class="info-box-icon"><i class="fas fa-bell"></i></span>
                        <div class="info-box-content">
                            <span class="info-box-text">Notifications Non Lues</span>
                            <span class="info-box-number">{{ $notifications->where('read_at', null)->count() }}</span>
                        </div>
                    </div>
                </div>
                <div class="col-md-6">
                    <div class="info-box bg-success">
                        <span class="info-box-icon"><i class="fas fa-check-circle"></i></span>
                        <div class="info-box-content">
                            <span class="info-box-text">Total Notifications</span>
                            <span class="info-box-number">{{ $notifications->count() }}</span>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Filtre -->
    <div class="row">
        <div class="col-12">
            <div class="card card-info collapsed-card">
                <div class="card-header">
                    <h3 class="card-title"><i class="fas fa-filter mr-2"></i>Filtrer les Notifications</h3>
                    <div class="card-tools">
                        <button type="button" class="btn btn-tool" data-card-widget="collapse">
                            <i class="fas fa-plus"></i>
                        </button>
                    </div>
                </div>
                <div class="card-body">
                    <form method="GET" action="{{ route('notifications.index') }}">
                        <div class="row">
                            <div class="col-md-4">
                                <div class="form-group">
                                    <label for="type"><i class="fas fa-tag mr-1"></i>Type de notification</label>
                                    <select name="type" id="type" class="form-control" onchange="this.form.submit()">
                                        <option value="">Toutes les notifications</option>
                                        <option value="candidature" {{ $filter=='candidature'?'selected':'' }}>Candidature</option>
                                        <option value="test" {{ $filter=='test'?'selected':'' }}>Test</option>
                                        <option value="entretien" {{ $filter=='entretien'?'selected':'' }}>Entretien</option>
                                        <option value="decision" {{ $filter=='decision'?'selected':'' }}>Décision</option>
                                        <option value="contrat" {{ $filter=='contrat'?'selected':'' }}>Contrat</option>
                                        <option value="affiliation" {{ $filter=='affiliation'?'selected':'' }}>Affiliation</option>
                                        <option value="employe" {{ $filter=='employe'?'selected':'' }}>Employé</option>
                                    </select>
                                </div>
                            </div>
                            <div class="col-md-4">
                                <div class="form-group">
                                    <label>&nbsp;</label>
                                    <button type="submit" class="btn btn-info btn-block">
                                        <i class="fas fa-search mr-1"></i>Filtrer
                                    </button>
                                </div>
                            </div>
                            <div class="col-md-4">
                                <div class="form-group">
                                    <label>&nbsp;</label>
                                    <a href="{{ route('notifications.index') }}" class="btn btn-secondary btn-block">
                                        <i class="fas fa-redo mr-1"></i>Réinitialiser
                                    </a>
                                </div>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>

    <!-- Liste des notifications -->
    <div class="row">
        <div class="col-12">
            <div class="card card-primary">
                <div class="card-header">
                    <h3 class="card-title"><i class="fas fa-bell mr-2"></i>Liste des Notifications</h3>
                </div>
                <div class="card-body">
                    @if($notifications->isEmpty())
                        <div class="alert alert-info">
                            <i class="fas fa-info-circle mr-2"></i>
                            Aucune notification trouvée.
                        </div>
                    @else
                        <div class="table-responsive">
                            <table class="table table-bordered table-striped table-hover">
                                <thead class="thead-light">
                                    <tr>
                                        <th style="width: 5%;"><i class="fas fa-circle mr-1"></i></th>
                                        <th style="width: 12%;"><i class="fas fa-tag mr-1"></i>Type</th>
                                        <th style="width: 40%;"><i class="fas fa-envelope mr-1"></i>Message</th>
                                        <th style="width: 15%;"><i class="fas fa-clock mr-1"></i>Date</th>
                                        <th style="width: 15%;"><i class="fas fa-user mr-1"></i>Destinataire</th>
                                        <th style="width: 13%;"><i class="fas fa-eye mr-1"></i>Statut</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach($notifications as $n)
                                    @php
                                        $isMine = $n->isForCurrentUser($userRole, session('user_id'));
                                        $isUnread = !$n->read_at;
                                    @endphp
                                    <tr class="{{ $isUnread ? 'table-warning' : '' }} {{ !$isMine ? 'table-secondary' : '' }}">
                                        <td class="text-center">
                                            @if($isUnread)
                                                <i class="fas fa-circle text-warning" title="Non lu"></i>
                                            @else
                                                <i class="far fa-circle text-muted" title="Lu"></i>
                                            @endif
                                        </td>
                                        <td>
                                            @if($n->type == 'candidature')
                                                <span class="badge badge-primary"><i class="fas fa-file-alt mr-1"></i>{{ ucfirst($n->type) }}</span>
                                            @elseif($n->type == 'test')
                                                <span class="badge badge-info"><i class="fas fa-clipboard-check mr-1"></i>{{ ucfirst($n->type) }}</span>
                                            @elseif($n->type == 'entretien')
                                                <span class="badge badge-warning"><i class="fas fa-calendar-alt mr-1"></i>{{ ucfirst($n->type) }}</span>
                                            @elseif($n->type == 'decision')
                                                <span class="badge badge-success"><i class="fas fa-gavel mr-1"></i>{{ ucfirst($n->type) }}</span>
                                            @elseif($n->type == 'contrat')
                                                <span class="badge badge-dark"><i class="fas fa-file-contract mr-1"></i>{{ ucfirst($n->type) }}</span>
                                            @elseif($n->type == 'affiliation')
                                                <span class="badge badge-secondary"><i class="fas fa-shield-alt mr-1"></i>{{ ucfirst($n->type) }}</span>
                                            @elseif($n->type == 'employe')
                                                <span class="badge badge-primary"><i class="fas fa-users mr-1"></i>{{ ucfirst($n->type) }}</span>
                                            @else
                                                <span class="badge badge-light">{{ ucfirst($n->type) }}</span>
                                            @endif
                                        </td>
                                        <td>
                                            @if($isUnread)
                                                <strong>{{ $n->data['message'] ?? json_decode($n->data,true)['message'] ?? '-' }}</strong>
                                            @else
                                                {{ $n->data['message'] ?? json_decode($n->data,true)['message'] ?? '-' }}
                                            @endif
                                        </td>
                                        <td>
                                            <small>
                                                <i class="far fa-clock mr-1"></i>
                                                {{ $n->created_at ? $n->created_at->format('d/m/Y H:i') : '-' }}
                                            </small>
                                        </td>
                                        <td>
                                            @if($n->notifiable_type == 'rh')
                                                <span class="badge badge-info">
                                                    <i class="fas fa-user-tie mr-1"></i>RH
                                                </span>
                                            @elseif($n->notifiable_type == 'candidat')
                                                <span class="badge badge-secondary">
                                                    <i class="fas fa-user mr-1"></i>Candidat #{{ $n->notifiable_id }}
                                                </span>
                                            @else
                                                <span class="badge badge-light">Inconnu</span>
                                            @endif
                                        </td>
                                        <td>
                                            @if($n->read_at)
                                                <span class="badge badge-success">
                                                    <i class="fas fa-check mr-1"></i>Lu
                                                </span>
                                            @else
                                                <span class="badge badge-warning">
                                                    <i class="fas fa-exclamation mr-1"></i>Non lu
                                                </span>
                                            @endif
                                        </td>
                                    </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                    @endif
                </div>
            </div>
        </div>
    </div>
@endsection
