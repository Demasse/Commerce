<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>CRUD Étudiants - Commerce</title>

    <!-- Chargement de Vite -->
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>
<body>

    {{-- <div id="app"> --}}
        <div></div>
        <!-- Appel de ton composant Vue -->
        {{-- <gestion-etudiants></gestion-etudiants> --}}

    {{-- </div> --}}
    <div id="app">
        <accueil-page
            :is-authenticated="{{ json_encode(auth()->check()) }}"
            :routes="{{ json_encode([
                'login' => route('login'),
                'register' => route('register'),
                'dashboard' => route('dashboard')
            ]) }}"
        ></accueil-page>
    </div>

</body>
</html>
