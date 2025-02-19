<template>
    <div class="mb-5">
        <BreadCumb hote="Menus" lien="#" page="Menus" :principale="true" />
    </div>
    <TablesMenus @change-status="change" :data="menus" :columns="tablesColumn" :has-data="hasData" :load="load"
        :refresh="fetchItems" />
</template>
<script setup>
import BreadCumb from '@/components/BreadCumb.vue';
import TablesMenus from '@/components/tables/TablesMenus.vue';
import api from '@/api/api'
import { ref, onMounted, computed } from "vue"

const menus = ref([])
const tablesColumn = ref([
    { key: 'nom', label: 'Menus' },
    { key: 'photo', label: 'Photo' },
    { key: 'count', label: 'Plats' },
    { key: 'status', label: 'Status' },
])
const hasData = ref(false)
const load = ref(true)

const fetchItems = async () => {
    try {
        load.value = true
        hasData.value = false
        const data = await api.get('/menus')
        console.log("les menus", data)

        if (Array.isArray(data) && data.length >= 1) {
            menus.value = data
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
        await api.get(`/menus/status/change/${id}`)
        fetchItems()
    } catch (error) {
    }
}

onMounted(fetchItems)

</script>