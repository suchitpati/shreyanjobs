<template>
    <footer class="footer">
      <p class="bg-green-700 text-white">© 2023 Shreyan Technology LLC, USA. All rights Reserved.</p>
    </footer>
</template>

<script>
  export default {
    data() {
      return {
        currentYear: new Date().getFullYear()
      };
    }
  };
</script>

<style>
  .footer {
    /* Your footer styles here */
    background-color: #ebf4ff;
    text-align: center;
    padding: 20px;
  }
</style>
