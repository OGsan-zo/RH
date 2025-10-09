<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <title>Connexion - RH</title>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css">
</head>
<body class="bg-light">
<div class="container mt-5">
    <h3 class="text-center mb-4">Connexion à l’espace RH</h3>

    <form method="POST" action="{{ route('rh.login.process') }}" class="card p-4 shadow-sm">
        @csrf
        <div class="mb-3">
            <label>Email :</label>
            <input type="email" name="email" class="form-control" required>
        </div>
        <div class="mb-3">
            <label>Mot de passe :</label>
            <input type="password" name="password" class="form-control" required>
        </div>
        @if($errors->any())
            <div class="alert alert-danger">
                {{ $errors->first() }}
            </div>
        @endif
        <button type="submit" class="btn btn-primary w-100">Se connecter</button>
    </form>
</div>
</body>
</html>
