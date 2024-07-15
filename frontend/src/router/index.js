import Cookies from 'js-cookie'
import { createRouter, createWebHistory } from 'vue-router'

const router = createRouter({
  history: createWebHistory(import.meta.env.BASE_URL),
  routes: [
    {
      path: '/login',
      component: () => import('../layouts/AuthLayout.vue'),
      children: [
        {
          path: '/login',
          name: 'login',
          component: () => import('../views/LoginView.vue')
        }
      ]
    },
    {
      path: '/',
      component: () => import('../layouts/MainLayout.vue'),
      children: [
        {
          path: '',
          redirect: '/tasks'
        },
        {
          path: '/tasks',
          name: 'tasks',
          component: () => import('../views/TasksView.vue'),
          meta: { requiresAuth: true }
        },
        {
          path: '/historic',
          name: 'historic',
          component: () => import('../views/HistoricView.vue'),
          meta: { requiresAuth: true }
        },
        {
          path: '/users',
          name: 'users',
          component: () => import('../views/UsersView.vue'),
          meta: { requiresAuth: true, private: true }
        }
      ]
    }
  ]
})

router.beforeEach((to, from, next) => {
  const isAuthenticated = Cookies.get('isAuthenticated')
  const userRole = Cookies.get('userRole')

  if (to.meta.requiresAuth && !isAuthenticated) {
    next('/login')
  } else if (to.meta.private && userRole != 1) {
    next(from)
  } else {
    next()
  }
})

export default router
