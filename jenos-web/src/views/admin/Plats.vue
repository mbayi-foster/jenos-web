<template>
    <div class="mb-5">
        <BreadCumb hote="Plats" lien="#" page="Plats" :principale="true" />
    </div>
    <TablePlats @effacer="effacer" @change-status="change" :data="plats" :columns="tablesColumn" :has-data="hasData" :load="load" :refresh="fetchItems" />

</template>

<script setup>
import { onMounted, ref } from 'vue';
import BreadCumb from '@/components/BreadCumb.vue';
import TablePlats from '@/components/tables/TablePlats.vue';
import api from '@/api/api'

const plats = ref([])
const tablesColumn = ref([
    { key: 'nom', label: 'Nom' },
    { key: 'photo', label: 'Photo' },
    { key: 'prix', label: 'Prix' },
    { key: 'commandes', label: 'Commandes' },
    { key: 'like', label: 'Like' },
    { key: 'status', label: 'Status' },

])
const hasData = ref(false)
const load = ref(true)

const fetchItems = async () => {
    try {
        load.value = true
        hasData.value = false
        const data = await api.get('/plats')
        if (Array.isArray(data) && data.length >= 1) {
            plats.value = data
            load.value = false
            hasData.value = true
        }else{
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