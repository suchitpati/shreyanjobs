<template>
  <div class="bg-gray-50 items-center justify-center bg-no-repeat w-full bg-img">
   <!-- <user-page/> -->
   <router-view />
  </div>
</template>

<script>
// import UserPage from './components/UserPage.vue';

export default {
  name: "App",
  components: {
    // UserPage,
  },
};
</script>

<style>
#app {
  font-family: Avenir, Helvetica, Arial, sans-serif;
  -webkit-font-smoothing: antialiased;
  -moz-osx-font-smoothing: grayscale;
  text-align: center;
  color: #2c3e50;
  /* margin-top: 60px; */
}
</style>
