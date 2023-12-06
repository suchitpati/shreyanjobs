<template>
    <footer class="footer">
      <p>&copy; {{ currentYear }} © Shreyan Technology LLC, USA. All rights Reserved.</p>
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
    background-color: #f0f0f0;
    text-align: center;
    padding: 20px;
  }
</style>
