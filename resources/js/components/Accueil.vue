<script setup>
import { ref, computed, onMounted } from 'vue';

const props = defineProps({
    isAuthenticated: {
        type: Boolean,
        default: false
    },
    products: {
        type: Array,
        default: () => []
    },
    routes: {
        type: Object,
        required: true
    }
});

const cart = ref({ items: [] });
const isCartOpen = ref(false);
const loadingProductId = ref(null);
const toastMessage = ref('');
const toastType = ref('success'); // 'success' | 'error'

const showToast = (message, type = 'success') => {
    toastMessage.value = message;
    toastType.value = type;
    setTimeout(() => {
        toastMessage.value = '';
    }, 3000);
};

// Récupère le token CSRF depuis la balise meta ou un input caché si besoin
const getCsrfToken = () => {
    const meta = document.querySelector('meta[name="csrf-token"]');
    return meta ? meta.getAttribute('content') : '';
};

// Charger le panier si l'utilisateur est connecté
const fetchCart = async () => {
    if (!props.isAuthenticated) return;
    try {
        const response = await fetch(props.routes.cartIndex, {
            headers: {
                'Accept': 'application/json',
                'X-Requested-With': 'XMLHttpRequest'
            }
        });
        if (response.ok) {
            const data = await response.json();
            cart.value = data.cart || { items: [] };
        }
    } catch (error) {
        console.error('Erreur chargement panier :', error);
    }
};

// Ajouter un produit au panier
const addToCart = async (product) => {
    if (!props.isAuthenticated) {
        window.location.href = props.routes.login;
        return;
    }

    loadingProductId.value = product.id;
    try {
        const response = await fetch(props.routes.cartStore, {
            method: 'POST',
            headers: {
                'Content-Type': 'application/json',
                'Accept': 'application/json',
                'X-CSRF-TOKEN': getCsrfToken(),
                'X-Requested-With': 'XMLHttpRequest'
            },
            body: JSON.stringify({
                product_id: product.id,
                quantity: 1
            })
        });

        const data = await response.json();

        if (!response.ok) {
            showToast(data.message || 'Impossible d’ajouter au panier.', 'error');
            return;
        }

        cart.value = data.cart;
        showToast(data.message || 'Produit ajouté au panier !', 'success');
    } catch (error) {
        showToast('Erreur réseau lors de l’ajout au panier.', 'error');
    } finally {
        loadingProductId.value = null;
    }
};

// Modifier la quantité d'un item
const updateQuantity = async (item, newQuantity) => {
    if (newQuantity < 1) {
        await removeItem(item);
        return;
    }

    try {
        const response = await fetch(`${props.routes.cartUpdate}/${item.id}`, {
            method: 'PATCH',
            headers: {
                'Content-Type': 'application/json',
                'Accept': 'application/json',
                'X-CSRF-TOKEN': getCsrfToken(),
                'X-Requested-With': 'XMLHttpRequest'
            },
            body: JSON.stringify({ quantity: newQuantity })
        });

        const data = await response.json();
        if (!response.ok) {
            showToast(data.message || 'Mise à jour impossible.', 'error');
            return;
        }

        cart.value = data.cart;
    } catch (error) {
        showToast('Erreur lors de la mise à jour.', 'error');
    }
};

// Supprimer un item du panier
const removeItem = async (item) => {
    try {
        const response = await fetch(`${props.routes.cartDestroy}/${item.id}`, {
            method: 'DELETE',
            headers: {
                'Accept': 'application/json',
                'X-CSRF-TOKEN': getCsrfToken(),
                'X-Requested-With': 'XMLHttpRequest'
            }
        });

        const data = await response.json();
        if (response.ok) {
            cart.value = data.cart;
            showToast('Article retiré du panier.', 'success');
        }
    } catch (error) {
        showToast('Erreur lors de la suppression.', 'error');
    }
};

// Nombre total d'articles (somme des quantités)
const totalItemsCount = computed(() => {
    if (!cart.value?.items) return 0;
    return cart.value.items.reduce((sum, item) => sum + item.quantity, 0);
});

// Montant total en XAF
const cartTotalXAF = computed(() => {
    if (!cart.value?.items) return 0;
    return cart.value.items.reduce((sum, item) => {
        const price = Number(item.product?.price || 0);
        return sum + price * item.quantity;
    }, 0);
});

onMounted(() => {
    fetchCart();
});
</script>

<template>
    <div class="bg-[#0b0f0e] min-h-screen text-gray-100 flex flex-col justify-between relative">

        <!-- Notification Toast -->
        <div v-if="toastMessage" :class="[
            'fixed bottom-5 right-5 z-50 px-4 py-3 rounded-xl shadow-2xl border text-sm font-semibold transition',
            toastType === 'success'
                ? 'bg-emerald-950/95 border-emerald-500/40 text-emerald-300'
                : 'bg-red-950/95 border-red-500/40 text-red-300'
        ]">
            {{ toastMessage }}
        </div>

        <!-- Barre de navigation -->
        <header class="w-full bg-[#121816]/80 backdrop-blur-md border-b border-gray-800 sticky top-0 z-30">
            <div class="max-w-7xl mx-auto px-6 h-20 flex justify-between items-center">
                <div class="flex items-center space-x-3">
                    <div
                        class="w-9 h-9 rounded-xl bg-emerald-500/20 border border-emerald-500/30 flex items-center justify-center text-emerald-400 font-bold text-lg">
                        S
                    </div>
                    <span class="text-xl font-extrabold tracking-wide text-white">ShopStore</span>
                </div>

                <div class="flex items-center space-x-3 sm:space-x-4">
                    <!-- Bouton Panier -->
                    <button @click="isCartOpen = true"
                        class="relative flex items-center space-x-2 bg-[#1a221f] hover:bg-[#222c28] border border-gray-700 text-gray-200 px-4 py-2 rounded-xl text-sm font-semibold transition">
                        <svg class="w-5 h-5 text-emerald-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M3 3h2l.4 2M7 13h10l4-8H5.4M7 13L5.4 5M7 13l-2.293 2.293c-.63.63-.184 1.707.707 1.707H17m0 0a2 2 0 100 4 2 2 0 000-4zm-8 2a2 2 0 11-4 0 2 2 0 014 0z" />
                        </svg>
                        <span>Panier</span>
                        <span v-if="totalItemsCount > 0"
                            class="bg-emerald-500 text-gray-950 text-xs font-extrabold px-2 py-0.5 rounded-full">
                            {{ totalItemsCount }}
                        </span>
                    </button>

                    <template v-if="isAuthenticated">
                        <a :href="routes.dashboard"
                            class="text-sm font-semibold bg-emerald-600 hover:bg-emerald-500 text-white px-4 py-2 rounded-xl transition shadow">
                            Dashboard
                        </a>
                    </template>
                    <template v-else>
                        <a :href="routes.login"
                            class="text-sm font-medium text-gray-300 hover:text-white px-3 py-2 transition">
                            Connexion
                        </a>
                        <a :href="routes.register"
                            class="text-sm font-semibold bg-emerald-600 hover:bg-emerald-500 text-white px-4 py-2 rounded-xl shadow transition">
                            S'inscrire
                        </a>
                    </template>
                </div>
            </div>
        </header>

        <!-- Section Principale -->
        <main class="max-w-7xl mx-auto px-6 py-12 space-y-14 flex-grow w-full">
            <div class="max-w-3xl mx-auto text-center space-y-4">
                <span
                    class="inline-block bg-emerald-500/10 text-emerald-400 text-xs font-semibold uppercase tracking-widest px-4 py-1.5 rounded-full border border-emerald-500/20">
                    Catalogue • Laravel 13 & Vue.js 3
                </span>

                <h1 class="text-3xl sm:text-5xl font-extrabold tracking-tight text-white">
                    Bienvenue sur <span class="text-emerald-400">ShopStore</span>
                </h1>

                <p class="text-base text-gray-400">
                    Ajoutez vos articles au panier en un clic et retrouvez tout dans votre espace client.
                </p>
            </div>

            <!-- Catalogue de Produits -->
            <div class="space-y-6">
                <div class="flex justify-between items-center border-b border-gray-800 pb-4">
                    <h2 class="text-2xl font-bold tracking-tight text-white">Produits disponibles</h2>
                    <span
                        class="text-xs font-semibold text-emerald-400 bg-emerald-500/10 px-3 py-1.5 rounded-full border border-emerald-500/20">
                        {{ products.length }} articles
                    </span>
                </div>

                <div v-if="products.length === 0"
                    class="text-center py-12 bg-[#121816] rounded-2xl border border-gray-800">
                    <p class="text-gray-400">Aucun produit disponible pour le moment.</p>
                </div>

                <div v-else class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-6">
                    <div v-for="product in products" :key="product.id"
                        class="bg-[#121816] border border-gray-800 rounded-2xl p-6 flex flex-col justify-between hover:border-emerald-500/40 transition shadow-xl">
                        <div>
                            <div class="flex justify-between items-start gap-2">
                                <h3 class="text-lg font-bold text-white">{{ product.name }}</h3>
                                <span :class="[
                                    'text-xs font-semibold px-2.5 py-1 rounded-full border shrink-0',
                                    product.stock > 0
                                        ? 'bg-emerald-500/10 text-emerald-400 border-emerald-500/20'
                                        : 'bg-red-500/10 text-red-400 border-red-500/20'
                                ]">
                                    {{ product.stock > 0 ? `Stock : ${product.stock}` : 'Rupture' }}
                                </span>
                            </div>
                            <p class="text-sm text-gray-400 mt-3 leading-relaxed">
                                {{ product.description }}
                            </p>
                        </div>

                        <div class="mt-6 pt-4 border-t border-gray-800 flex justify-between items-center gap-3">
                            <span class="text-lg font-extrabold text-emerald-400">
                                {{ Number(product.price).toLocaleString() }} XAF
                            </span>

                            <button @click="addToCart(product)"
                                :disabled="product.stock <= 0 || loadingProductId === product.id"
                                class="bg-emerald-600 hover:bg-emerald-500 disabled:opacity-40 disabled:cursor-not-allowed text-white text-xs sm:text-sm font-semibold px-4 py-2.5 rounded-xl shadow transition active:scale-95">
                                {{ loadingProductId === product.id ? 'Ajout...' : 'Ajouter au panier' }}
                            </button>
                        </div>
                    </div>
                </div>
            </div>
        </main>

        <!-- TIROIR DU PANIER (Drawer) -->
        <div v-if="isCartOpen" class="fixed inset-0 z-50 flex justify-end">
            <!-- Fond sombre -->
            <div @click="isCartOpen = false" class="fixed inset-0 bg-black/70 backdrop-blur-xs"></div>

            <!-- Panneau latéral -->
            <aside
                class="relative w-full max-w-md bg-[#121816] border-l border-gray-800 h-full flex flex-col justify-between z-10 shadow-2xl">
                <!-- En-tête panier -->
                <div class="p-6 border-b border-gray-800 flex justify-between items-center">
                    <div class="flex items-center space-x-2">
                        <h3 class="text-lg font-bold text-white">Mon Panier</h3>
                        <span class="text-xs bg-emerald-500/15 text-emerald-400 px-2.5 py-0.5 rounded-full font-bold">
                            {{ totalItemsCount }}
                        </span>
                    </div>
                    <button @click="isCartOpen = false" class="text-gray-400 hover:text-white text-xl font-bold px-2">
                        &times;
                    </button>
                </div>

                <!-- Contenu panier -->
                <div class="p-6 flex-grow overflow-y-auto space-y-4">
                    <div v-if="!isAuthenticated" class="text-center py-10 space-y-4">
                        <p class="text-sm text-gray-400">Connectez-vous pour enregistrer et gérer votre panier.</p>
                        <a :href="routes.login"
                            class="inline-block bg-emerald-600 hover:bg-emerald-500 text-white text-sm font-semibold px-5 py-2.5 rounded-xl">
                            Se connecter
                        </a>
                    </div>

                    <div v-else-if="!cart.items || cart.items.length === 0" class="text-center py-12">
                        <p class="text-gray-400 text-sm">Votre panier est vide pour le moment.</p>
                    </div>

                    <div v-else v-for="item in cart.items" :key="item.id"
                        class="bg-[#0b0f0e] border border-gray-800 rounded-xl p-4 flex flex-col space-y-3">
                        <div class="flex justify-between items-start gap-2">
                            <div>
                                <h4 class="font-bold text-white text-sm">{{ item.product?.name }}</h4>
                                <p class="text-xs text-emerald-400 font-semibold mt-0.5">
                                    {{ Number(item.product?.price || 0).toLocaleString() }} XAF / unité
                                </p>
                            </div>
                            <button @click="removeItem(item)"
                                class="text-xs text-red-400 hover:text-red-300 font-medium">
                                Retirer
                            </button>
                        </div>

                        <div class="flex justify-between items-center pt-2 border-t border-gray-800/80">
                            <div class="flex items-center space-x-2">
                                <button @click="updateQuantity(item, item.quantity - 1)"
                                    class="w-7 h-7 rounded-lg bg-gray-800 hover:bg-gray-700 text-white font-bold flex items-center justify-center">
                                    -
                                </button>
                                <span class="text-sm font-bold px-2">{{ item.quantity }}</span>
                                <button @click="updateQuantity(item, item.quantity + 1)"
                                    class="w-7 h-7 rounded-lg bg-gray-800 hover:bg-gray-700 text-white font-bold flex items-center justify-center">
                                    +
                                </button>
                            </div>

                            <span class="text-sm font-extrabold text-white">
                                {{ (Number(item.product?.price || 0) * item.quantity).toLocaleString() }} XAF
                            </span>
                        </div>
                    </div>
                </div>

                <!-- Pied du panier (Total + bouton Commander qui arrivera à l'étape suivante) -->
                <div v-if="isAuthenticated && cart.items && cart.items.length > 0"
                    class="p-6 border-t border-gray-800 bg-[#0b0f0e]/60 space-y-4">
                    <div class="flex justify-between items-center">
                        <span class="text-sm text-gray-400 font-medium">Total estimé</span>
                        <span class="text-xl font-extrabold text-emerald-400">
                            {{ cartTotalXAF.toLocaleString() }} XAF
                        </span>
                    </div>

                    <button type="button" disabled
                        class="w-full bg-emerald-600/50 text-white font-semibold py-3 rounded-xl text-sm cursor-not-allowed">
                        Passer la commande (Étape suivante)
                    </button>
                </div>
            </aside>
        </div>

        <!-- Pied de page -->
        <footer class="w-full py-6 text-center text-xs text-gray-500 border-t border-gray-800">
            &copy; 2026 - ShopStore • Architecture Full-Stack Laravel & Vue 3.
        </footer>

    </div>
</template>
