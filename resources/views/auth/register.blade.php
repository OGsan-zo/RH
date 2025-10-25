<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Inscription Candidat - RH</title>

    <!-- Google Font: Source Sans Pro -->
    <link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Source+Sans+Pro:300,400,400i,700&display=fallback">
    <!-- Font Awesome -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <!-- icheck bootstrap -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/admin-lte@3.2/plugins/icheck-bootstrap/icheck-bootstrap.min.css">
    <!-- AdminLTE -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/admin-lte@3.2/dist/css/adminlte.min.css">
</head>
<body class="hold-transition register-page">
<div class="register-box">
    <div class="card card-outline card-primary">
        <div class="card-header text-center">
            <a href="{{ route('rh.login.form') }}" class="h1"><b>RH</b>System</a>
        </div>
        <div class="card-body">
            <p class="login-box-msg"><i class="fas fa-user-plus mr-2"></i>Créer un compte candidat</p>

            <form method="POST" action="{{ route('rh.register.store') }}" enctype="multipart/form-data">
                @csrf
                
                <!-- Nom -->
                <div class="input-group mb-3">
                    <input type="text" name="nom" class="form-control" placeholder="Nom" required value="{{ old('nom') }}">
                    <div class="input-group-append">
                        <div class="input-group-text">
                            <span class="fas fa-user"></span>
                        </div>
                    </div>
                </div>

                <!-- Prénom -->
                <div class="input-group mb-3">
                    <input type="text" name="prenom" class="form-control" placeholder="Prénom" required value="{{ old('prenom') }}">
                    <div class="input-group-append">
                        <div class="input-group-text">
                            <span class="fas fa-user"></span>
                        </div>
                    </div>
                </div>

                <!-- Date de naissance -->
                <div class="input-group mb-3">
                    <input type="date" name="date_naissance" class="form-control" placeholder="Date de naissance" required value="{{ old('date_naissance') }}">
                    <div class="input-group-append">
                        <div class="input-group-text">
                            <span class="fas fa-calendar"></span>
                        </div>
                    </div>
                </div>

                <!-- Email -->
                <div class="input-group mb-3">
                    <input type="email" name="email" class="form-control" placeholder="Email" required value="{{ old('email') }}">
                    <div class="input-group-append">
                        <div class="input-group-text">
                            <span class="fas fa-envelope"></span>
                        </div>
                    </div>
                </div>

                <!-- Password -->
                <div class="input-group mb-3">
                    <input type="password" name="password" class="form-control" placeholder="Mot de passe" required>
                    <div class="input-group-append">
                        <div class="input-group-text">
                            <span class="fas fa-lock"></span>
                        </div>
                    </div>
                </div>

                <!-- CV Upload -->
                <div class="form-group mb-3">
                    <label for="cv"><i class="fas fa-file-pdf mr-2"></i>CV (PDF, DOCX)</label>
                    <div class="input-group">
                        <div class="custom-file">
                            <input type="file" name="cv" class="custom-file-input" id="cv" accept=".pdf,.doc,.docx" required>
                            <label class="custom-file-label" for="cv">Choisir un fichier</label>
                        </div>
                        <div class="input-group-append">
                            <span class="input-group-text">
                                <i class="fas fa-upload"></i>
                            </span>
                        </div>
                    </div>
                    <small class="form-text text-muted">Formats acceptés : PDF, DOC, DOCX</small>
                </div>

                <!-- Errors -->
                @if($errors->any())
                    <div class="alert alert-danger alert-dismissible">
                        <button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>
                        <h5><i class="icon fas fa-ban"></i> Erreur!</h5>
                        <ul class="mb-0">
                            @foreach($errors->all() as $error)
                                <li>{{ $error }}</li>
                            @endforeach
                        </ul>
                    </div>
                @endif

                <!-- Terms -->
                <div class="row">
                    <div class="col-8">
                        <div class="icheck-primary">
                            <input type="checkbox" id="agreeTerms" name="terms" value="agree" required>
                            <label for="agreeTerms">
                                J'accepte les <a href="#">conditions</a>
                            </label>
                        </div>
                    </div>
                    <!-- Submit Button -->
                    <div class="col-4">
                        <button type="submit" class="btn btn-primary btn-block">
                            <i class="fas fa-user-plus mr-1"></i>S'inscrire
                        </button>
                    </div>
                </div>
            </form>

            <div class="social-auth-links text-center mt-3 mb-3">
                <p>- OU -</p>
            </div>

            <a href="{{ route('rh.login.form') }}" class="text-center">
                <i class="fas fa-sign-in-alt mr-1"></i>J'ai déjà un compte
            </a>
        </div>
        <!-- /.card-body -->
    </div>
    <!-- /.card -->
</div>
<!-- /.register-box -->

<!-- jQuery -->
<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<!-- Bootstrap 4 -->
<script src="https://cdn.jsdelivr.net/npm/bootstrap@4.6.0/dist/js/bootstrap.bundle.min.js"></script>
<!-- bs-custom-file-input -->
<script src="https://cdn.jsdelivr.net/npm/bs-custom-file-input/dist/bs-custom-file-input.min.js"></script>
<!-- AdminLTE App -->
<script src="https://cdn.jsdelivr.net/npm/admin-lte@3.2/dist/js/adminlte.min.js"></script>

<script>
$(function () {
    bsCustomFileInput.init();
});
</script>
</body>
</html>
