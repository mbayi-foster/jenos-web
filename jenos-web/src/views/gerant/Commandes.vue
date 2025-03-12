<template>
    <div class="mb-5">
        <BreadCumb hote="Commandes" lien="#" page="Commandes" :principale="true" />
    </div>
    <TableCommandes @effacer="effacer" @change-status="change" :data="plats" :columns="tablesColumn" :has-data="hasData"
        :load="load" :refresh="fetchItems" />

</template>

<script setup>
import { onMounted, ref } from 'vue';
import BreadCumb from '@/components/BreadCumb.vue';
import TablePlats from '@/components/tables/TablePlats.vue';
import TableCommandes from '@/components/tables/TableCommandes.vue';
import api from '@/api/api'

const plats = ref([])
const tablesColumn = ref([
    { key: 'ticket', label: 'Ticket' },

])
const hasData = ref(false)
const load = ref(true)

const fetchItems = async () => {
    try {
        load.value = true
        hasData.value = false
        const data = await api.get('/commandes')
        if (Array.isArray(data) && data.length >= 1) {
            plats.value = data
            load.value = false
            hasData.value = true
        } else {
            load.value = false
            hasData.value = false
        }
    } catch (error) {
        hasData.value = false
        load.value = false
        console.log(error)
    }
}
const change = async (id) => {
    try {
        await api.get(`/plats/status/change/${id}`)
        fetchItems()
    } catch (error) {
        console.log(error)
    }
}
const effacer = async (id) => {
    try {
        await api.delete(`/plats/${id}`)
        fetchItems()
    } catch (error) {
        console.log(error)
    }
}


onMounted(fetchItems)
</script>