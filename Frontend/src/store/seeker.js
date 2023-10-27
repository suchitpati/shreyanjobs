import {defineStore} from 'pinia';
import { ref } from "vue";
import axios from "axios";

import apiUrl from "../api";

export const useSeekerStore = defineStore('Seeker', () => {
    const count = ref(10)

   async function registerSeeker(data)
    {
        console.log('registerSeeker',data.value);
        // const response = await axios.post(`${apiUrl}/seeker-login`, {formData});

        // if(response.data.code == 100)
        // {
        //   validationError.value = response.data.message;
        // }
        // else{

        //   const token = response.data.token;
        //   localStorage.setItem("accessToken", token);
        //   showSuccessModal.value = true;

        //   setTimeout(() => {
        //       router.push("/admin");
        //     }, 1000);
        // }
    }

    return { count ,registerSeeker}
  })
