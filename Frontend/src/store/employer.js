import { defineStore } from "pinia";
import { ref } from "vue";
import axios from "axios";

import apiUrl from "../api";

export const useEmployerStore = defineStore("Employer", () => {
    const count = ref(10);
    const employerTocken = ref("");
    const employerLoginStatus = ref(false);
    const employerId = ref(null);


    async function loginEmployer(data) {
        const response = await axios.post(`${apiUrl}/employer-login`, { data });

        if (response.data.code == 100) {
            employerLoginStatus.value = false;
            return false;
        } else {
            employerTocken.value = response.data.token;
            employerLoginStatus.value = true;
            employerId.value = response.data.employer_id;
            localStorage.setItem('employer_id',response.data.employer_id)
            console.log(employerId.value,'employerIdemployerIdemployerId');
            return true;

        }
    }

    async function getEmployerDeatails() {
        console.log(employerId.value,'employerIdemployerIdemployerId');

        const response = await axios.post(`${apiUrl}/employer-profile`, { 'id': employerId.value });
        return response.data;
        // if (response.data.code == 100) {
        //     employerLoginStatus.value = false;
        //     return false;
        // } else {
        //     employerTocken.value = response.data.token;
        //     employerLoginStatus.value = true;
        //     employerId.value = response.data.id;
        //     return true;

        // }
    }

    return { count, loginEmployer, employerTocken, employerId,getEmployerDeatails,employerLoginStatus };
});
