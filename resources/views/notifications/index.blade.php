@extends('layouts.app')
@section('title','Notifications')
@section('page-title','Mes notifications')

@section('content')
@include('layouts.alerts')

<form method="GET" action="{{ route('notifications.index') }}" class="mb-3">
    <div class="row">
        <div class="col-md-4">
            <select name="type" class="form-select" onchange="this.form.submit()">
                <option value="">-- Tous les types --</option>
                <option value="test" {{ $filtre==='test'?'selected':'' }}>Test</option>
                <option value="entretien" {{ $filtre==='entretien'?'selected':'' }}>Entretien</option>
                <option value="decision" {{ $filtre==='decision'?'selected':'' }}>Décision</option>
                <option value="contrat" {{ $filtre==='contrat'?'selected':'' }}>Contrat</option>
            </select>
        </div>
    </div>
</form>

@if($notifications->isEmpty())
<div class="alert alert-info">Aucune notification trouvée.</div>
@else
<table class="table table-striped">
    <thead>
        <tr>
            <th>Type</th>
            <th>Message</th>
            <th>Date</th>
            <th>Statut</th>
            <th></th>
        </tr>
    </thead>
    <tbody>
        @foreach($notifications as $n)
        <tr>
            <td>{{ ucfirst($n->type) }}</td>
            <td>{{ $n->data['message'] ?? '-' }}</td>
            <td>{{ $n->created_at->format('d/m/Y H:i') }}</td>
            <td>
                @if($n->read_at)
                    <span class="badge bg-success">Lu</span>
                @else
                    <span class="badge bg-warning text-dark">Non lu</span>
                @endif
            </td>
            <td>
                @if(!$n->read_at)
                    <a href="{{ route('notifications.read', $n->id) }}" class="btn btn-sm btn-primary">Marquer comme lu</a>
                @endif
            </td>
        </tr>
        @endforeach
    </tbody>
</table>
@endif
@endsection
