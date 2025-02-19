<template>
    <div class="mb-5">
        <BreadCumb hote="Utilisateurs" lien="#" page="Utilisateurs" :principale="true"/>
    </div>
    <TableUsers :data="users" :columns="tablesColumn" :has-data="hasData" :load="load" :refresh="fetchItems" />
</template>
<script setup>

import { onMounted, ref } from 'vue';
import BreadCumb from '@/components/BreadCumb.vue';
import TableUsers from '@/components/tables/TableUsers.vue';
import api from '@/api/api'


const users = ref([])
const tablesColumn = ref([
    { key: 'nom', label: 'Utilisateur' },
    { key: 'email', label: 'Contact' },
    { key: 'status', label: 'Status' },
])
const hasData = ref(false)
const load = ref(true)

const fetchItems = async () => {
    try {
        load.value = true
        hasData.value = false
        const data = await api.get('/users')
        console.log("les users", data)

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

onMounted(fetchItems)

</script>