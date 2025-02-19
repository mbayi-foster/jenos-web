<template>
    <div class="mb-5">
        <BreadCumb hote="Zones" lien="/zones" page="Zones" :principale="true"/>
    </div>
    <TableZones @change-status="change" :data="zones" :columns="tablesColumn" :has-data="hasData" :load="load"
    :refresh="fetchItems" />
</template>

<script setup>
import BreadCumb from '@/components/BreadCumb.vue';
import TableZones from '@/components/tables/TableZones.vue';
import api from '@/api/api'
import { ref, onMounted, computed } from "vue"

const zones = ref([])
const tablesColumn = ref([
    { key: 'nom', label: 'Zones' },
    { key: 'gerant', label: 'Gérant' },
    { key: 'status', label: 'Status' },
])
const hasData = ref(false)
const load = ref(true)

const fetchItems = async () => {
    try {
        load.value = true
        hasData.value = false
        const data = await api.get('/zones')
        console.log("les zones", data)

        if (Array.isArray(data) && data.length >= 1) {
            zones.value = data
            load.value = false
            hasData.value = true
        }
    } catch (error) {
        hasData.value = false
        load.value = false
        console.log(error)
    }
}

const change = async (id) => {
    try {
        await api.get(`/zones/status/change/${id}`)
        fetchItems()
    } catch (error) {
    }
}

onMounted(fetchItems)

</script>