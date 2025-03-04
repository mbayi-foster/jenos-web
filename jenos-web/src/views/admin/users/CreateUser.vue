<template>
    <div class="mb-5">
        <BreadCumb hote="Utilisateurs" page="Nouvel utilisateur" lien="/users" />
    </div>

    <div class="px-4 mx-auto max-w-2xl mt-4">
        <form method="post" enctype="multipart/form-data" @submit.prevent="handleSubmit">
            <div class="grid gap-4 sm:grid-cols-2 sm:gap-6">
                <div class="sm:col-span-2">
                    <label for="nom" class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">Email*</label>
                    <input type="email" name="nom" id="nom" v-model="user.email"
                        class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-full focus:ring-primary-600 focus:border-primary-600 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-primary-500 dark:focus:border-primary-500"
                        placeholder="Veillez nommer le plat" required>
                </div>
                <div class="sm:col-span-2">
                    <label for="nom" class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">Nom*</label>
                    <input type="text" name="nom" id="nom" v-model="user.nom"
                        class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-full focus:ring-primary-600 focus:border-primary-600 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-primary-500 dark:focus:border-primary-500"
                        placeholder="Veillez nommer le plat" required>
                </div>
                <div class="sm:col-span-2">
                    <label for="nom"
                        class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">Prénom*</label>
                    <input type="text" name="nom" id="nom" v-model="user.prenom"
                        class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-full focus:ring-primary-600 focus:border-primary-600 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-primary-500 dark:focus:border-primary-500"
                        placeholder="Veillez nommer le plat" required>
                </div>
                <div class="sm:col-span-2">
                    <label for="nom"
                        class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">Téléphone*</label>
                    <input type="number" name="nom" id="nom" v-model="user.phone"
                        class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-full focus:ring-primary-600 focus:border-primary-600 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-primary-500 dark:focus:border-primary-500"
                        placeholder="Veillez nommer le plat" required>
                </div>
                <div>
                    <label for="countries_multiple"
                        class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">Choisir les
                        rôles</label>
                    <div v-for="item in roles" class="flex items-center mb-4">
                        <input id="" type="checkbox" name="roles[]" :value="item['id']" v-model="user.roles"
                            class="w-4 h-4 text-blue-600 bg-gray-100 border-gray-300 rounded focus:ring-blue-500 dark:focus:ring-blue-600 dark:ring-offset-gray-800 focus:ring-2 dark:bg-gray-700 dark:border-gray-600">
                        <label for="default-checkbox"
                            class="ms-2 text-sm font-medium text-gray-900 dark:text-gray-300">{{ item['nom'] }}</label>
                    </div>
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
import { onMounted, ref } from 'vue';
const router = useRouter()
const user = ref({
    nom: '',
    prenom: '',
    email: '',
    phone: '',
    roles:[]
});
const load = ref(false)
const roles = ref([])

const handleSubmit = async () => {
     load.value = true
   
    try {
        console.log('Users avant envoi:', user.value.roles);
       if(user.value.roles.length >= 1){
        const data = await api.post('/users', user.value);
        console.log("Données après soumission : ", data);
        load.value = false
        router.push('/users'); 
       }else{
        alert(`Vous devez attribuer un role à l'utilisateur ${user.value.roles.length}`)
        load.value = false
       }
        
    } catch (error) {
        load.value = false
        alert("Erreur il se peut que cet utilisateur existe déjà si non veillez réessayer en checkant votre connexion")
        console.error('Erreur lors du chargement des éléments:', error.response ? error.response.data : error.message);
    }
};

const getRoles = async () => {
    try {
        roles.value = await api.get(`/roles`)
    } catch (error) {
        console.log(error)
    }
}

onMounted(getRoles)
</script>