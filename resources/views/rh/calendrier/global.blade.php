@extends('layouts.adminlte')

@section('title', 'Calendrier Global')
@section('page-title', 'Calendrier Global - Entretiens & Congés')

@section('breadcrumb')
    <li class="breadcrumb-item active">Calendrier Global</li>
@endsection

@section('sidebar')
    @include('layouts.partials.sidebar-rh')
@endsection

@section('content')
<div class="card">
    <div class="card-header">
        <h3 class="card-title">Calendrier Global</h3>
        <div class="card-tools">
            <form method="GET" action="{{ route('calendrier.global') }}" class="form-inline">
                <select name="type" class="form-control form-control-sm mr-2" onchange="this.form.submit()">
                    <option value="tous" {{ $typeAffichage === 'tous' ? 'selected' : '' }}>Tous les événements</option>
                    <option value="entretiens" {{ $typeAffichage === 'entretiens' ? 'selected' : '' }}>Entretiens uniquement</option>
                    <option value="conges" {{ $typeAffichage === 'conges' ? 'selected' : '' }}>Congés uniquement</option>
                </select>

                @if($typeAffichage === 'conges')
                    <select name="employe_id" class="form-control form-control-sm mr-2" onchange="this.form.submit()">
                        <option value="">-- Tous les employés --</option>
                        @foreach($employes as $emp)
                            <option value="{{ $emp->id }}" {{ $employe_id == $emp->id ? 'selected' : '' }}>
                                {{ $emp->candidat->nom ?? 'N/A' }} {{ $emp->candidat->prenom ?? '' }}
                            </option>
                        @endforeach
                    </select>
                @endif
            </form>
        </div>
    </div>
    <div class="card-body">
        <div id="calendar" style="height: 600px;"></div>
    </div>
</div>

<!-- Légende -->
<div class="row mt-4">
    <div class="col-md-6">
        <div class="card">
            <div class="card-header">
                <h5 class="card-title">Légende</h5>
            </div>
            <div class="card-body">
                <p><span class="badge badge-primary">🎤</span> <strong>Entretiens</strong> - Entretiens de candidats</p>
                <p><span class="badge badge-success">🏖️</span> <strong>Congés</strong> - Congés approuvés des employés</p>
            </div>
        </div>
    </div>

    <div class="col-md-6">
        <div class="card">
            <div class="card-header">
                <h5 class="card-title">Résumé</h5>
            </div>
            <div class="card-body">
                <p><strong>Entretiens :</strong> {{ count($entretiens) }} événement(s)</p>
                <p><strong>Congés :</strong> {{ count($conges) }} événement(s)</p>
                <p><strong>Total :</strong> {{ count($entretiens) + count($conges) }} événement(s)</p>
            </div>
        </div>
    </div>
</div>

<!-- Liste détaillée -->
<div class="row mt-4">
    @if(count($entretiens) > 0)
        <div class="col-md-6">
            <div class="card">
                <div class="card-header bg-primary text-white">
                    <h5 class="card-title">🎤 Entretiens ({{ count($entretiens) }})</h5>
                </div>
                <div class="card-body" style="max-height: 400px; overflow-y: auto;">
                    <ul class="list-unstyled">
                        @foreach($entretiens as $entretien)
                            <li class="mb-3 pb-3 border-bottom">
                                <strong>{{ $entretien->candidature->candidat->nom }} {{ $entretien->candidature->candidat->prenom }}</strong>
                                <br>
                                <small class="text-muted">
                                    📅 {{ \Carbon\Carbon::parse($entretien->date_entretien)->format('d/m/Y H:i') }}
                                    <br>
                                    📍 {{ $entretien->lieu }}
                                    <br>
                                    💼 {{ $entretien->candidature->annonce->titre }}
                                </small>
                            </li>
                        @endforeach
                    </ul>
                </div>
            </div>
        </div>
    @endif

    @if(count($conges) > 0)
        <div class="col-md-6">
            <div class="card">
                <div class="card-header bg-success text-white">
                    <h5 class="card-title">🏖️ Congés Approuvés ({{ count($conges) }})</h5>
                </div>
                <div class="card-body" style="max-height: 400px; overflow-y: auto;">
                    <ul class="list-unstyled">
                        @foreach($conges as $conge)
                            <li class="mb-3 pb-3 border-bottom">
                                <strong>{{ $conge->employe->candidat->nom }} {{ $conge->employe->candidat->prenom }}</strong>
                                <br>
                                <small class="text-muted">
                                    📅 {{ \Carbon\Carbon::parse($conge->date_debut)->format('d/m/Y') }} à {{ \Carbon\Carbon::parse($conge->date_fin)->format('d/m/Y') }}
                                    <br>
                                    📋 {{ $conge->typeCongé->nom }}
                                    <br>
                                    ⏱️ {{ $conge->nombre_jours }} jour(s)
                                </small>
                            </li>
                        @endforeach
                    </ul>
                </div>
            </div>
        </div>
    @endif
</div>

<script src="https://cdn.jsdelivr.net/npm/fullcalendar@6.1.10/index.global.min.js"></script>
<script>
    document.addEventListener('DOMContentLoaded', function() {
        var calendarEl = document.getElementById('calendar');
        var calendar = new FullCalendar.Calendar(calendarEl, {
            initialView: 'dayGridMonth',
            locale: 'fr',
            headerToolbar: {
                left: 'prev,next today',
                center: 'title',
                right: 'dayGridMonth,timeGridWeek,timeGridDay'
            },
            events: @json($events),
            eventClick: function(info) {
                var props = info.event.extendedProps;
                var title = info.event.title;
                var start = info.event.start.toLocaleDateString('fr-FR');
                
                var details = '<strong>' + title + '</strong><br>';
                details += '📅 ' + start + '<br>';
                
                if (props.type === 'entretien') {
                    details += '📍 ' + props.lieu + '<br>';
                    details += '💼 ' + props.poste;
                } else if (props.type === 'conge') {
                    details += '📋 ' + props.type_conge + '<br>';
                    details += '⏱️ ' + props.jours + ' jour(s)';
                }
                
                alert(details);
            }
        });
        calendar.render();
    });
</script>
@endsection
