/* import { ref, computed } from 'vue'
import { defineStore } from 'pinia'
import api from '@/api/api.js'
export const useUserStore = defineStore('user', () => {
  const user = ref([])
  const userId = ref<Number | null>(null);
   const doubleCount = computed(() => count.value * 2)
  function increment() {
    count.value++
  } 

  const seConnecter = (id: Number) => {
    userId.value = id;
    localStorage.setItem('userId', JSON.stringify(id));
  };

 const recupererUser =  async (): Promise<string> => {
  const id = localStorage.getItem()
   try {
    const data = await api.get()
   } catch (error) {
    console.log(error)
   }
  }


  return { user, userId, seConnecter, }
})
 */