<script setup>
import { ref } from 'vue';

const props = defineProps({
    user: { type: Object, required: true },
    orders: { type: Array, default: () => [] },
    invoices: { type: Array, default: () => [] },
    totalSpent: { type: [Number, String], default: 0 },
    routes: { type: Object, required: true },
    csrfToken: { type: String, required: true }
});

const activeTab = ref('overview');

const formatMoney = (amount) => {
    return Number(amount || 0).toLocaleString('fr-FR');
};

const formatDate = (dateStr) => {
    if (!dateStr) return '';
    return new Date(dateStr).toLocaleDateString('fr-FR', {
        day: '2-digit',
        month: '2-digit',
        year: 'numeric',
        hour: '2-digit',
        minute: '2-digit'
    });
};
</script>

<template>
    <div class="bg-[#0b0f0e] text-gray-100 font-sans antialiased min-h-screen flex">

        <aside class="w-64 bg-[#121816] border-r border-gray-800 flex flex-col justify-between hidden md:flex shrink-0">
            <div>
                <div class="h-20 flex items-center px-6 border-b border-gray-800/60">
                    <div class="flex items-center space-x-3">
                        <div
                            class="w-9 h-9 rounded-xl bg-emerald-500/20 border border-emerald-500/30 flex items-center justify-center text-emerald-400 font-bold text-lg">
                            S
                        </div>
                        <span class="text-lg font-bold tracking-wide text-white">ShopStore</span>
                    </div>
                </div>

                <nav class="p-4 space-y-1.5">
                    <button type="button" @click="activeTab = 'overview'" :class="[
                        'w-full flex items-center space-x-3 px-4 py-3 rounded-xl font-medium transition text-left',
                        activeTab === 'overview'
                            ? 'bg-emerald-500/10 text-emerald-400 border border-emerald-500/20'
                            : 'text-gray-400 hover:bg-white/5 hover:text-white border border-transparent'
                    ]">
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M4 6a2 2 0 012-2h2a2 2 0 012 2v2a2 2 0 01-2 2H6a2 2 0 01-2-2V6zM14 6a2 2 0 012-2h2a2 2 0 012 2v2a2 2 0 01-2 2h-2a2 2 0 01-2-2V6zM4 16a2 2 0 012-2h2a2 2 0 012 2v2a2 2 0 01-2 2H6a2 2 0 01-2-2v-2zM14 16a2 2 0 012-2h2a2 2 0 012 2v2a2 2 0 01-2 2h-2a2 2 0 01-2-2v-2z" />
                        </svg>
                        <span>Tableau de bord</span>
                    </button>

                    <button type="button" @click="activeTab = 'orders'" :class="[
                        'w-full flex items-center justify-between px-4 py-3 rounded-xl font-medium transition text-left',
                        activeTab === 'orders'
                            ? 'bg-emerald-500/10 text-emerald-400 border border-emerald-500/20'
                            : 'text-gray-400 hover:bg-white/5 hover:text-white border border-transparent'
                    ]">
                        <span class="flex items-center space-x-3">
                            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M16 11V7a4 4 0 00-8 0v4M5 9h14l1 12H4L5 9z" />
                            </svg>
                            <span>Mes Commandes</span>
                        </span>
                        <span v-if="orders.length > 0"
                            class="text-xs bg-emerald-500/20 text-emerald-300 px-2 py-0.5 rounded-full font-bold">
                            {{ orders.length }}
                        </span>
                    </button>

                    <button type="button" @click="activeTab = 'invoices'" :class="[
                        'w-full flex items-center justify-between px-4 py-3 rounded-xl font-medium transition text-left',
                        activeTab === 'invoices'
                            ? 'bg-emerald-500/10 text-emerald-400 border border-emerald-500/20'
                            : 'text-gray-400 hover:bg-white/5 hover:text-white border border-transparent'
                    ]">
                        <span class="flex items-center space-x-3">
                            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2m-3 7h3m-3 4h3m-6-4h.01M9 16h.01" />
                            </svg>
                            <span>Mes Factures</span>
                        </span>
                        <span v-if="invoices.length > 0"
                            class="text-xs bg-white/10 text-gray-300 px-2 py-0.5 rounded-full font-bold">
                            {{ invoices.length }}
                        </span>
                    </button>

                    <button type="button" @click="activeTab = 'favorites'" :class="[
                        'w-full flex items-center space-x-3 px-4 py-3 rounded-xl font-medium transition text-left',
                        activeTab === 'favorites'
                            ? 'bg-emerald-500/10 text-emerald-400 border border-emerald-500/20'
                            : 'text-gray-400 hover:bg-white/5 hover:text-white border border-transparent'
                    ]">
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M4.318 6.318a4.5 4.5 0 000 6.364L12 20.364l7.682-7.682a4.5 4.5 0 00-6.364-6.364L12 7.636l-1.318-1.318a4.5 4.5 0 00-6.364 0z" />
                        </svg>
                        <span>Mes Favoris</span>
                    </button>
                </nav>
            </div>

            <div class="p-4 border-t border-gray-800/60 space-y-4">
                <div class="flex items-center justify-between px-2 text-xs text-gray-400">
                    <span
                        class="bg-white/5 px-2.5 py-1 rounded-md border border-white/5 text-gray-300 font-medium">Français</span>
                    <span
                        class="bg-emerald-500/10 text-emerald-400 px-2.5 py-1 rounded-md border border-emerald-500/20 font-bold">XAF</span>
                </div>

                <div class="flex items-center justify-between bg-white/5 p-3 rounded-xl border border-white/5">
                    <div class="flex items-center space-x-3 truncate">
                        <div
                            class="w-8 h-8 rounded-full bg-indigo-600 flex items-center justify-center font-bold text-white text-sm">
                            {{ user.name ? user.name.charAt(0).toUpperCase() : 'U' }}
                        </div>
                        <div class="truncate">
                            <p class="text-xs font-bold text-white truncate">{{ user.name }}</p>
                            <p class="text-[10px] text-gray-400 truncate">{{ user.email }}</p>
                        </div>
                    </div>

                    <form method="POST" :action="routes.logout">
                        <input type="hidden" name="_token" :value="csrfToken" />
                        <button type="submit" title="Se déconnecter"
                            class="text-gray-400 hover:text-red-400 transition">
                            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M17 16l4-4m0 0l-4-4m4 4H7m6 4v1a3 3 0 01-3 3H6a3 3 0 01-3-3V7a3 3 0 013-3h4a3 3 0 013 3v1" />
                            </svg>
                        </button>
                    </form>
                </div>
            </div>
        </aside>

        <div class="flex-1 flex flex-col min-w-0">

            <header
                class="h-20 bg-[#121816]/60 backdrop-blur-md border-b border-gray-800 px-8 flex justify-between items-center sticky top-0 z-10">
                <h1 class="text-xl font-extrabold text-white">
                    <span v-if="activeTab === 'overview'">Mon Espace Client</span>
                    <span v-else-if="activeTab === 'orders'">Mes Commandes</span>
                    <span v-else-if="activeTab === 'invoices'">Mes Factures</span>
                    <span v-else-if="activeTab === 'favorites'">Mes Favoris</span>
                </h1>

                <a :href="routes.home"
                    class="text-xs bg-white/10 hover:bg-white/20 text-gray-200 px-4 py-2 rounded-xl transition font-medium border border-white/10">
                    &larr; Retour à la Boutique
                </a>
            </header>

            <main class="p-8 space-y-8 flex-grow">

                <div v-if="activeTab === 'overview'" class="space-y-8">
                    <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
                        <div
                            class="bg-[#121816] border border-gray-800 p-6 rounded-2xl shadow-xl flex flex-col justify-between">
                            <div class="text-gray-400 text-xs font-semibold uppercase tracking-wider">Montant Total
                                Acheté</div>
                            <div class="text-3xl font-extrabold text-white mt-4">
                                {{ formatMoney(totalSpent) }} <span
                                    class="text-emerald-400 text-lg font-bold">XAF</span>
                            </div>
                            <p class="text-xs text-gray-500 mt-2">Cumul sur l'ensemble de vos commandes réglées.</p>
                        </div>

                        <div
                            class="bg-[#121816] border border-gray-800 p-6 rounded-2xl shadow-xl flex flex-col justify-between">
                            <div class="text-gray-400 text-xs font-semibold uppercase tracking-wider">Vos Commandes
                            </div>
                            <div class="text-3xl font-extrabold text-white mt-4">
                                {{ orders.length }} <span class="text-emerald-400 text-sm font-normal">Commandes</span>
                            </div>
                            <button @click="activeTab = 'orders'"
                                class="text-xs text-emerald-400 hover:underline mt-2 font-medium text-left">
                                Voir le détail de mes commandes &rarr;
                            </button>
                        </div>

                        <div
                            class="bg-[#121816] border border-gray-800 p-6 rounded-2xl shadow-xl flex flex-col justify-between">
                            <div class="text-gray-400 text-xs font-semibold uppercase tracking-wider">Mes Factures</div>
                            <div class="text-3xl font-extrabold text-white mt-4">
                                {{ invoices.length }} <span class="text-emerald-400 text-sm font-normal">Factures</span>
                            </div>
                            <button @click="activeTab = 'invoices'"
                                class="text-xs text-emerald-400 hover:underline mt-2 font-medium text-left">
                                Consulter mes factures &rarr;
                            </button>
                        </div>
                    </div>

                    <div class="grid grid-cols-1 lg:grid-cols-3 gap-8">
                        <div
                            class="lg:col-span-2 bg-[#121816] border border-gray-800 rounded-2xl p-8 flex flex-col items-center justify-center text-center min-h-[280px]">
                            <div
                                class="w-14 h-14 bg-emerald-500/10 text-emerald-400 rounded-2xl flex items-center justify-center mb-4 border border-emerald-500/20">
                                <svg class="w-7 h-7" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M16 11V7a4 4 0 00-8 0v4M5 9h14l1 12H4L5 9z" />
                                </svg>
                            </div>
                            <h3 class="text-lg font-bold text-white">
                                {{ orders.length > 0 ? `Vous avez ${orders.length} commande(s) enregistrée(s)` : "Aucune
                                commande pour l'instant" }}
                            </h3>
                            <p class="text-sm text-gray-400 max-w-sm mt-1">
                                Utilisez le menu à gauche pour consulter vos commandes, vos factures et vos produits
                                favoris.
                            </p>
                            <div class="mt-6 flex space-x-3">
                                <button v-if="orders.length > 0" @click="activeTab = 'orders'"
                                    class="bg-white/10 hover:bg-white/20 text-white font-semibold px-5 py-2.5 rounded-xl transition text-sm">
                                    Voir mes commandes
                                </button>
                                <a :href="routes.home"
                                    class="bg-emerald-600 hover:bg-emerald-500 text-white font-semibold px-5 py-2.5 rounded-xl transition shadow-lg text-sm">
                                    Aller à la boutique
                                </a>
                            </div>
                        </div>

                        <div class="space-y-6">
                            <div class="bg-[#121816] border border-gray-800 rounded-2xl p-6">
                                <h4 class="text-sm font-bold text-white mb-4">Sécurité du compte</h4>
                                <div
                                    class="bg-emerald-500/10 border border-emerald-500/20 rounded-xl p-4 text-emerald-300 text-xs leading-relaxed">
                                    <span class="font-bold block mb-1">Compte client actif</span>
                                    Bienvenue {{ user.name }}, vos commandes et factures sont synchronisées en temps
                                    réel.
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <div v-else-if="activeTab === 'orders'"
                    class="bg-[#121816] border border-gray-800 rounded-2xl p-6 space-y-4">
                    <div class="flex justify-between items-center border-b border-gray-800 pb-4">
                        <h3 class="text-lg font-bold text-white">Mes Commandes</h3>
                        <span class="text-xs text-emerald-400 bg-emerald-500/10 px-3 py-1 rounded-full font-semibold">
                            {{ orders.length }} commande(s)
                        </span>
                    </div>

                    <div v-if="orders.length === 0" class="py-12 flex flex-col items-center justify-center text-center">
                        <h4 class="text-base font-bold text-white">Aucune commande pour l'instant</h4>
                        <p class="text-sm text-gray-400 max-w-sm mt-1">
                            Prêt à faire de bonnes affaires sur notre catalogue ? Parcourez nos produits dès maintenant.
                        </p>
                        <a :href="routes.home"
                            class="mt-6 bg-emerald-600 hover:bg-emerald-500 text-white font-semibold px-6 py-2.5 rounded-xl transition shadow-lg text-sm">
                            Découvrir la boutique
                        </a>
                    </div>

                    <div v-else class="space-y-4">
                        <div v-for="order in orders" :key="order.id"
                            class="bg-[#0b0f0e] border border-gray-800 rounded-xl p-5 space-y-3">
                            <div class="flex flex-wrap justify-between items-center gap-2">
                                <div>
                                    <span class="text-sm font-extrabold text-white">{{ order.reference }}</span>
                                    <span class="text-xs text-gray-500 ml-2">{{ formatDate(order.created_at) }}</span>
                                </div>
                                <div class="flex items-center space-x-3">
                                    <span
                                        class="text-xs font-semibold px-2.5 py-1 rounded-full bg-emerald-500/10 text-emerald-400 border border-emerald-500/20">
                                        {{ order.status }}
                                    </span>
                                    <span class="text-sm font-extrabold text-emerald-400">
                                        {{ formatMoney(order.total_amount) }} XAF
                                    </span>
                                </div>
                            </div>

                            <div class="border-t border-gray-800/80 pt-3 space-y-1.5 text-xs text-gray-400">
                                <div v-for="item in order.items" :key="item.id" class="flex justify-between">
                                    <span>{{ item.product_name }} &times; {{ item.quantity }}</span>
                                    <span class="text-gray-300 font-medium">{{ formatMoney(item.subtotal) }} XAF</span>
                                </div>
                            </div>

                            <div v-if="order.invoice"
                                class="pt-2 border-t border-gray-800/50 flex justify-between items-center text-xs">
                                <span class="text-gray-400">
                                    Facture : <span class="text-white font-semibold">{{ order.invoice.invoice_number
                                        }}</span>
                                </span>
                                <button @click="activeTab = 'invoices'"
                                    class="text-emerald-400 hover:underline font-medium">
                                    Voir la facture &rarr;
                                </button>
                            </div>
                        </div>
                    </div>
                </div>

                <div v-else-if="activeTab === 'invoices'"
                    class="bg-[#121816] border border-gray-800 rounded-2xl p-6 space-y-4">
                    <div class="flex justify-between items-center border-b border-gray-800 pb-4">
                        <h3 class="text-lg font-bold text-white">Mes Factures</h3>
                        <span class="text-xs text-emerald-400 bg-emerald-500/10 px-3 py-1 rounded-full font-semibold">
                            {{ invoices.length }} facture(s)
                        </span>
                    </div>

                    <div v-if="invoices.length === 0" class="py-12 text-center">
                        <p class="text-sm text-gray-400">Aucune facture générée pour le moment.</p>
                    </div>

                    <div v-else class="overflow-x-auto">
                        <table class="w-full text-left text-sm">
                            <thead class="text-xs uppercase text-gray-400 border-b border-gray-800">
                                <tr>
                                    <th class="py-3 px-4">N° Facture</th>
                                    <th class="py-3 px-4">Commande liée</th>
                                    <th class="py-3 px-4">Date</th>
                                    <th class="py-3 px-4">Statut</th>
                                    <th class="py-3 px-4 text-right">Montant</th>
                                </tr>
                            </thead>
                            <tbody class="divide-y divide-gray-800/70">
                                <tr v-for="invoice in invoices" :key="invoice.id" class="hover:bg-white/[0.02]">
                                    <td class="py-3.5 px-4 font-bold text-white">{{ invoice.invoice_number }}</td>
                                    <td class="py-3.5 px-4 text-gray-400">{{ invoice.order?.reference || '-' }}</td>
                                    <td class="py-3.5 px-4 text-gray-400">{{ formatDate(invoice.issued_at ||
                                        invoice.created_at) }}</td>
                                    <td class="py-3.5 px-4">
                                        <span
                                            class="text-xs font-semibold px-2.5 py-1 rounded-full bg-emerald-500/10 text-emerald-400 border border-emerald-500/20">
                                            {{ invoice.status === 'paid' ? 'Payée' : invoice.status }}
                                        </span>
                                    </td>
                                    <td class="py-3.5 px-4 text-right font-extrabold text-emerald-400">
                                        {{ formatMoney(invoice.amount) }} XAF
                                    </td>
                                </tr>
                            </tbody>
                        </table>
                    </div>
                </div>

                <div v-else-if="activeTab === 'favorites'"
                    class="bg-[#121816] border border-gray-800 rounded-2xl p-8 text-center">
                    <h3 class="text-lg font-bold text-white">Mes Favoris</h3>
                    <p class="text-sm text-gray-400 mt-1">
                        Les produits que vous aimerez avec le bouton cœur apparaîtront ici à l'étape suivante !
                    </p>
                </div>

            </main>
        </div>
    </div>
</template>
