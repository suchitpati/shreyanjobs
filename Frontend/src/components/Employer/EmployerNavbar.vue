<template>
  <div class="flex justify-between gap-4 px-11 pt-5 pb-5 bg-[#ebf4ff] relative">
    <div>
      <img class="w-[150px]" src="../../assets/logo-no-background.png" alt="" />
    </div>

    <!-- Success Modal -->
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

    <!-- Dropdown Menu -->
    <div class="relative inline-block text-left">
      <div>
        <button
          @click="toggleDropdown"
          class="bg-blue-500 text-white font-bold py-2 px-4 rounded-full focus:outline-none focus:shadow-outline"
        >
          Menu
        </button>
      </div>
      <div
        class="origin-top-right absolute right-0 mt-2 w-56 rounded-md shadow-lg bg-white ring-1 ring-black ring-opacity-5"
        v-if="isDropdown"
      >
        <div
          class="py-1"
          role="menu"
          aria-orientation="vertical"
          aria-labelledby="options-menu"
        >
          <button
            @click="addJob"
            class="block px-4 py-2 text-sm text-gray-700 hover:bg-gray-100"
            role="menuitem"
          >
            Post Job
          </button>
          <button
            @click="searchResume"
            class="block px-4 py-2 text-sm text-gray-700 hover:bg-gray-100"
            role="menuitem"
          >
            Search Resume
          </button>
          <button
            @click="home"
            class="block px-4 py-2 text-sm text-gray-700 hover:bg-gray-100"
            role="menuitem"
          >
            Home
          </button>
          <button
            @click="employerProfile"
            class="block px-4 py-2 text-sm text-gray-700 hover:bg-gray-100"
            role="menuitem"
          >
            Profile
          </button>
          <button
            @click="employerLogout"
            class="block px-4 py-2 text-sm text-gray-700 hover:bg-gray-100"
            role="menuitem"
          >
            Logout
          </button>
        </div>
      </div>
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
    const isDropdown = ref(false);
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
    const searchResume = async () => {

      router.push("/employer-job-view");
    };
    const home = async () => {
      router.push("/");
    };

    const toggleDropdown = async () => {
      isDropdown.value = !isDropdown.value;
    };

    return {

      isDropdown,
      toggleDropdown,
      searchResume,
      employerLogout,
      employerProfile,
      addJob,
      isLoading,
      home,
    };
  },
};
</script>

