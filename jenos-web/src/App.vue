<script setup>
import { RouterLink, RouterView, useRouter } from 'vue-router'
import { useUserStore } from './stores/store'
import { watch, onMounted, ref } from 'vue';
import NavBar from './components/NavBar.vue';
const store = useUserStore()

const user = ref([])
const isConnected = ref(false)
const calcule = () => {
  store.loadUser()
  user.value = store.user
  isConnected.value = store.isAuthenticated
}
const router = useRouter()
onMounted(calcule)
watch(
  () => store.isAuthenticated,
  (newValue) => {
    isConnected.value = newValue;
    // Si l'utilisateur se déconnecte, redirigez vers la page de connexion
    if (!newValue) {
      // Rediriger vers la route de connexion
      router.push('/login');
    }else{
      calcule()
    }
  }
);
</script>

<template>
  <NavBar v-if="isConnected" :user="user" />
  <div v-if="isConnected" class="p-4 sm:ml-64">
    <div class="p-4 border-2 border-gray-200 border-dashed rounded-lg dark:border-gray-700 mt-14">
      <RouterView />
    </div>
  </div>

  <div v-else>
    <RouterView />
  </div>

</template>
