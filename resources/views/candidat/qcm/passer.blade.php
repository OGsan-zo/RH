@extends('layouts.adminlte')

@section('title', 'Test QCM')

@section('breadcrumb')
<ol class="breadcrumb float-sm-right">
    <li class="breadcrumb-item"><a href="{{ route('candidat.dashboard') }}">Accueil</a></li>
    <li class="breadcrumb-item"><a href="{{ route('tests.select') }}">Tests QCM</a></li>
    <li class="breadcrumb-item active">Passer le test</li>
</ol>
@endsection

@section('sidebar')
    @include('layouts.partials.sidebar-candidat')
@endsection

@section('content')
    @include('layouts.alerts')

    <div class="row">
        <div class="col-12">
            <!-- En-tête du test -->
            <div class="callout callout-warning">
                <h4><i class="fas fa-clipboard-check mr-2"></i>{{ $test->titre }}</h4>
                <p class="mb-0">
                    <i class="fas fa-info-circle mr-2"></i>
                    Vous avez <strong>{{ $test->questions->count() }} questions</strong> à répondre. 
                    Prenez votre temps et lisez attentivement chaque question.
                </p>
            </div>
        </div>
    </div>

    <form action="{{ route('tests.submit', $test->id) }}" method="POST" id="testForm">
        @csrf
        
        <div class="row">
            <div class="col-md-8">
                @foreach($test->questions as $q)
                <div class="card card-outline card-primary mb-3">
                    <div class="card-header">
                        <h3 class="card-title">
                            <i class="fas fa-question-circle mr-2"></i>
                            <strong>Question {{ $loop->iteration }}</strong>
                        </h3>
                    </div>
                    <div class="card-body">
                        <p class="lead">{{ $q->intitule }}</p>
                        
                        @foreach($q->reponses as $r)
                        <div class="icheck-primary mb-2">
                            <input type="radio" 
                                   id="reponse_{{ $r->id }}" 
                                   name="question_{{ $q->id }}" 
                                   value="{{ $r->id }}" 
                                   required>
                            <label for="reponse_{{ $r->id }}">
                                {{ $r->texte }}
                            </label>
                        </div>
                        @endforeach
                    </div>
                </div>
                @endforeach

                <!-- Boutons de soumission -->
                <div class="card card-success">
                    <div class="card-body">
                        <div class="row">
                            <div class="col-md-6">
                                <button type="submit" class="btn btn-success btn-block btn-lg" 
                                        onclick="return confirm('Êtes-vous sûr de vouloir valider vos réponses ? Vous ne pourrez plus les modifier.')">
                                    <i class="fas fa-check mr-2"></i>Valider mes réponses
                                </button>
                            </div>
                            <div class="col-md-6">
                                <a href="{{ route('tests.select') }}" class="btn btn-secondary btn-block btn-lg">
                                    <i class="fas fa-times mr-2"></i>Annuler
                                </a>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Sidebar de progression -->
            <div class="col-md-4">
                <div class="card card-info sticky-top" style="top: 20px;">
                    <div class="card-header">
                        <h3 class="card-title"><i class="fas fa-tasks mr-2"></i>Progression</h3>
                    </div>
                    <div class="card-body">
                        <p><strong>Total de questions :</strong> {{ $test->questions->count() }}</p>
                        <p id="progressText"><strong>Réponses données :</strong> <span id="answeredCount">0</span> / {{ $test->questions->count() }}</p>
                        
                        <div class="progress mb-3">
                            <div class="progress-bar bg-success" id="progressBar" role="progressbar" style="width: 0%"></div>
                        </div>

                        <div class="callout callout-warning">
                            <h5><i class="fas fa-exclamation-triangle"></i> Attention !</h5>
                            <p class="mb-0">Une fois validé, vous ne pourrez plus modifier vos réponses.</p>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </form>
@endsection

@push('scripts')
<script>
$(document).ready(function() {
    // Compter les réponses données
    function updateProgress() {
        let totalQuestions = {{ $test->questions->count() }};
        let answeredQuestions = 0;
        
        $('input[type="radio"]').each(function() {
            let name = $(this).attr('name');
            if ($('input[name="' + name + '"]:checked').length > 0) {
                answeredQuestions++;
            }
        });
        
        // Éviter de compter plusieurs fois la même question
        let uniqueQuestions = new Set();
        $('input[type="radio"]:checked').each(function() {
            uniqueQuestions.add($(this).attr('name'));
        });
        answeredQuestions = uniqueQuestions.size;
        
        let percentage = (answeredQuestions / totalQuestions) * 100;
        
        $('#answeredCount').text(answeredQuestions);
        $('#progressBar').css('width', percentage + '%');
    }
    
    // Mettre à jour la progression à chaque changement
    $('input[type="radio"]').on('change', function() {
        updateProgress();
    });
    
    // Initialiser
    updateProgress();
});
</script>
@endpush
