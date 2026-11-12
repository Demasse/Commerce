import { createApp } from 'vue';
import GestionEtudiants from './components/GestionEtudiants.vue';

const app = createApp({});

// Enregistrement du composant
app.component('gestion-etudiants', GestionEtudiants);
app.component('accueil-page', Accueil);

// Montage de Vue
app.mount('#app');
