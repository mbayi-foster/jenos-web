import { createRouter, createWebHistory } from 'vue-router'
import HomeView from '../views/HomeView.vue'
import Login from '@/views/auth/Login.vue'
import Users from '@/views/admin/Users.vue'
import Plat from '@/views/admin/CreatePlat.vue'
import Plats from '@/views/admin/Plats.vue'
import Menus from '@/views/admin/Menus.vue'
import CreateMenu from '@/views/admin/CreateMenu.vue'
import Zones from '@/views/admin/Zones.vue'
import CreateZones from '@/views/admin/CreateZones.vue'
import { useUserStore } from '@/stores/store.js'

const router = createRouter({
  history: createWebHistory(import.meta.env.BASE_URL),
  routes: [
    {
      path: '/',
      name: 'home',
      meta: { requiresAuth: true },
      component: HomeView,
    },
    {
      path: '/login',
      name: 'Login',
      component: Login
    },
    {
      path: '/users',
      name: 'Utilisateurs',
      meta: { requiresAuth: true },
      component: Users
    },
    {
      path: '/plats/create',
      name: 'Nouveau plat',
      meta: { requiresAuth: true },
      component: Plat
    },
    {
      path: '/menus',
      name: 'Menus',
      meta: { requiresAuth: true },
      component: Menus
    },
    {
      path: '/menus/create',
      name: 'Nouveau menu',
      meta: { requiresAuth: true },
      component: CreateMenu
    },
    {
      path: '/plats',
      name: 'Plats',
      meta: { requiresAuth: true },
      component: Plats
    },
    {
      path: '/zones',
      name: 'Zones',
      meta: { requiresAuth: true },
      component: Zones
    },
    {
      path: '/zones/create',
      name: 'Nouvel zone',
      meta: { requiresAuth: true },
      component: CreateZones
    },
    {
      path: '/users/create',
      name: 'Nouvel zone',
      meta: { requiresAuth: true },
      component: CreateZones
    },
  ],
})
router.beforeEach((to, from, next) => {
  const store = useUserStore();
  store.loadUser();

  if (to.path === '/login' && store.isAuthenticated) {
    next('/'); // Rediriger vers la page d'accueil
  }
  if (to.meta.requiresAuth && !store.isAuthenticated) {
    next('/login'); // Rediriger vers la page de connexion
  } else {
    next(); // Autoriser l'accès
  }
});
export default router
