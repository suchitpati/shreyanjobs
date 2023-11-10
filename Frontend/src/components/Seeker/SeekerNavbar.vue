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
        @click="home"
      >
      Job Search
      </button>
      <button
        class="bg-blue-500 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded-full focus:outline-none focus:shadow-outline"
        @click="seekerLogout"
      >
        Logout
      </button>
      <!-- <button
        class="bg-blue-500 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded-full focus:outline-none focus:shadow-outline"
        @click="seekerProfile()"
      >
        Profile
      </button> -->
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

    const showLogoutModal = ref(false);
    const successMessage = ref("");
    const seekerLogout = async () => {
      try {
        const authToken = localStorage.getItem("seeker_tocken");

        if (!authToken) {
          console.log("Authentication token is missing.");
          return;
        }

        const config = {
          headers: {
            Authorization: `Bearer ${authToken}`,
          },
        };
        const response = await axios.post(
          `${apiUrl}/seeker-logout`,
          null,
          config
        );
        localStorage.removeItem("seeker_tocken");
        localStorage.removeItem("seeker_id");

        if (response.data.message) {
          successMessage.value = response.data.message;
          showLogoutModal.value = true;

          setTimeout(() => {
            router.push("/seeker-login");
          }, 1000);
        }

        console.log(response);
      } catch (error) {
        console.log(error);
      }
    };
    const seekerProfile = async () => {
      router.push("/seeker-profile");
    };

    const home = async () => {
      router.push("/");
    };
    return {
      seekerLogout,
      seekerProfile,
      home,
    };
  },
};
</script>

