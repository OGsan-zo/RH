<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Modifier le mot de passe - RH</title>

    <!-- Google Font: Source Sans Pro -->
    <link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Source+Sans+Pro:300,400,400i,700&display=fallback">
    <!-- Font Awesome -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <!-- icheck bootstrap -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/admin-lte@3.2/plugins/icheck-bootstrap/icheck-bootstrap.min.css">
    <!-- AdminLTE -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/admin-lte@3.2/dist/css/adminlte.min.css">
</head>
<body class="hold-transition login-page">
<div class="login-box">
    <div class="card card-outline card-warning">
        <div class="card-header text-center">
            <a href="{{ route('rh.login.form') }}" class="h1"><b>RH</b>System</a>
        </div>
        <div class="card-body">
            <p class="login-box-msg"><i class="fas fa-key mr-2"></i>Modifier le mot de passe</p>

            <form method="POST" action="{{ route('rh.password.update') }}">
                @csrf
                
                <!-- Current Password -->
                <div class="input-group mb-3">
                    <input type="password" name="current_password" class="form-control" placeholder="Mot de passe actuel" required>
                    <div class="input-group-append">
                        <div class="input-group-text">
                            <span class="fas fa-lock"></span>
                        </div>
                    </div>
                </div>

                <!-- New Password -->
                <div class="input-group mb-3">
                    <input type="password" name="new_password" class="form-control" placeholder="Nouveau mot de passe" required>
                    <div class="input-group-append">
                        <div class="input-group-text">
                            <span class="fas fa-lock"></span>
                        </div>
                    </div>
                </div>

                <!-- Confirm New Password -->
                <div class="input-group mb-3">
                    <input type="password" name="new_password_confirmation" class="form-control" placeholder="Confirmer le nouveau mot de passe" required>
                    <div class="input-group-append">
                        <div class="input-group-text">
                            <span class="fas fa-lock"></span>
                        </div>
                    </div>
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

                <!-- Success Message -->
                @if(session('success'))
                    <div class="alert alert-success alert-dismissible">
                        <button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>
                        <h5><i class="icon fas fa-check"></i> Succès!</h5>
                        {{ session('success') }}
                    </div>
                @endif

                <!-- Password Requirements -->
                <div class="callout callout-info">
                    <h5><i class="fas fa-info-circle"></i> Exigences du mot de passe :</h5>
                    <ul class="mb-0">
                        <li>Au moins 8 caractères</li>
                        <li>Contenir des lettres et des chiffres</li>
                        <li>Les deux mots de passe doivent correspondre</li>
                    </ul>
                </div>

                <!-- Submit Button -->
                <div class="row">
                    <div class="col-12">
                        <button type="submit" class="btn btn-warning btn-block">
                            <i class="fas fa-key mr-1"></i>Mettre à jour le mot de passe
                        </button>
                    </div>
                </div>
            </form>

            <div class="social-auth-links text-center mt-3 mb-3">
                <p>- OU -</p>
            </div>

            <!-- Links -->
            <p class="mb-1">
                <a href="{{ route('rh.login.form') }}">
                    <i class="fas fa-sign-in-alt mr-1"></i>Retour à la connexion
                </a>
            </p>
            <p class="mb-0">
                <a href="{{ route('rh.register.form') }}" class="text-center">
                    <i class="fas fa-user-plus mr-1"></i>Créer un compte candidat
                </a>
            </p>
        </div>
        <!-- /.card-body -->
    </div>
    <!-- /.card -->
</div>
<!-- /.login-box -->

<!-- jQuery -->
<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<!-- Bootstrap 4 -->
<script src="https://cdn.jsdelivr.net/npm/bootstrap@4.6.0/dist/js/bootstrap.bundle.min.js"></script>
<!-- AdminLTE App -->
<script src="https://cdn.jsdelivr.net/npm/admin-lte@3.2/dist/js/adminlte.min.js"></script>
</body>
</html>
