<!DOCTYPE html>
<html lang="fr" class="dark">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Mon Espace - Dashboard</title>
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>
<body class="bg-[#0b0f0e] text-gray-100 font-sans antialiased min-h-screen flex">

    <!-- 1. SIDEBAR FIXE À GAUCHE -->
    <aside class="w-64 bg-[#121816] border-r border-gray-800 flex flex-col justify-between hidden md:flex shrink-0">
        <div>
            <!-- Logo / Titre -->
            <div class="h-20 flex items-center px-6 border-b border-gray-800/60">
                <div class="flex items-center space-x-3">
                    <div class="w-9 h-9 rounded-xl bg-emerald-500/20 border border-emerald-500/30 flex items-center justify-center text-emerald-400 font-bold text-lg">
                        S
                    </div>
                    <span class="text-lg font-bold tracking-wide text-white">ShopStore</span>
                </div>
            </div>

            <!-- Menu de navigation -->
            <nav class="p-4 space-y-1.5">
                <a href="#" class="flex items-center space-x-3 px-4 py-3 rounded-xl bg-emerald-500/10 text-emerald-400 font-medium border border-emerald-500/20">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6a2 2 0 012-2h2a2 2 0 012 2v2a2 2 0 01-2 2H6a2 2 0 01-2-2V6zM14 6a2 2 0 012-2h2a2 2 0 012 2v2a2 2 0 01-2 2h-2a2 2 0 01-2-2V6zM4 16a2 2 0 012-2h2a2 2 0 012 2v2a2 2 0 01-2 2H6a2 2 0 01-2-2v-2zM14 16a2 2 0 012-2h2a2 2 0 012 2v2a2 2 0 01-2 2h-2a2 2 0 01-2-2v-2z"/></svg>
                    <span>Tableau de bord</span>
                </a>
                <a href="#" class="flex items-center space-x-3 px-4 py-3 rounded-xl text-gray-400 hover:bg-white/5 hover:text-white transition">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 11V7a4 4 0 00-8 0v4M5 9h14l1 12H4L5 9z"/></svg>
                    <span>Mes Commandes</span>
                </a>
                <a href="#" class="flex items-center space-x-3 px-4 py-3 rounded-xl text-gray-400 hover:bg-white/5 hover:text-white transition">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2m-3 7h3m-3 4h3m-6-4h.01M9 16h.01"/></svg>
                    <span>Mes Factures</span>
                </a>
                <a href="#" class="flex items-center space-x-3 px-4 py-3 rounded-xl text-gray-400 hover:bg-white/5 hover:text-white transition">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4.318 6.318a4.5 4.5 0 000 6.364L12 20.364l7.682-7.682a4.5 4.5 0 00-6.364-6.364L12 7.636l-1.318-1.318a4.5 4.5 0 00-6.364 0z"/></svg>
                    <span>Mes Favoris</span>
                </a>
            </nav>
        </div>

        <!-- Bas de sidebar (Langue, Devise & Profil utilisateur) -->
        <div class="p-4 border-t border-gray-800/60 space-y-4">
            <div class="flex items-center justify-between px-2 text-xs text-gray-400">
                <span class="bg-white/5 px-2.5 py-1 rounded-md border border-white/5 text-gray-300 font-medium">Français</span>
                <span class="bg-emerald-500/10 text-emerald-400 px-2.5 py-1 rounded-md border border-emerald-500/20 font-bold">XAF</span>
            </div>

            <!-- Profil & Déconnexion -->
            <div class="flex items-center justify-between bg-white/5 p-3 rounded-xl border border-white/5">
                <div class="flex items-center space-x-3 truncate">
                    <div class="w-8 h-8 rounded-full bg-indigo-600 flex items-center justify-center font-bold text-white text-sm">
                        {{ substr($user->name, 0, 1) }}
                    </div>
                    <div class="truncate">
                        <p class="text-xs font-bold text-white truncate">{{ $user->name }}</p>
                        <p class="text-[10px] text-gray-400 truncate">{{ $user->email }}</p>
                    </div>
                </div>
                <!-- Formulaire de déconnexion -->
                <form method="POST" action="{{ route('logout') }}">
                    @csrf
                    <button type="submit" title="Se déconnecter" class="text-gray-400 hover:text-red-400 transition">
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 16l4-4m0 0l-4-4m4 4H7m6 4v1a3 3 0 01-3 3H6a3 3 0 01-3-3V7a3 3 0 013-3h4a3 3 0 013 3v1"/></svg>
                    </button>
                </form>
            </div>
        </div>
    </aside>

    <!-- 2. CONTENU PRINCIPAL -->
    <div class="flex-1 flex flex-col min-w-0">

        <!-- Header du Dashboard -->
        <header class="h-20 bg-[#121816]/60 backdrop-blur-md border-b border-gray-800 px-8 flex justify-between items-center sticky top-0 z-10">
            <h1 class="text-xl font-extrabold text-white">Mon Espace Client</h1>

            <div class="flex items-center space-x-4">
                <a href="{{ url('/') }}" class="text-xs bg-white/10 hover:bg-white/20 text-gray-200 px-4 py-2 rounded-xl transition font-medium border border-white/10">
                    &larr; Retour à la Boutique
                </a>
            </div>
        </header>

        <!-- Corps de la page -->
        <main class="p-8 space-y-8 flex-grow">

            <!-- Statistiques / KPI Cards -->
            <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
                <!-- Carte 1 -->
                <div class="bg-[#121816] border border-gray-800 p-6 rounded-2xl shadow-xl flex flex-col justify-between">
                    <div class="text-gray-400 text-xs font-semibold uppercase tracking-wider">Montant Total Acheté</div>
                    <div class="text-3xl font-extrabold text-white mt-4">0 <span class="text-emerald-400 text-lg font-bold">XAF</span></div>
                    <p class="text-xs text-gray-500 mt-2">Cumul sur l'ensemble de vos commandes réglées.</p>
                </div>

                <!-- Carte 2 -->
                <div class="bg-[#121816] border border-gray-800 p-6 rounded-2xl shadow-xl flex flex-col justify-between">
                    <div class="text-gray-400 text-xs font-semibold uppercase tracking-wider">Vos Commandes</div>
                    <div class="text-3xl font-extrabold text-white mt-4">0 <span class="text-emerald-400 text-sm font-normal">Commandes</span></div>
                    <p class="text-xs text-emerald-400 mt-2 font-medium">0 En cours de traitement</p>
                </div>

                <!-- Carte 3 -->
                <div class="bg-[#121816] border border-gray-800 p-6 rounded-2xl shadow-xl flex flex-col justify-between">
                    <div class="text-gray-400 text-xs font-semibold uppercase tracking-wider">Cagnote & Parrainage</div>
                    <div class="text-3xl font-extrabold text-white mt-4">0 <span class="text-emerald-400 text-lg font-bold">XAF</span></div>
                    <p class="text-xs text-gray-500 mt-2">0 filleuls inscrits via votre lien.</p>
                </div>
            </div>

            <!-- Section Activité Récente / Message de bienvenue -->
            <div class="grid grid-cols-1 lg:grid-cols-3 gap-8">

                <!-- Zone principale (Commandes récentes) -->
                <div class="lg:col-span-2 bg-[#121816] border border-gray-800 rounded-2xl p-8 flex flex-col items-center justify-center text-center min-h-[300px]">
                    <div class="w-14 h-14 bg-emerald-500/10 text-emerald-400 rounded-2xl flex items-center justify-center mb-4 border border-emerald-500/20">
                        <svg class="w-7 h-7" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 11V7a4 4 0 00-8 0v4M5 9h14l1 12H4L5 9z"/></svg>
                    </div>
                    <h3 class="text-lg font-bold text-white">Aucune commande pour l'instant</h3>
                    <p class="text-sm text-gray-400 max-w-sm mt-1">Prêt à faire de bonnes affaires sur notre catalogue ? Parcourez nos produits dès maintenant.</p>
                    <a href="{{ url('/') }}" class="mt-6 bg-emerald-600 hover:bg-emerald-500 text-white font-semibold px-6 py-2.5 rounded-xl transition shadow-lg text-sm">
                        Découvrir la boutique
                    </a>
                </div>

                <!-- Panneau Latéral (Raccourcis / Alertes) -->
                <div class="space-y-6">
                    <div class="bg-[#121816] border border-gray-800 rounded-2xl p-6">
                        <h4 class="text-sm font-bold text-white mb-4">Sécurité du compte</h4>
                        <div class="bg-amber-500/10 border border-amber-500/20 rounded-xl p-4 text-amber-300 text-xs leading-relaxed">
                            <span class="font-bold block mb-1">Vérification requise</span>
                            Votre adresse e-mail est bien enregistrée. Votre compte client est pleinement actif.
                        </div>
                    </div>
                </div>

            </div>

        </main>
    </div>

</body>
</html>
