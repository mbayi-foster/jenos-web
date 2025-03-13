<template>
    <div class="mb-5">
        <BreadCumb hote="Plats" lien="/plats" page="Détails du plat" />
    </div>


    <div v-if="!loading">
        <!-- corps -->
        <div class="mx-auto mb-8 w-full grid grid-cols-2 gap-4">
            <button v-if="!plat.status" type="submit"
                class="rounded-lg w-full bg-green-500 text-white font-bold py-2">Publier</button>
            <button v-else type="submit"
                class="rounded-lg w-full bg-red-500 text-white font-bold py-2">Restreindre</button>
            <button type="submit" class="rounded-lg w-full bg-orange-500 text-white font-bold py-2">Modifier</button>
        </div>

        <div class="w-full grid lg:grid-cols-2 gap-4">
            <div class="lg:order-2">
                <!-- photo -->
                <img class="lg:h-96 w-full rounded-lg" :src="plat.photo" alt="">
            </div>
            <div class="lg:order-1 border-4">
                <!-- details -->
                <div class="md:px-5 px-2">
                    <p class="mb-2 text-4xl font-black text-gray-900 dark:text-white">{{ plat.nom }}</p>
                    <p
                        class="lg:overflow-y-auto lg:h-32 font-serif text-justify ml-5 text-base text-gray-900 dark:text-white">
                        {{ plat.details }}
                    </p>
                </div>

                <div class="mx-5 my-5">
                    <div class="sm:w-full border-2 border-orange-500  p-1 rounded-xl">
                        <p class="ml-4 text-base font-serif text-gray-900 dark:text-white">Prix :</p>
                        <p class="mb-2 text-center text-gray-900 font-semibold text-2xl dark:text-white">
                            {{ plat.prix }} Fc
                        </p>
                    </div>
                </div>
                <div class="mx-5 mb-3 grid grid-cols-2 gap-3">
                    <div class="m-auto w-full  border-2 border-black  p-1 rounded-xl">
                        <p class="ml-4 text-xs font-serif text-gray-900 dark:text-white">Like :</p>
                        <p class="text-center text-gray-900 font-semibold text-xl dark:text-white">{{ plat.like }}
                        </p>
                    </div>
                    <div class="m-auto w-full border-2 border-red-500 p-1 rounded-xl">
                        <p class="ml-4 text-xs font-serif text-gray-900 dark:text-white">Commandes :</p>
                        <p class="text-center text-gray-900 font-semibold text-xl dark:text-white">
                            {{ plat.commandes }}</p>
                    </div>
                </div>
                <p class="ml-8">{{ plat.date }}</p>
            </div>
        </div>
    </div>
    <div role="status" class="flex justify-center items-center" v-else>
        <svg aria-hidden="true" class="w-8 h-8 text-gray-200 animate-spin dark:text-gray-600 fill-yellow-500"
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
    <div v-if="erreur">
        <p class="text-center mb-3 text-lg text-red-500 md:text-xl dark:text-gray-400">
            Une erreur s'est produite veillez actualiser la page !
        </p>
        <button @click="fetchPlat" class="rounded-lg w-full bg-orange-500 text-white font-bold py-2">Actualiser</button>

    </div>

</template>
<script setup>
import BreadCumb from '@/components/BreadCumb.vue';
import { onMounted, ref } from 'vue';
import api from "@/api/api"
const props = defineProps({
    id: {
        type: Number
    }
})
const loading = ref(false)
const erreur = ref(false)
const plat = ref({})

const fetchPlat = async () => {
    loading.value = true

    try {
        erreur.value = false
        plat.value = await api.get(`/plats/${props.id}`)
        loading.value = false
        // console.log(`la data : `, data)
    } catch (error) {
        erreur.value = true
    }
}

onMounted(fetchPlat)
</script>

<style>
.my-height {
    height: 65vh;
}
</style>