<script setup>
// On récupère les infos envoyées depuis Laravel (Blade)
const props = defineProps({
    isAuthenticated: {
        type: Boolean,
        default: false
    },
    routes: {
        type: Object,
        required: true
    }
});
</script>

<template>
    <div
        class="bg-gradient-to-br from-indigo-950 via-purple-900 to-gray-900 min-h-screen text-white flex flex-col justify-between">

        <!-- Barre de navigation -->
        <header class="w-full max-w-7xl mx-auto px-6 py-6 flex justify-between items-center">
            <div class="flex items-center space-x-2">
                <span
                    class="text-2xl font-extrabold tracking-wider bg-gradient-to-r from-pink-400 to-indigo-300 bg-clip-text text-transparent">
                    ShopStore
                </span>
            </div>

            <div class="space-x-4">
                <template v-if="isAuthenticated">
                    <a :href="routes.dashboard"
                        class="text-sm font-medium bg-white/10 hover:bg-white/20 px-4 py-2 rounded-lg transition">
                        Mon Tableau de bord
                    </a>
                </template>
                <template v-else>
                    <a :href="routes.login"
                        class="text-sm font-medium text-indigo-200 hover:text-white px-4 py-2 transition">
                        Connexion
                    </a>
                    <a :href="routes.register"
                        class="text-sm font-semibold bg-indigo-600 hover:bg-indigo-700 px-5 py-2.5 rounded-lg shadow-lg transition">
                        S'inscrire
                    </a>
                </template>
            </div>
        </header>

        <!-- Section Principale (Hero) -->
        <main class="max-w-4xl mx-auto px-6 py-20 text-center space-y-8">
            <span
                class="inline-block bg-white/10 text-indigo-300 text-xs font-semibold uppercase tracking-widest px-4 py-1.5 rounded-full border border-white/10">
                Propulsé par Laravel & Vue.js 3
            </span>

            <h1 class="text-5xl sm:text-6xl font-extrabold tracking-tight leading-tight">
                Bienvenue sur votre <span
                    class="bg-gradient-to-r from-pink-400 to-indigo-400 bg-clip-text text-transparent">Boutique Nouvelle
                    Génération</span>
            </h1>

            <p class="text-lg text-gray-300 max-w-2xl mx-auto">
                Découvrez une expérience fluide et réactive. Connectez-vous pour gérer vos commandes ou parcourez notre
                catalogue dynamique.
            </p>

            <!-- Boutons d'action -->
            <div class="flex flex-col sm:flex-row justify-center items-center gap-4 pt-4">
                <template v-if="isAuthenticated">
                    <a :href="routes.dashboard"
                        class="w-full sm:w-auto bg-indigo-600 hover:bg-indigo-700 text-white font-semibold px-8 py-3.5 rounded-xl shadow-xl transition transform hover:-translate-y-0.5">
                        Accéder au Dashboard &rarr;
                    </a>
                </template>
                <template v-else>
                    <a :href="routes.register"
                        class="w-full sm:w-auto bg-indigo-600 hover:bg-indigo-700 text-white font-semibold px-8 py-3.5 rounded-xl shadow-xl transition transform hover:-translate-y-0.5">
                        Créer un compte
                    </a>
                    <a :href="routes.login"
                        class="w-full sm:w-auto bg-white/10 hover:bg-white/20 text-white font-semibold px-8 py-3.5 rounded-xl border border-white/20 transition">
                        Se connecter
                    </a>
                </template>
            </div>
        </main>

        <!-- Pied de page -->
        <footer class="w-full py-6 text-center text-xs text-gray-400 border-t border-white/10">
            &copy; 2026 - Architecture Full-Stack Laravel + Vue 3.
        </footer>

    </div>
</template>
