<script setup>
import { ref, onMounted } from 'vue';
import axios from 'axios';

const students = ref([]);
const form = ref({
    nom: '',
    prenom: '',
    email: '',
    filiere: ''
});

// Charger la liste des étudiants
const fetchStudents = async () => {
    try {
        const response = await axios.get('/students');
        students.value = response.data;
    } catch (error) {
        console.error("Erreur lors du chargement :", error);
    }
};

// Ajouter un étudiant
const submitStudent = async () => {
    try {
        await axios.post('/students', form.value);
        form.value = { nom: '', prenom: '', email: '', filiere: '' };
        fetchStudents();
    } catch (error) {
        console.error("Erreur lors de l'ajout :", error);
        alert("Vérifie les informations saisies.");
    }
};

// Supprimer un étudiant
const deleteStudent = async (id) => {
    if (confirm("Voulez-vous vraiment supprimer cette étudiant ?")) {
        try {
            await axios.delete(`/students/${id}`);
            fetchStudents();
        } catch (error) {
            console.error("Erreur lors de la suppression :", error);
        }
    }
};

onMounted(() => {
    fetchStudents();
});
</script>

<template>
    <div class="max-w-4xl mx-auto p-6 bg-white shadow-lg rounded-xl mt-10">
        <h1 class="text-2xl font-bold text-gray-800 mb-6">Gestion des Étudiants</h1>

        <!-- Formulaire d'ajout -->
        <form @submit.prevent="submitStudent"
            class="grid grid-cols-1 md:grid-cols-2 gap-4 mb-8 bg-gray-50 p-4 rounded-lg border">
            <div>
                <label class="block text-sm font-medium text-gray-700">Nom</label>
                <input v-model="form.nom" type="text" required
                    class="mt-1 block w-full rounded-md border-gray-300 shadow-sm p-2 border" />
            </div>
            <div>
                <label class="block text-sm font-medium text-gray-700">Prénom</label>
                <input v-model="form.prenom" type="text" required
                    class="mt-1 block w-full rounded-md border-gray-300 shadow-sm p-2 border" />
            </div>
            <div>
                <label class="block text-sm font-medium text-gray-700">Email</label>
                <input v-model="form.email" type="email" required
                    class="mt-1 block w-full rounded-md border-gray-300 shadow-sm p-2 border" />
            </div>
            <div>
                <label class="block text-sm font-medium text-gray-700">Filière</label>
                <input v-model="form.filiere" type="text" required
                    class="mt-1 block w-full rounded-md border-gray-300 shadow-sm p-2 border" />
            </div>
            <div class="md:col-span-2">
                <button type="submit"
                    class="w-full bg-indigo-600 text-white font-semibold py-2 px-4 rounded-md hover:bg-indigo-700 transition">
                    Ajouter l'étudiant
                </button>
            </div>
        </form>

        <!-- Liste des étudiants -->
        <div class="overflow-x-auto">
            <table class="min-w-full divide-y divide-gray-200">
                <thead class="bg-gray-100">
                    <tr>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">ID</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Nom & Prénom</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Email</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Filière</th>
                        <th class="px-6 py-3 text-right text-xs font-medium text-gray-500 uppercase">Actions</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-gray-200">

                    <tr v-for="student in students" :key="student.id">
                          <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">{{ student.id }}</td>
                        <td class="px-6 py-4 whitespace-nowrap text-sm font-medium text-gray-900">
                            {{ student.nom }} {{ student.prenom }}
                        </td>
                        <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">{{ student.email }}</td>
                        <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">{{ student.filiere }}</td>
                        <td class="px-6 py-4 whitespace-nowrap text-right text-sm font-medium">
                            <button @click="deleteStudent(student.id)"
                                class="text-red-600 hover:text-red-900">Supprimer</button>
                        </td>
                    </tr>
                    <tr v-if="students.length === 0">
                        <td colspan="4" class="px-6 py-4 text-center text-sm text-gray-500">Aucun étudiant enregistré
                            pour le moment.</td>
                    </tr>
                </tbody>
            </table>
        </div>
    </div>
</template>
