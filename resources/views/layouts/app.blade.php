<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <title>@yield('title', 'RH Management')</title>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css">
</head>
<body class="bg-light">

<div class="d-flex">
    {{-- Sidebar --}}
    @include('layouts.sidebar')

    {{-- Contenu principal --}}
    <div class="flex-grow-1 p-4" style="min-height:100vh;">
        <h3 class="mb-4">@yield('page-title')</h3>
        @yield('content')
    </div>
</div>

</body>
</html>
