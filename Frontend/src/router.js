import { createRouter, createWebHistory } from 'vue-router';

import Admin from './components/Admin/AdminPage.vue';
import AdminLogin from './components/Admin/AdminLogin.vue';
import AdminProfile from './components/Admin/AdminProfile.vue';

import SeekerPage from './components/Seeker/SeekerPage.vue';
import SeekerLogin from './components/Seeker/SeekerLogin.vue'
import SeekerRegister from './components/Seeker/SeekerRegister.vue'
import ForgotPassword from './components/Seeker/ForgotPassword.vue'
import SeekerProfile from './components/Seeker/SeekerProfile.vue'
import SeekerUpdatePassword from './components/Seeker/UpdatePassword.vue';
import RecruiterLogin from './components/Recruitment/RecruiterLogin.vue';
import RecruiterRegister from './components/Recruitment/RecruiterRegister.vue';

import EmployerLogin from './components/Employer/EmployerLogin.vue'
import EmployerRegister from './components/Employer/EmployerRegister.vue'
import EmployerForgotPassword from './components/Employer/ForgotPassword.vue'
import EmployerProfile from './components/Employer/EmployerProfile.vue'
import AdminTask from './components/Employer/EmployerAdminTask.vue'
import EmployerDashboard from './components/Employer/EmployerDashboard.vue'
import EmployerUpdatePassword from './components/Employer/UpdatePassword.vue';
import EmployerJobView from './components/Employer/EmployerJobView.vue';
import EmployerJobEdit from './components/Employer/EmployerJobEdit.vue';


const loggedIn = localStorage.getItem('accessToken');

const routes = [
  {
    path: '/add-job',
    name: 'AddJob',
    component: Admin,
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
    path: '/seeker-update-password',
    name: 'seeker-update-password',
    component: SeekerUpdatePassword,
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
  },
  {
    path: '/admin-task',
    name: 'admin-task',
    component: AdminTask,
  },
  {
    path: '/employer-dashboard',
    name: 'employer-dashboard',
    component: EmployerDashboard,
  },
  {
    path: '/employer-job-view',
    name: 'employer-job-view',
    component:   EmployerJobView,
  },
  {
    path: '/employer-job-edit/:id',
    name: 'employer-job-edit',
    component:   EmployerJobEdit,
  },
  {
    path: '/employer-update-password',
    name: 'employer-update-password',
    component: EmployerUpdatePassword,
  },
  {
    path: '/recruiter-login',
    name: 'recruiter-login',
    component: RecruiterLogin,
  },
  {
    path: '/recruiter-register',
    name: 'recruiter-register',
    component: RecruiterRegister,
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
