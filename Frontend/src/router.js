import { createRouter, createWebHistory } from 'vue-router';

import Admin from './components/Admin/AdminPage.vue';
import AdminLogin from './components/Admin/AdminLogin.vue';
import AdminProfile from './components/Admin/AdminProfile.vue';

import SeekerPage from './components/Seeker/SeekerPage.vue';
import SeekerLogin from './components/Seeker/SeekerLogin.vue'
import SeekerRegister from './components/Seeker/SeekerRegister.vue'
import ForgotPassword from './components/Seeker/ForgotPassword.vue'
import SeekerProfile from './components/Seeker/SeekerProfile.vue'


import EmployerLogin from './components/Employer/EmployerLogin.vue'
import EmployerRegister from './components/Employer/EmployerRegister.vue'
import EmployerForgotPassword from './components/Employer/ForgotPassword.vue'
import EmployerProfile from './components/Employer/EmployerProfile.vue'
import EmployerDashboard from './components/Employer/EmployerDashboard.vue'







const loggedIn = localStorage.getItem('accessToken');

const isEmployerLogged = localStorage.getItem('employer_tocken');
const routes = [
  {
    path: '/add-job',
    name: 'AddJob',
    component: Admin,
    beforeEnter: (to, from, next) => {
        if (!isEmployerLogged) {
            return next('/employer-login');
        } else {
            next();
        }
      }
  },
  {
    path: '/',
    name: 'SeekerPage',
    component: SeekerPage,
  },
  {
    path: '/seeker-profile',
    name: 'SeekerProfile',
    component: SeekerProfile,
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
    path: '/seeker-forgot-password',
    name: 'seeker-forgot-password',
    component: ForgotPassword,
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
  {
    path: '/employer-forgot-password',
    name: 'employer-forgot-password',
    component: EmployerForgotPassword,
  },
  {
    path: '/employer-profile',
    name: 'employer-profile',
    component: EmployerProfile,
    beforeEnter: (to, from, next) => {
        if (!isEmployerLogged) {
            return next('/employer-login');
        } else {
            next();
        }
      }
  },
  {
    path: '/employer-dashboard',
    name: 'employer-dashboard',
    component: EmployerDashboard,
    beforeEnter: (to, from, next) => {
        if (!isEmployerLogged) {
            return next('/employer-login');
        } else {
            next();
        }
      }

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
