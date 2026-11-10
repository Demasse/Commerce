<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Connexion - Mon E-commerce</title>
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>
<body class="bg-gray-50 h-screen flex overflow-hidden">

    <!-- Bloc Principal en deux colonnes -->
    <div class="flex w-full h-full">

        <!-- Côté Gauche : Panneau Coloré & Visuel -->
        <div class="hidden lg:flex lg:w-1/2 bg-gradient-to-br from-indigo-600 via-purple-600 to-pink-500 p-12 flex-col justify-between text-white relative shadow-2xl">
            <div class="absolute inset-0 bg-black opacity-10"></div> <!-- Léger voile pour la profondeur -->

            <!-- En-tête du panneau -->
            <div class="relative z-10">
                <span class="text-xs font-semibold uppercase tracking-wider bg-white/20 px-3 py-1 rounded-full">Espace Membre</span>
            </div>

            <!-- Texte central accrocheur -->
            <div class="relative z-10 space-y-4">
                <h1 class="text-4xl font-extrabold tracking-tight">Ravis de vous revoir !</h1>
                <p class="text-indigo-100 text-lg max-w-md">Connectez-vous pour accéder à votre espace, retrouver votre panier et suivre vos commandes en toute simplicité.</p>
            </div>

            <!-- Bas du panneau -->
            <div class="relative z-10 text-xs text-indigo-200">
                &copy; 2026 Laravel & Vue.js 3 Project. Tous droits réservés.
            </div>
        </div>

        <!-- Côté Droit : Le Formulaire -->
        <div class="w-full lg:w-1/2 flex items-center justify-center p-8 sm:p-12 bg-white overflow-y-auto">
            <div class="max-w-md w-full space-y-8">

                <div>
                    <h2 class="text-3xl font-bold tracking-tight text-gray-900">Connexion</h2>
                    <p class="mt-2 text-sm text-gray-600">Entrez vos identifiants pour vous connecter.</p>
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

                <form method="POST" action="{{ route('login') }}" class="space-y-6">
                    @csrf

                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-1">Adresse Email</label>
                        <input type="email" name="email" value="{{ old('email') }}" required autofocus
                            class="appearance-none block w-full px-3 py-3 border border-gray-300 rounded-lg shadow-sm placeholder-gray-400 focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:border-indigo-500 text-sm"
                            placeholder="votre@email.com" />
                    </div>

                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-1">Mot de passe</label>
                        <input type="password" name="password" required
                            class="appearance-none block w-full px-3 py-3 border border-gray-300 rounded-lg shadow-sm placeholder-gray-400 focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:border-indigo-500 text-sm"
                            placeholder="••••••••" />
                    </div>

                    <div class="flex items-center justify-between text-sm">
                        <label class="flex items-center">
                            <input type="checkbox" name="remember" class="h-4 w-4 rounded border-gray-300 text-indigo-600 focus:ring-indigo-500">
                            <span class="ml-2 text-gray-600">Se souvenir de moi</span>
                        </label>
                    </div>

                    <div>
                        <button type="submit" class="w-full flex justify-center py-3 px-4 border border-transparent rounded-lg shadow-md text-sm font-medium text-white bg-indigo-600 hover:bg-indigo-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500 transition-all duration-200">
                            Se connecter
                        </button>
                    </div>
                </form>

                <p class="text-center text-sm text-gray-600">
                    Pas encore de compte ?
                    <a href="{{ route('register') }}" class="font-medium text-indigo-600 hover:text-indigo-500 hover:underline">S'inscrire gratuitement</a>
                </p>

            </div>
        </div>

    </div>

</body>
</html>
