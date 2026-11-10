<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Inscription - Mon E-commerce</title>
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>
<body class="bg-gray-50 h-screen flex overflow-hidden">

    <!-- Bloc Principal en deux colonnes -->
    <div class="flex w-full h-full">

        <!-- Côté Gauche : Panneau Coloré & Visuel -->
        <div class="hidden lg:flex lg:w-1/2 bg-gradient-to-br from-purple-600 via-indigo-600 to-blue-500 p-12 flex-col justify-between text-white relative shadow-2xl">
            <div class="absolute inset-0 bg-black opacity-10"></div>

            <!-- En-tête du panneau -->
            <div class="relative z-10">
                <span class="text-xs font-semibold uppercase tracking-wider bg-white/20 px-3 py-1 rounded-full">Nouveau Projet</span>
            </div>

            <!-- Texte central accrocheur -->
            <div class="relative z-10 space-y-4">
                <h1 class="text-4xl font-extrabold tracking-tight">Rejoignez l'aventure !</h1>
                <p class="text-purple-100 text-lg max-w-md">Créez votre compte dès aujourd'hui pour explorer notre catalogue e-commerce et profiter de toutes les fonctionnalités interactives.</p>
            </div>

            <!-- Bas du panneau -->
            <div class="relative z-10 text-xs text-purple-200">
                &copy; 2026 Laravel & Vue.js 3 Project. Tous droits réservés.
            </div>
        </div>

        <!-- Côté Droit : Le Formulaire -->
        <div class="w-full lg:w-1/2 flex items-center justify-center p-8 sm:p-12 bg-white overflow-y-auto">
            <div class="max-w-md w-full space-y-6">

                <div>
                    <h2 class="text-3xl font-bold tracking-tight text-gray-900">Créer un compte</h2>
                    <p class="mt-2 text-sm text-gray-600">Remplissez les champs ci-dessous pour démarrer.</p>
                </div>

                <!-- Affichage des erreurs -->
                @if ($errors->any())
                    <div class="p-4 bg-red-50 border-l-4 border-red-500 text-red-700 rounded-r text-sm shadow-sm">
                        <ul class="list-disc list-inside space-y-1">
                            @foreach ($errors->all() as $error)
                                <li>{{ $error }}</li>
                            @endforeach
                        </ul>
                    </div>
                @endif

                <form method="POST" action="{{ route('register') }}" class="space-y-4">
                    @csrf

                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-1">Nom complet</label>
                        <input type="text" name="name" value="{{ old('name') }}" required autofocus
                            class="appearance-none block w-full px-3 py-3 border border-gray-300 rounded-lg shadow-sm placeholder-gray-400 focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:border-indigo-500 text-sm"
                            placeholder="Ton Nom" />
                    </div>

                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-1">Adresse Email</label>
                        <input type="email" name="email" value="{{ old('email') }}" required
                            class="appearance-none block w-full px-3 py-3 border border-gray-300 rounded-lg shadow-sm placeholder-gray-400 focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:border-indigo-500 text-sm"
                            placeholder="votre@email.com" />
                    </div>

                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-1">Mot de passe</label>
                        <input type="password" name="password" required
                            class="appearance-none block w-full px-3 py-3 border border-gray-300 rounded-lg shadow-sm placeholder-gray-400 focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:border-indigo-500 text-sm"
                            placeholder="••••••••" />
                    </div>

                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-1">Confirmer le mot de passe</label>
                        <input type="password" name="password_confirmation" required
                            class="appearance-none block w-full px-3 py-3 border border-gray-300 rounded-lg shadow-sm placeholder-gray-400 focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:border-indigo-500 text-sm"
                            placeholder="••••••••" />
                    </div>

                    <div class="pt-2">
                        <button type="submit" class="w-full flex justify-center py-3 px-4 border border-transparent rounded-lg shadow-md text-sm font-medium text-white bg-indigo-600 hover:bg-indigo-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500 transition-all duration-200">
                            S'inscrire
                        </button>
                    </div>
                </form>

                <p class="text-center text-sm text-gray-600">
                    Déjà un compte ?
                    <a href="{{ route('login') }}" class="font-medium text-indigo-600 hover:text-indigo-500 hover:underline">Se connecter</a>
                </p>

            </div>
        </div>

    </div>

</body>
</html>
