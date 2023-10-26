import { createRouter, createWebHistory } from 'vue-router';

import Admin from './components/AdminPage.vue';
import User from './components/UserPage.vue';
import AdminLogin from './components/AdminLogin.vue';
import AdminProfile from './components/AdminProfile.vue';
import SeekerLogin from './components/SeekerLogin.vue'
import SeekerRegister from './components/SeekerRegister.vue'
import EmployerLogin from './components/EmployerLogin.vue'
import EmployerRegister from './components/EmployerRegister.vue'




const loggedIn = localStorage.getItem('accessToken');


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
    beforeEnter: (to, from, next) => {
        if (!loggedIn) {
            return next('/admin-login');
        } else {
            next();
        }
      }
  },
  {
    path: '/seeker-login',
    name: 'seeker-login',
    component: SeekerLogin,
  },
  {
    path: '/seeker-register',
    name: 'seeker-register',
    component: SeekerRegister,
  },
  {
    path: '/employer-login',
    name: 'employer-login',
    component: EmployerLogin,
  },
  {
    path: '/employer-register',
    name: 'employer-register',
    component: EmployerRegister,
  },

];

const router = createRouter({
  history: createWebHistory(),
  routes,
});

// router.beforeEach((to, from, next) => {
//   const publicPages = ['/', '/admin-login'];
//   const authRequired = !publicPages.includes(to.path);
//   console.log(loggedIn);
//   if (authRequired && !loggedIn) {
//     return next('/admin-login');
//   }
//   next();
// });

export default router;
