<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Tableau de bord</title>
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>
<body class="bg-gray-50 min-h-screen">

    <!-- Barre de navigation supérieure -->
    <nav class="bg-white shadow-sm border-b border-gray-200">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="flex justify-between h-16">
                <div class="flex items-center">
                    <span class="text-xl font-bold bg-gradient-to-r from-indigo-600 to-purple-600 bg-clip-text text-transparent">
                        Mon E-commerce / Projet
                    </span>
                </div>
                <div class="flex items-center space-x-4">
                    <span class="text-sm text-gray-700 font-medium">Bonjour, <span class="text-indigo-600">{{ $user->name }}</span></span>

                    <!-- Formulaire de déconnexion -->
                    <form method="POST" action="{{ route('logout') }}">
                        @csrf
                        <button type="submit" class="text-sm bg-red-50 text-red-600 hover:bg-red-100 font-medium px-4 py-2 rounded-lg transition">
                            Se déconnecter
                        </button>
                    </form>
                </div>
            </div>
        </div>
    </nav>

    <!-- Contenu Principal -->
    <main class="max-w-7xl mx-auto py-10 px-4 sm:px-6 lg:px-8">
        <div class="bg-white shadow-xl rounded-2xl p-8 border border-gray-100">
            <div class="border-b border-gray-200 pb-6 mb-6">
                <h1 class="text-3xl font-extrabold text-gray-900">Tableau de bord</h1>
                <p class="mt-1 text-sm text-gray-500">Bienvenue sur votre espace personnel sécurisé.</p>
            </div>

            <!-- Grille d'actions / cartes -->
            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">

                <!-- Carte Gestion des Étudiants (ton CRUD précédent) -->
                <div class="bg-gradient-to-br from-indigo-50 to-purple-50 p-6 rounded-xl border border-indigo-100 flex flex-col justify-between">
                    <div>
                        <span class="text-xs font-semibold uppercase tracking-wider text-indigo-600 bg-indigo-100 px-3 py-1 rounded-full">Module Actif</span>
                        <h3 class="text-xl font-bold text-gray-800 mt-4">Gestion des Étudiants</h3>
                        <p class="text-sm text-gray-600 mt-2">Accédez à votre CRUD d'étudiants développé avec Vue.js et Tailwind.</p>
                    </div>
                    <div class="mt-6">
                        <a href="/students" class="inline-block bg-indigo-600 text-white font-medium px-4 py-2 rounded-lg hover:bg-indigo-700 transition shadow">
                            Voir le CRUD &rarr;
                        </a>
                    </div>
                </div>

                <!-- Carte Futur E-commerce -->
                <div class="bg-gradient-to-br from-gray-50 to-slate-100 p-6 rounded-xl border border-gray-200 flex flex-col justify-between">
                    <div>
                        <span class="text-xs font-semibold uppercase tracking-wider text-gray-600 bg-gray-200 px-3 py-1 rounded-full">Prochaine étape</span>
                        <h3 class="text-xl font-bold text-gray-800 mt-4">Catalogue E-commerce</h3>
                        <p class="text-sm text-gray-600 mt-2">Bientôt ici : la gestion des produits, du panier et des commandes clients.</p>
                    </div>
                    <div class="mt-6">
                        <span class="text-sm font-medium text-gray-400 italic">Bientôt disponible...</span>
                    </div>
                </div>

            </div>
        </div>
    </main>

</body>
</html>
