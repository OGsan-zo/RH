@extends('layouts.adminlte')

@section('title', 'Notifications - Congés')
@section('page-title', 'Notifications de Congés')

@section('breadcrumb')
    <li class="breadcrumb-item active">Notifications</li>
@endsection

@section('sidebar')
    @include('layouts.partials.sidebar-rh')
@endsection

@section('content')
<div class="card">
    <div class="card-header">
        <h3 class="card-title">Notifications de Congés</h3>
        <div class="card-tools">
            @if($notifications->count() > 0)
                <form action="{{ route('notifications-conges.tout-lu') }}" method="POST" style="display: inline;">
                    @csrf
                    <button type="submit" class="btn btn-sm btn-info">
                        <i class="fas fa-check-double"></i> Marquer tout comme lu
                    </button>
                </form>
            @endif
        </div>
    </div>
    <div class="card-body">
        @if($notifications->count() > 0)
            <div class="list-group">
                @foreach($notifications as $notification)
                    <div class="list-group-item {{ is_null($notification->read_at) ? 'bg-light' : '' }}">
                        <div class="row">
                            <div class="col-md-9">
                                <h5 class="mb-1">
                                    @if(is_null($notification->read_at))
                                        <span class="badge badge-primary">Nouveau</span>
                                    @endif
                                    {{ $notification->data['titre'] ?? 'Notification' }}
                                </h5>
                                <p class="mb-1">{{ $notification->data['message'] ?? '' }}</p>
                                <small class="text-muted">
                                    {{ $notification->created_at->diffForHumans() }}
                                </small>
                            </div>
                            <div class="col-md-3 text-right">
                                @if(!is_null($notification->data['lien'] ?? null))
                                    <a href="{{ $notification->data['lien'] }}" class="btn btn-sm btn-primary">
                                        <i class="fas fa-eye"></i> Voir
                                    </a>
                                @endif

                                @if(is_null($notification->read_at))
                                    <form action="{{ route('notifications-conges.lue', $notification->id) }}" method="POST" style="display: inline;">
                                        @csrf
                                        <button type="submit" class="btn btn-sm btn-success" title="Marquer comme lu">
                                            <i class="fas fa-check"></i>
                                        </button>
                                    </form>
                                @endif

                                <form action="{{ route('notifications-conges.supprimer', $notification->id) }}" method="POST" style="display: inline;">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="btn btn-sm btn-danger" title="Supprimer" onclick="return confirm('Êtes-vous sûr ?')">
                                        <i class="fas fa-trash"></i>
                                    </button>
                                </form>
                            </div>
                        </div>

                        @if($notification->data['commentaire'] ?? null)
                            <div class="mt-2">
                                <small class="text-muted">
                                    <strong>Commentaire :</strong> {{ $notification->data['commentaire'] }}
                                </small>
                            </div>
                        @endif
                    </div>
                @endforeach
            </div>

            <div class="mt-3">
                {{ $notifications->links() }}
            </div>
        @else
            <div class="alert alert-info">
                <i class="fas fa-info-circle"></i> Aucune notification pour le moment.
            </div>
        @endif
    </div>
</div>
@endsection
