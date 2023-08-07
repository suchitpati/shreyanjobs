<template>
    <div v-if="show" class="fixed top-0 right-0 m-4 bg-green-500 text-white px-4 py-2 rounded shadow-lg">
      {{ message }}
      <button class="ml-2" @click="closeModal">&times;</button>
    </div>
  </template>
  
  <script>
  import { ref } from 'vue';
  
  export default {
    props: {
      message: String,
    },
    setup() {
      const show = ref(true);
  
      const closeModal = () => {
        show.value = false;
      };
  
      return {
        show,
        closeModal,
      };
    },
  };
  </script>
  
  <style>
  /* Customize the success modal styles here */
  </style>
  