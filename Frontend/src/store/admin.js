import {defineStore} from 'pinia';
import { ref } from "vue";


export const useAdminStore = defineStore('admin', () => {
    const count = ref(10)


    return { count }
  })
