<template>
    <div class="mb-5">
        <BreadCumb hote="Plats" page="Nouveau plat" lien="/plats" />
    </div>
    <div class="px-4 mx-auto max-w-2xl mt-4">
        <form method="post" enctype="multipart/form-data" @submit.prevent="handleSubmit">
            <div class="grid gap-4 sm:grid-cols-2 sm:gap-6">
                <div class="sm:col-span-2">
                    <label for="nom" class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">Nom*</label>
                    <input type="text" name="nom" id="nom" v-model="plat.nom"
                        class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-full focus:ring-primary-600 focus:border-primary-600 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-primary-500 dark:focus:border-primary-500"
                        placeholder="Veillez nommer le plat" required>
                </div>
                <div class="sm:col-span-2">
                    <label for="prix" class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">Prix*</label>
                    <input type="text" v-model="plat.prix" id="prix"
                        class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-full focus:ring-primary-600 focus:border-primary-600 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-primary-500 dark:focus:border-primary-500"
                        placeholder="Veillez nommer le plat" required>
                </div>
               <!--  <div class="sm:col-span-2">
                    <label for="qte" class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">Quantité
                        initiale*</label>
                    <input type="text" v-model="plat.qte" id="qte"
                        class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-full focus:ring-primary-600 focus:border-primary-600 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-primary-500 dark:focus:border-primary-500"
                        placeholder="Veillez nommer le plat" required>
                </div> -->
                <div class="sm:col-span-2">

                    <label class="block mb-2 text-sm font-medium text-gray-900 dark:text-white"
                        for="photo">Photo*</label>
                    <input name="photo" required @change="handleFileUpload"
                        class="block w-full text-sm text-gray-900 border border-gray-300 rounded-full cursor-pointer bg-gray-50 dark:text-gray-400 focus:outline-none dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400"
                        aria-describedby="file_input_help" id="photo" type="file" accept=".png, .jpg, .jpeg">
                    <p class="mt-1 text-sm text-gray-500 dark:text-gray-300" id="file_input_help">PNG, JPG ou JPEG
                        (MAX. 800x400px).</p>

                </div>
                <div v-if="imagePreview">
                    <h2>Aperçu de l'image :</h2>
                    <img :src="imagePreview" alt="Aperçu" width="200" />
                </div>
                <div class="sm:col-span-2">

                    <label for="details" class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">Détails
                        du plat*</label>
                    <textarea id="details" rows="4" v-model="plat.details"
                        class="block p-2.5 w-full text-sm text-gray-900 bg-gray-50 rounded-xl border border-gray-300 focus:ring-blue-500 focus:border-blue-500 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500"
                        placeholder="Détaillez le plat..." required></textarea>
                </div>
            </div>
            <div v-if="load" class="py-5">
                <div role="status" class="flex justify-center items-center">
                    <svg aria-hidden="true"
                        class="w-8 h-8 text-gray-200 animate-spin dark:text-gray-600 fill-yellow-500"
                        viewBox="0 0 100 101" fill="none" xmlns="http://www.w3.org/2000/svg">
                        <path
                            d="M100 50.5908C100 78.2051 77.6142 100.591 50 100.591C22.3858 100.591 0 78.2051 0 50.5908C0 22.9766 22.3858 0.59082 50 0.59082C77.6142 0.59082 100 22.9766 100 50.5908ZM9.08144 50.5908C9.08144 73.1895 27.4013 91.5094 50 91.5094C72.5987 91.5094 90.9186 73.1895 90.9186 50.5908C90.9186 27.9921 72.5987 9.67226 50 9.67226C27.4013 9.67226 9.08144 27.9921 9.08144 50.5908Z"
                            fill="currentColor" />
                        <path
                            d="M93.9676 39.0409C96.393 38.4038 97.8624 35.9116 97.0079 33.5539C95.2932 28.8227 92.871 24.3692 89.8167 20.348C85.8452 15.1192 80.8826 10.7238 75.2124 7.41289C69.5422 4.10194 63.2754 1.94025 56.7698 1.05124C51.7666 0.367541 46.6976 0.446843 41.7345 1.27873C39.2613 1.69328 37.813 4.19778 38.4501 6.62326C39.0873 9.04874 41.5694 10.4717 44.0505 10.1071C47.8511 9.54855 51.7191 9.52689 55.5402 10.0491C60.8642 10.7766 65.9928 12.5457 70.6331 15.2552C75.2735 17.9648 79.3347 21.5619 82.5849 25.841C84.9175 28.9121 86.7997 32.2913 88.1811 35.8758C89.083 38.2158 91.5421 39.6781 93.9676 39.0409Z"
                            fill="currentFill" />
                    </svg>
                    <span class="sr-only">Loading...</span>
                </div>
                <p class="text-center mb-3 text-lg text-gray-500 md:text-xl dark:text-gray-400">
                    chargement...
                </p>
            </div>
            <div v-if="!load" class="flex justify-center items-center">
                <button type="submit"
                    class="text-white bg-yellow-500 hover:bg-yellow-300 focus:ring-4 focus:outline-none focus:ring-blue-300 font-medium rounded-full text-sm w-full sm:w-auto px-5 py-2.5 text-center dark:bg-blue-600 dark:hover:bg-blue-700 dark:focus:ring-blue-800 mt-4 me-4">Enregistrer</button>
                <button type="reset"
                    class="text-white bg-red-700 hover:bg-red-800 focus:ring-4 focus:outline-none focus:ring-red-300 font-medium rounded-full text-sm w-full sm:w-auto px-5 py-2.5 text-center dark:bg-red-600 dark:hover:bg-red-700 dark:focus:ring-red-800 mt-4">Reset</button>

            </div>
        </form>
    </div>
</template>
<script setup>
import BreadCumb from '@/components/BreadCumb.vue';
import { useRouter } from 'vue-router';
import api from '@/api/api'
import { ref } from 'vue';
const router = useRouter()
const plat = ref({
    nom: '',
    prix: '',
    details: '',
    photo: null,
});
const load = ref(false)

const imagePreview = ref(null);

const handleFileUpload = (event) => {
    const file = event.target.files[0];
    plat.value.photo = file;

    // Créer un aperçu de l'image
    if (file) {
        const reader = new FileReader();
        reader.onload = (e) => {
            imagePreview.value = e.target.result;
        };
        reader.readAsDataURL(file);
    }
};

const handleSubmit = async () => {
    load.value = true
    const formData = new FormData();
    formData.append('nom', plat.value.nom);
    formData.append('prix', plat.value.prix);
    formData.append('details', plat.value.details);
    if (plat.value.photo) {
        formData.append('photo', plat.value.photo);
    } else {
        console.error('Aucun fichier photo trouvé.');
        return; // Arrêtez l'exécution si aucun fichier
    }

    formData.forEach((e) => {
        console.log(e)
    })
    try {
        console.log('Plat avant envoi:', plat.value);
        const data = await api.post('/plats', formData);
        console.log("Données après soumission : ", data);
        load.value = false
        router.push('/plats'); // Décommenter si vous souhaitez rediriger
    } catch (error) {
        load.value = false
        console.error('Erreur lors du chargement des éléments:', error.response ? error.response.data : error.message);
    }
};
</script>