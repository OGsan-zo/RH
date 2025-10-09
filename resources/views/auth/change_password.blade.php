<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <title>Modifier le mot de passe - RH</title>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css">
</head>
<body class="bg-light">
<div class="container mt-5">
    <h3 class="text-center mb-4">Modifier le mot de passe</h3>

    <form method="POST" action="{{ route('rh.password.update') }}" class="card p-4 shadow-sm">
        @csrf
        <div class="mb-3">
            <label>Mot de passe actuel :</label>
            <input type="password" name="current_password" class="form-control" required>
        </div>
        <div class="mb-3">
            <label>Nouveau mot de passe :</label>
            <input type="password" name="new_password" class="form-control" required>
        </div>
        <div class="mb-3">
            <label>Confirmer le nouveau mot de passe :</label>
            <input type="password" name="new_password_confirmation" class="form-control" required>
        </div>

        @if($errors->any())
            <div class="alert alert-danger">{{ $errors->first() }}</div>
        @endif

        <button type="submit" class="btn btn-primary w-100">Mettre à jour</button>
    </form>
</div>
</body>
</html>
