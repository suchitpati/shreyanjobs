import { createRouter, createWebHistory } from "vue-router";

import Admin from "./components/Admin/AdminPage.vue";
import AdminLogin from "./components/Admin/AdminLogin.vue";
import AdminProfile from "./components/Admin/AdminProfile.vue";

import SeekerPage from "./components/Seeker/SeekerPage.vue";
import SeekerLogin from "./components/Seeker/SeekerLogin.vue";
import SeekerRegister from "./components/Seeker/SeekerRegister.vue";
import ForgotPassword from "./components/Seeker/ForgotPassword.vue";
import SeekerProfile from "./components/Seeker/SeekerProfile.vue";
import SeekerUpdatePassword from "./components/Seeker/UpdatePassword.vue";

import RecruiterLogin from "./components/Recruitment/RecruiterLogin.vue";
import RecruiterRegister from "./components/Recruitment/RecruiterRegister.vue";
import RecruiterEdit from "./components/Recruitment/RecruiterEdit.vue";

import RecruiterForgotPassword from "./components/Recruitment/ForgotPassword.vue";
import ManageConsultant from "./components/Recruitment/ManageConsultant.vue";
import AddConsultant from "./components/Recruitment/AddConsultant.vue";
import EditConsultant from "./components/Recruitment/EditConsultant.vue";
import RecruiterUpdatePassword from "./components/Recruitment/UpdatePassword.vue";

import EmployerLogin from "./components/Employer/EmployerLogin.vue";
import EmployerRegister from "./components/Employer/EmployerRegister.vue";
import EmployerForgotPassword from "./components/Employer/ForgotPassword.vue";
import EmployerProfile from "./components/Employer/EmployerProfile.vue";
import AdminTask from "./components/Employer/EmployerAdminTask.vue";
import EmployerDashboard from "./components/Employer/EmployerDashboard.vue";
import EmployerUpdatePassword from "./components/Employer/UpdatePassword.vue";
import EmployerJobView from "./components/Employer/EmployerJobView.vue";
import EmployerJobEdit from "./components/Employer/EmployerJobEdit.vue";
import ListMatchingResumes from "./components/Employer/ListMatchingResumes.vue";
import EmployerEasyjob from "./components/Employer/EmployerEasyJobPost.vue";
import HomePage from "../src/components/HomePage.vue";

const loggedIn = localStorage.getItem("accessToken");

const routes = [
    {
        path: "/",
        name: "HomePage",
        component: HomePage,
    },
    {
        path: "/add-job",
        name: "AddJob",
        component: Admin,
    },
    {
        path: "/job-search",
        name: "SeekerPage",
        component: SeekerPage,
    },
    {
        path: "/seeker-profile",
        name: "SeekerProfile",
        component: SeekerProfile,
    },
    {
        path: "/admin-login",
        name: "admin-login",
        component: AdminLogin,
    },
    {
        path: "/admin-profile/",
        name: "admin-profile",
        component: AdminProfile,
        beforeEnter: (to, from, next) => {
            if (!loggedIn) {
                return next("/admin-login");
            } else {
                next();
            }
        },
    },
    {
        path: "/seeker-login",
        name: "seeker-login",
        component: SeekerLogin,
    },
    {
        path: "/seeker-register",
        name: "seeker-register",
        component: SeekerRegister,
    },
    {
        path: "/seeker-forgot-password",
        name: "seeker-forgot-password",
        component: ForgotPassword,
    },
    {
        path: "/seeker-update-password",
        name: "seeker-update-password",
        component: SeekerUpdatePassword,
    },
    {
        path: "/employer-login",
        name: "employer-login",
        component: EmployerLogin,
    },
    {
        path: "/employer-register",
        name: "employer-register",
        component: EmployerRegister,
    },
    {
        path: "/employer-forgot-password",
        name: "employer-forgot-password",
        component: EmployerForgotPassword,
    },
    {
        path: "/employer-profile",
        name: "employer-profile",
        component: EmployerProfile,
    },
    {
        path: "/admin-task",
        name: "admin-task",
        component: AdminTask,
    },
    {
        path: "/employer-dashboard",
        name: "employer-dashboard",
        component: EmployerDashboard,
    },
    {
        path: "/list-matching-resumes/:id",
        name: "list-matching-resumes",
        component: ListMatchingResumes,
    },
    {
        path: "/employer-job-view",
        name: "employer-job-view",
        component: EmployerJobView,
    },
    {
        path: "/employer-job-edit/:id",
        name: "employer-job-edit",
        component: EmployerJobEdit,
    },
    {
        path: "/employer-update-password",
        name: "employer-update-password",
        component: EmployerUpdatePassword,
    },
    {
        path: "/employer-easy-post",
        name: "employer-easy-post",
        component: EmployerEasyjob,
    },
    {
        path: "/recruiter-login",
        name: "recruiter-login",
        component: RecruiterLogin,
    },

    {
        path: "/recruiter-register",
        name: "recruiter-register",
        component: RecruiterRegister,
    },
    {
        path: "/edit-recruiter",
        name: "edit-recruiter",
        component: RecruiterEdit,
    },
    {
        path: "/recruiter-forgot-password",
        name: "recruiter-forgot-password",
        component: RecruiterForgotPassword,
    },
    {
        path: "/recruiter-update-password",
        name: "recruiter-update-password",
        component: RecruiterUpdatePassword,
    },

    {
        path: "/manage-consultant",
        name: "manage-consultant",
        component: ManageConsultant,
    },
    {
        path: "/add-consultant",
        name: "add-consultant",
        component: AddConsultant,
    },
    {
        path: "/edit-consultant/:id",
        name: "edit-consultant",
        component: EditConsultant,
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
