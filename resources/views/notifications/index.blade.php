@extends('layouts.app')
@section('title','Notifications')

@section('content')

<h4 class="mb-3">📢 Notifications</h4>

{{-- Filtre --}}
<form method="GET" action="{{ route('notifications.index') }}" class="mb-3">
    <div class="row">
        <div class="col-md-3">
            <select name="type" class="form-select" onchange="this.form.submit()">
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
</form>

@if($notifications->isEmpty())
<div class="alert alert-info">Aucune notification trouvée.</div>
@else
<table class="table table-bordered align-middle">
    <thead class="table-dark">
        <tr>
            <th>Type</th>
            <th>Message</th>
            <th>Date</th>
            <th>Destinataire</th>
            <th>Statut</th>
        </tr>
    </thead>
    <tbody>
        @foreach($notifications as $n)
        @php
            $isMine = $n->isForCurrentUser($userRole, session('user_id'));
        @endphp
        <tr class="{{ $isMine ? '' : 'table-secondary' }}">
            <td>{{ ucfirst($n->type) }}</td>
            <td>{{ $n->data['message'] ?? json_decode($n->data,true)['message'] ?? '-' }}</td>
            <td>{{ $n->created_at ? $n->created_at->format('d/m/Y H:i') : '-' }}</td>
            <td>
                @if($n->notifiable_type == 'rh')
                    RH
                @elseif($n->notifiable_type == 'candidat')
                    Candidat #{{ $n->notifiable_id }}
                @else
                    Inconnu
                @endif
            </td>
            <td>
                @if($n->read_at)
                    <span class="badge bg-success">Lu</span>
                @else
                    <span class="badge bg-warning text-dark">Non lu</span>
                @endif
            </td>
        </tr>
        @endforeach
    </tbody>
</table>
@endif

@endsection
