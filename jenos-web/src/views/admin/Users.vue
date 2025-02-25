<template>
    <div class="mb-5">
        <BreadCumb hote="Utilisateurs" lien="#" page="Utilisateurs" :principale="true" />
    </div>
    <TableUsers @change-status="change" :data="users" :columns="tablesColumn" :has-data="hasData" :load="load"
        :refresh="fetchItems" @modifier-user="showForm" />
    <div v-if="show" tabindex="-1" aria-hidden="true"
        class="overflow-y-auto overflow-x-hidden fixed top-0 right-0 left-0 z-50 flex justify-center items-center w-full h-full md:inset-0">
        <div class="relative p-4 w-full max-w-md max-h-full">
            <!-- Modal content -->
            <div class="relative bg-white rounded-lg shadow dark:bg-gray-700">
                <!-- Modal header -->
                <div class="flex items-center justify-between p-4 md:p-5 border-b rounded-t dark:border-gray-600">
                    <h3 class="text-xl font-semibold text-gray-900 dark:text-white">
                        Mettre à jour l'utilisateur
                    </h3>
                    <button type="button" @click="showForm"
                        class="end-2.5 text-gray-400 bg-transparent hover:bg-gray-200 hover:text-gray-900 rounded-lg text-sm w-8 h-8 ms-auto inline-flex justify-center items-center dark:hover:bg-gray-600 dark:hover:text-white">
                        <svg class="w-3 h-3" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="none"
                            viewBox="0 0 14 14">
                            <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="m1 1 6 6m0 0 6 6M7 7l6-6M7 7l-6 6" />
                        </svg>
                        <span class="sr-only">Close modal</span>
                    </button>
                </div>
                <!-- Modal body -->
                <div class="p-4 md:p-5">
                    <form method="post" id="change">
                        <div class="grid gap-4 sm:grid-cols-2 sm:gap-6">
                            <div class="sm:col-span-2">
                                <label for="email"
                                    class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">Email : {{
                                    user['email'] }} </label>
                                <!-- <input type="email" v-model="user['email']" id="email" disabled
                                    class="bg-gray-200 text-gray-500 text-sm rounded-lg focus:ring-primary-600 focus:border-primary-600 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-primary-500 dark:focus:border-primary-500"
                                    placeholder="Veillez entrer l'adresse email de l'utilisateur" required=""> -->
                            </div>
                            <div class="w-full">
                                <label for="nom"
                                    class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">Nom</label>
                                <input type="text" v-model="user['nom']" id="nom"
                                    class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-primary-600 focus:border-primary-600 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-primary-500 dark:focus:border-primary-500"
                                    placeholder="Nom de l'utilisateur" required="">
                            </div>
                            <div class="w-full">
                                <label for="prenom"
                                    class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">Prénom</label>
                                <input type="text" v-model="user['prenom']" id="prenom"
                                    class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-primary-600 focus:border-primary-600 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-primary-500 dark:focus:border-primary-500"
                                    placeholder="Prénom de l'utilisateur" required="">
                            </div>
                            <div>
                                <label for="phone"
                                    class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">Téléphone</label>
                                <input type="number" v-model="user['phone']" id="phone"
                                    class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-primary-600 focus:border-primary-600 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-primary-500 dark:focus:border-primary-500"
                                    placeholder="Le numéro de téléphone" required="">
                            </div>
                            <div>
                                <label for="countries_multiple"
                                    class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">Choisir les
                                    rôles</label>
                                <div v-for="item in roles" class="flex items-center mb-4">
                                    <input id="" type="checkbox" name="roles[]" value=""
                                        class="w-4 h-4 text-blue-600 bg-gray-100 border-gray-300 rounded focus:ring-blue-500 dark:focus:ring-blue-600 dark:ring-offset-gray-800 focus:ring-2 dark:bg-gray-700 dark:border-gray-600">
                                    <label for="default-checkbox"
                                        class="ms-2 text-sm font-medium text-gray-900 dark:text-gray-300">{{item['nom']}}</label>
                                </div>
                            </div>

                        </div>
                        <div class="flex justify-center items-center">
                            <button type="submit"
                                class="text-white bg-blue-700 hover:bg-blue-800 focus:ring-4 focus:outline-none focus:ring-blue-300 font-medium rounded-lg text-sm w-full sm:w-auto px-5 py-2.5 text-center dark:bg-blue-600 dark:hover:bg-blue-700 dark:focus:ring-blue-800 mt-4 me-4">Enregistrer</button>
                            <button type="reset"
                                class="text-white bg-red-700 hover:bg-red-800 focus:ring-4 focus:outline-none focus:ring-red-300 font-medium rounded-lg text-sm w-full sm:w-auto px-5 py-2.5 text-center dark:bg-red-600 dark:hover:bg-red-700 dark:focus:ring-red-800 mt-4">Reset</button>

                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</template>



<script setup>

import { onMounted, ref } from 'vue';
import BreadCumb from '@/components/BreadCumb.vue';
import TableUsers from '@/components/tables/TableUsers.vue';
import api from '@/api/api'

const show = ref(false)
const user = ref([])
const users = ref([])
const tablesColumn = ref([
    { key: 'nom', label: 'Utilisateur' },
    { key: 'email', label: 'Contact' },
    { key: 'roles', label: 'Roles' },
    { key: 'status', label: 'Status' },
])
const hasData = ref(false)
const load = ref(true)
const roles = ref([])

const fetchItems = async () => {
    try {
        load.value = true
        hasData.value = false
        const data = await api.get('/users')
        if (Array.isArray(data) && data.length >= 1) {
            users.value = data
            load.value = false
            hasData.value = true
        }
    } catch (error) {
        hasData.value = false
        load.value = false
        console.log(error)
    }
}
const showForm = (utilisateur) => {
    if (utilisateur) {
        user.value = utilisateur
        console.log(user.value)
    }
    show.value = (show.value == true) ? false : true
}

const change = async (id) => {
    try {
        await api.get(`/status/change/${id}`)
        fetchItems()
    } catch (error) {
        console.log(error)
    }
}
const getRoles = async () => {
    try {
       roles.value =  await api.get(`/roles`)
       console.log("les roles sont : ", roles.value)
    } catch (error) {
        console.log(error)
    }
}

onMounted(fetchItems, getRoles)

</script>