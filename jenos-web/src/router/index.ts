import { createRouter, createWebHistory } from 'vue-router'
import HomeView from '../views/HomeView.vue'
import Login from '@/views/auth/Login.vue'
import Users from '@/views/admin/Users.vue'
import Plat from '@/views/admin/CreatePlat.vue'
import Plats from '@/views/admin/Plats.vue'
import Menus from '@/views/admin/Menus.vue'
import CreateMenu from '@/views/admin/CreateMenu.vue'

const router = createRouter({
  history: createWebHistory(import.meta.env.BASE_URL),
  routes: [
    {
      path: '/',
      name: 'home',
      component: HomeView,
    },
    {
      path: '/login',
      name:'Login',
      component:Login
    },
    {
      path: '/users',
      name:'Utilisateurs',
      component:Users
    },
    {
      path: '/plats/create',
      name:'Nouveau plat',
      component:Plat
    },
    {
      path: '/menus',
      name:'Menus',
      component:Menus
    },
    {
      path: '/menus/create',
      name:'Nouveau menu',
      component:CreateMenu
    },
    {
      path: '/plats',
      name:'Plats',
      component:Plats
    },
    {
      path: '/about',
      name: 'about',
      // route level code-splitting
      // this generates a separate chunk (About.[hash].js) for this route
      // which is lazy-loaded when the route is visited.
      component: () => import('../views/AboutView.vue'),
    },
  ],
})

export default router
