import { defineStore } from 'pinia'

export const useUserStore = defineStore('user', {
  state: () => ({
    user: null,
    isAuthenticated: false,
  }),
  actions: {
    login(userData) {
      this.user = userData
      this.isAuthenticated = true
    
      localStorage.setItem('user', JSON.stringify(userData))
    },
    logout() {
      this.user = null
      this.isAuthenticated = false
      localStorage.removeItem('user')
    },
    loadUser() {
      const userData = JSON.parse(localStorage.getItem('user'))
      if (userData) {
        this.user = userData
        this.isAuthenticated = true
      }
    },
  },
})