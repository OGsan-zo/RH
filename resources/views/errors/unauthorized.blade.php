<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <title>Accès refusé</title>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css">
</head>
<body class="bg-light d-flex align-items-center" style="height:100vh;">
    <div class="container text-center">
        <h2 class="text-danger">Accès refusé</h2>
        <p>Cette page est réservée au rôle : <strong>{{ $role }}</strong></p>
        <a href="/RH/login" class="btn btn-primary mt-3">Retour à la connexion</a>
    </div>
</body>
</html>
