<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Accueil - ShopStore</title>
    <!-- C'est cette ligne qui charge Vite et tes composants -->
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>
<body class="bg-gray-900">
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
