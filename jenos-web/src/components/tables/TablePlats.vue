<template>
    <div class="relative overflow-x-auto shadow-md sm:rounded-lg">
        <div class="flex justify-between items-center">
            <div class="pb-4 bg-white dark:bg-gray-900">
                <label for="table-search" class="sr-only">Search</label>
                <div class="relative mt-1">
                    <div class="absolute inset-y-0 rtl:inset-r-0 start-0 flex items-center ps-3 pointer-events-none">
                        <svg class="w-4 h-4 text-gray-500 dark:text-gray-400" aria-hidden="true"
                            xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 20 20">
                            <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="m19 19-4-4m0-7A7 7 0 1 1 1 8a7 7 0 0 1 14 0Z" />
                        </svg>
                    </div>
                    <input type="text" id="table-search"
                        class="block pt-2 ps-10 text-sm text-gray-900 border border-gray-300 rounded-lg w-80 bg-gray-50 focus:ring-blue-500 focus:border-blue-500 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500"
                        v-model="searchQuery" placeholder="Rechercher..." />
                </div>
            </div>
            <div>
                <router-link to="/plats/create" title="Ajouter un plat">
                    <button type="button"
                        class="text-center rounded-full text-green-400 hover:text-white border border-green-400 hover:bg-green-500 focus:ring-4 focus:outline-none focus:ring-green-300 font-medium text-sm w-12 h-12 me-2 mb-2 dark:border-green-300 dark:text-green-300 dark:hover:text-white dark:hover:bg-green-400 dark:focus:ring-green-900">
                        <i class="fa-solid fa-plus"></i>
                    </button>
                </router-link>
                <button type="button" title="Actualiser" @click="refresh()"
                    class="me-5 text-center rounded-full text-yellow-400 hover:text-white border border-yellow-400 hover:bg-yellow-500 focus:ring-4 focus:outline-none focus:ring-yellow-300 font-medium text-sm w-12 h-12 mb-2 dark:border-yellow-300 dark:text-yellow-300 dark:hover:text-white dark:hover:bg-yellow-400 dark:focus:ring-yellow-900">
                    <i class="fa-solid fa-rotate"></i>
                </button>
            </div>
        </div>
        <table class="w-full text-sm text-left rtl:text-right text-gray-500 dark:text-gray-400">
            <thead class="text-xs text-gray-700 uppercase bg-gray-50 dark:bg-gray-700 dark:text-gray-400">
                <tr>
                    <th class="px-6 py-3">
                        #
                    </th>
                    <th v-for="column in columns" :key="column.key" scope="col" class="px-6 py-3">
                        {{ column.label }}
                    </th>
                    <th>Actions</th>
                </tr>
            </thead>
            <tbody v-if="hasData && !load">
                <tr v-for="(item, index) in paginatedData" :key="item.id" scope="row" class="px-6 py-4">
                    <td>
                        {{ index+1 }}
                    </td>
                    <td v-for="column in columns" :key="column.key">
                        <div v-if="column.key == 'photo'">
                            <img class="h-20 max-w-lg rounded-lg" :src="item['photo']" alt="photo du plat">
                        </div>
                        <div class="flex items-center" v-else-if="column.key == 'status'">
                            <div class="h-2.5 w-2.5 rounded-full bg-green-500 me-2" v-if="item['status'] == true"></div>
                            <div class="h-2.5 w-2.5 rounded-full bg-red-500 me-2" v-if="item['status'] == false"></div>
                            Status
                        </div>
                        <!-- <div v-else-if="column.key == 'qte'">
                            <p>Disponible : {{ item['qte'] }}</p>
                            <p>Commandées : {{ item['commandes'] }}</p>
                        </div> -->
                        <div v-else class="align-top text-start justify-start items-start flex">
                            {{ item[column.key] }}
                        </div>
                    </td>
                    <td class="text-center">
                        <div class="inline-flex rounded-md shadow-sm" role="group">
                            <change-status msg-oui="Voulez vous vraiment activer ce plat"
                            msg-non="Voulez vous vraiment désactiver ce plat"  :id="item['id']" :status="item['status']" @change-status="change" />
                           <supprimer  msg="Voulez vous vraiment supprimer ce plat" :id="item['id']" @effacer="effacer"/>
                            <router-link type="button" :to="`menus/${item['id']}`" title="Voir plus..."
                                class="inline-flex items-center px-6 py-2.5 text-sm font-medium text-gray-900 bg-white border border-gray-200 rounded-e-lg hover:bg-gray-100 hover:text-blue-700 focus:z-10 focus:ring-2 focus:ring-blue-700 focus:text-blue-700 dark:bg-gray-800 dark:border-gray-700 dark:text-white dark:hover:text-white dark:hover:bg-gray-700 dark:focus:ring-blue-500 dark:focus:text-white">
                                <i class="fa-solid fa-circle-info text-base"></i>
                            </router-link>
                        </div>
                    </td>
                </tr>
            </tbody>
        </table>
        <div v-if="load" class="py-5">
            <div role="status" class="flex justify-center items-center">
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
            <p class="text-center mb-3 text-lg text-gray-500 md:text-xl dark:text-gray-400">
                chargement...
            </p>
        </div>
        <p v-if="!hasData && !load" class="text-center mb-3 text-lg text-red-500 md:text-xl dark:text-gray-400">
            Aucune données à afficher veillez actualiser !
        </p>
        <nav class="flex items-center flex-column flex-wrap md:flex-row justify-between pt-4"
            aria-label="Table navigation">
            <span
                class="text-sm font-normal text-gray-500 dark:text-gray-400 mb-4 md:mb-0 block w-full md:inline md:w-auto">
                Showing
                <span class="font-semibold text-gray-900 dark:text-white">{{ startIndex }}-{{ endIndex }} of
                    <span class="font-semibold text-gray-900 dark:text-white">{{ totalItems }}</span></span>
            </span>
            <ul class="inline-flex -space-x-px rtl:space-x-reverse text-sm h-8">
                <li>
                    <a @click.prevent="prevPage"
                        class="flex items-center justify-center px-3 h-8 ms-0 leading-tight text-gray-500 bg-white border border-gray-300 rounded-s-lg hover:bg-gray-100 hover:text-gray-700 dark:bg-gray-800 dark:border-gray-700 dark:text-gray-400 dark:hover:bg-gray-700 dark:hover:text-white">Previous</a>
                </li>
                <li v-for="page in totalPagesArray" :key="page">
                    <a @click.prevent="goToPage(page)" :class="[
                        'flex items-center justify-center px-3 h-8 leading-tight',
                        {
                            'text-blue-600 border border-gray-300 bg-blue-50': page === currentPage.value,
                            'text-gray-500 bg-white border border-gray-300 hover:bg-gray-100 hover:text-gray-700 dark:bg-gray-800 dark:border-gray-700 dark:text-gray-400 dark:hover:bg-gray-700 dark:hover:text-white':
                                page !== currentPage.value,
                        },
                    ]">
                        {{ page }}
                    </a>
                </li>
                <li>
                    <a @click.prevent="nextPage"
                        class="flex items-center justify-center px-3 h-8 leading-tight text-gray-500 bg-white border border-gray-300 rounded-e-lg hover:bg-gray-100 hover:text-gray-700 dark:bg-gray-800 dark:border-gray-700 dark:text-gray-400 dark:hover:bg-gray-700 dark:hover:text-white">Next</a>
                </li>
            </ul>
        </nav>
    </div>
</template>

<script setup>
import ChangeStatus from '../buttons/ChangeStatus.vue'
import Supprimer from '../buttons/Supprimer.vue'
import { ref, computed } from 'vue'
const props = defineProps({
    refresh: {
        type: Function,
    },
    data: {
        type: Array,
        required: true,
    },
    hasData: {
        type: Boolean,
        default: false,
    },
    load: {
        type: Boolean,
        default: true,
    },
    columns: {
        type: Array,
        required: true,
    },
    itemsPerPage: {
        type: Number,
        default: 10,
    },
})

const currentPage = ref(1)
const filters = ref({})
const searchQuery = ref('')

const filteredData = computed(() => {
    return props.data.filter((item) => {
        const filteredBySearch = Object.values(item).some((value) => {
            return (
                value !== null && value.toString().toLowerCase().includes(searchQuery.value.toLowerCase())
            )
        })
        const filteredByFilters = Object.keys(filters.value).every((key) => {
            return (
                !filters.value[key] ||
                item[key].toString().toLowerCase().includes(filters.value[key].toLowerCase())
            )
        })

        return filteredBySearch && filteredByFilters
        //  return item
    })
})

const totalItems = computed(() => filteredData.value.length)
const totalPages = computed(() => Math.ceil(totalItems.value / props.itemsPerPage))

const startIndex = computed(() => (currentPage.value - 1) * props.itemsPerPage + 1)
const endIndex = computed(() => Math.min(currentPage.value * props.itemsPerPage, totalItems.value))

const paginatedData = computed(() => {
    const start = (currentPage.value - 1) * props.itemsPerPage
    return filteredData.value.slice(start, start + props.itemsPerPage)
})

const totalPagesArray = computed(() => Array.from({ length: totalPages.value }, (_, i) => i + 1))

const nextPage = () => {
    if (currentPage.value < totalPages.value) {
        currentPage.value++
    }
}

const prevPage = () => {
    if (currentPage.value > 1) {
        currentPage.value--
    }
}

const goToPage = (page) => {
    currentPage.value = page
}

const emit = defineEmits()
const change = (id) => {
  emit('change-status', id); 
};
const effacer = (id) => {
  emit('effacer', id);
};
</script>

<style scoped>
table {
    width: 100%;
    border-collapse: collapse;
}

th,
td {
    border: 1px solid #ddd;
    padding: 8px;
}

th {
    background-color: #f2f2f2;
}
</style>