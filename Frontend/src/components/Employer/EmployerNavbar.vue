<template>
  <div class="flex justify-between gap-4 px-11 pt-5 pb-5 bg-[#ebf4ff]">
    <div>
      <img class="w-[150px]" src="../../assets/logo-no-background.png" alt="" />
    </div>

    <SuccessModal v-if="showLogoutModal" :message="successMessage" />
    <div
      v-if="showSuccessModal"
      class="fixed inset-0 flex items-center justify-center bg-gray-900 bg-opacity-75"
    >
      <div class="bg-white p-8 rounded-lg shadow-lg">
        <h2 class="text-2xl font-bold mb-4">Job Added Successfully!</h2>
        <button
          @click="closeSuccessModal"
          class="bg-blue-500 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded"
        >
          Close
        </button>
      </div>
    </div>
    <div class="flex gap-[5px]">
      <button
        class="bg-blue-500 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded-full focus:outline-none focus:shadow-outline"
        @click="addJob"
      >
        Post Job
      </button>
      <button
        class="bg-blue-500 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded-full focus:outline-none focus:shadow-outline"
        @click="home"
      >
        Home
      </button>
      <button
        class="bg-blue-500 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded-full focus:outline-none focus:shadow-outline"
        @click="employerLogout"
      >
        Logout
      </button>
      <button
        class="bg-blue-500 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded-full focus:outline-none focus:shadow-outline"
        @click="employerProfile()"
      >
        Profile
      </button>
    </div>

    <div
      class="absolute inset-0 flex items-center justify-center"
      v-if="isLoading"
    >
      <div
        class="animate-spin rounded-full h-16 w-16 border-t-4 border-blue-500"
      ></div>
    </div>
  </div>
</template>

<script>
import axios from "axios";
import apiUrl from "../../api";
import { ref } from "vue";
import { useRouter } from "vue-router";

export default {
  setup() {
    const router = useRouter();
    const isLoading = ref(false);
    const showLogoutModal = ref(false);
    const successMessage = ref("");
    const employerLogout = async () => {
      try {
        const authToken = localStorage.getItem("employer_tocken");

        if (!authToken) {
          console.log("Authentication token is missing.");
          return;
        }

        const config = {
          headers: {
            Authorization: `Bearer ${authToken}`,
          },
        };
        isLoading.value = true;
        const response = await axios.post(
          `${apiUrl}/employer-logout`,
          null,
          config
        );
        localStorage.removeItem("employer_tocken");
        localStorage.removeItem("employer_id");
        isLoading.value = false;
        if (response.data.message) {
          successMessage.value = response.data.message;
          showLogoutModal.value = true;

          setTimeout(() => {
            router.push("/employer-login");
          }, 1000);
        }

        console.log(response);
      } catch (error) {
        console.log(error);
      }
    };
    const employerProfile = async () => {
      router.push("/employer-profile");
    };

    const addJob = async () => {
      router.push("/add-job");
    };
    const home = async () => {
      router.push("/");
    };

    return {
      employerLogout,
      employerProfile,
      addJob,
      isLoading,
      home,
    };
  },
};
</script>

