import { defineStore } from "pinia";
import { ref } from "vue";
import axios from "axios";

import apiUrl from "../api";

export const useSeekerStore = defineStore("Seeker", () => {
    const count = ref(10);
    const seekerTocken = ref("");
    const seekerLoginStatus = ref(false);
    async function loginSeeker(data) {
        console.log("loginSeeker", data);
        const response = await axios.post(`${apiUrl}/seeker-login`, { data });

        if (response.data.code == 100) {
            seekerLoginStatus.value = false;
            return false;
        } else {
            seekerTocken.value = response.data.token;
            seekerLoginStatus.value = true;
            return true;

        }
    }

    return { count, loginSeeker, seekerTocken, seekerLoginStatus };
});
