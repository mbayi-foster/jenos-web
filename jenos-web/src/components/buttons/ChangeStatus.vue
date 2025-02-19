<template>
    <button @click="openOrClose" data-modal-target="popup-modal1" data-modal-toggle="popup-modal1" type="button"
        title="Activer"
        class="inline-flex items-center px-6 py-2.5 text-sm font-medium text-gray-900 bg-white border border-gray-200 rounded-s-lg hover:bg-gray-100 hover:text-blue-700 focus:z-10 focus:ring-2 focus:ring-blue-700 focus:text-blue-700 dark:bg-gray-800 dark:border-gray-700 dark:text-white dark:hover:text-white dark:hover:bg-gray-700 dark:focus:ring-blue-500 dark:focus:text-white">
        <i v-if="status" class="text-green-500 fa-solid fa-toggle-on text-base"></i>
        <i v-else class="text-red-600 fa-solid fa-toggle-off text-base"></i>
    </button>
    <div tabindex="-1" v-if="isActive"
        class="overflow-y-auto overflow-x-hidden fixed top-0 right-0 left-0 z-50 flex justify-center items-center w-full h-full md:inset-0">
        <div class="relative p-4 w-full max-w-md">
            <div class="relative bg-white rounded-lg shadow dark:bg-gray-700">
                <button type="button" @click="openOrClose"
                    class="absolute top-3 right-3 text-gray-400 bg-transparent hover:bg-gray-200 hover:text-gray-900 rounded-lg text-sm w-8 h-8 inline-flex justify-center items-center dark:hover:bg-gray-600 dark:hover:text-white">
                    <svg class="w-3 h-3" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="none"
                        viewBox="0 0 14 14">
                        <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="m1 1 6 6m0 0 6 6M7 7l6-6M7 7l-6 6" />
                    </svg>
                    <span class="sr-only">Close modal</span>
                </button>
                <div class="p-4 md:p-5 text-center">
                    <svg class="mx-auto mb-4 text-gray-400 w-12 h-12 dark:text-gray-200" aria-hidden="true"
                        xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 20 20">
                        <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M10 11V6m0 8h.01M19 10a9 9 0 1 1-18 0 9 9 0 0 1 18 0Z" />
                    </svg>
                    <h3 v-if="props.status == 0" id="status" class="mb-5 text-lg font-normal text-gray-500 dark:text-gray-400">
                        {{ props.msgOui }}
                    </h3>
                    <h3 v-if="props.status == 1" id="status" class="mb-5 text-lg font-normal text-gray-500 dark:text-gray-400">
                        {{ props.msgNon }}
                    </h3>
                    <button @click="change(props.id)" id="non" type="button" v-if="!status"
                        class="text-white bg-green-600 hover:bg-green-800 focus:ring-4 focus:outline-none focus:ring-green-300 dark:focus:ring-green-red-800 font-medium rounded-lg text-sm inline-flex items-center px-5 py-2.5 text-center">
                        Oui
                    </button>
                    <button @click="change(props.id)" id="non" type="button" v-if="status"
                        class="text-white bg-red-600 hover:bg-red-800 focus:ring-4 focus:outline-none focus:ring-red-300 dark:focus:ring-green-red-800 font-medium rounded-lg text-sm inline-flex items-center px-5 py-2.5 text-center">
                        Oui
                    </button>
                    <button data-modal-hide="popup-modal1" type="button" @click="openOrClose"
                        class="py-2.5 px-5 ms-3 text-sm font-medium text-gray-900 focus:outline-none bg-white rounded-lg border border-gray-200 hover:bg-gray-100 hover:text-blue-700 focus:z-10 focus:ring-4 focus:ring-gray-100 dark:focus:ring-gray-700 dark:bg-gray-800 dark:text-gray-400 dark:border-gray-600 dark:hover:text-white dark:hover:bg-gray-700">Annuler</button>
                </div>
            </div>
        </div>
    </div>
</template>

<script setup>
import { ref, defineEmits } from 'vue';

const emit = defineEmits()

const props = defineProps({
    status: {
        type: Number,
        required: true
    },
    msgOui:{
        type:String,
        default:"Voulez vous vraiment activer cet utilisateur"
    },
    msgNon:{
        type:String,
        default:"Voulez vous vraiment désactiver cet utilisateur"
    },
    id: {
        type: Number,
        required: true
    }
})
const isActive = ref(false)

const openOrClose = () => {
    isActive.value = (isActive.value == true) ? false : true
}

const change = () => {
    isActive.value = false
    emit('change-status', props.id); // Émet un événement au parent
};

</script>