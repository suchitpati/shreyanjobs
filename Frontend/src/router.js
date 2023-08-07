import { createRouter, createWebHistory } from 'vue-router';

import Admin from './components/AdminPage.vue';
import User from './components/UserPage.vue';
import AdminLogin from './components/AdminLogin.vue';
import AdminProfile from './components/AdminProfile.vue';



const routes = [
  {
    path: '/admin',
    name: 'Admin',
    component: Admin,
  },
  {
    path: '/',
    name: 'User',
    component: User,
  },
  {
    path: '/admin-login',
    name: 'admin-login',
    component: AdminLogin,
  },
  {
    path: '/admin-profile/',
    name: 'admin-profile',
    component: AdminProfile,
  },
 
];

const router = createRouter({
  history: createWebHistory(),
  routes,
});

router.beforeEach((to, from, next) => {
  const publicPages = ['/', '/admin-login'];
  const authRequired = !publicPages.includes(to.path);
  const loggedIn = localStorage.getItem('accessToken');
  console.log(loggedIn);
  if (authRequired && !loggedIn) {
    return next('/admin-login');
  }
  next();
});

export default router;
