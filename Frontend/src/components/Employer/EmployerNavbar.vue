<template>
    <div class=" bg-[#ebf4ff] relative">
        <div class="max-w-[1080px] mx-auto flex justify-between gap-4  pt-5 pb-5">

            <div>
              <img class="w-[150px]" src="../../assets/logo-no-background.png" alt="" />
            </div>

            <!-- Success Modal -->
            <!-- ... Your existing success modal code ... -->

            <!-- Loading spinner -->
            <div class="absolute inset-0 flex items-center justify-center" v-if="isLoading">
              <div class="animate-spin rounded-full h-16 w-16 border-t-4 border-blue-500"></div>
            </div>

            <!-- Buttons Section -->
            <div class="flex items-center gap-4">
              <button @click="addJob" class="bg-blue-500 text-[15px] text-white font-bold md:py-[5px] py-[7px] px-[18px] md:px-[15px] rounded-[26px] ">
                Post Job
              </button>
              <button @click="viewJob" class="bg-blue-500 text-[15px] text-white font-bold md:py-[5px] py-[7px] px-[18px] md:px-[15px] rounded-[26px] ">
                  View/ Edit Jobs
              </button>
              <button @click="searchResume" class="bg-blue-500 text-[15px] text-white font-bold md:py-[5px] py-[7px] px-[18px] md:px-[15px] rounded-[26px] ">
                Search Resume
              </button>
              <button @click="home" class="bg-blue-500 text-[15px] text-white font-bold md:py-[5px] py-[7px] px-[18px] md:px-[15px] rounded-[26px] ">
                  Job Search
              </button>
              <button @click="employerProfile" class="bg-blue-500 text-[15px] text-white font-bold md:py-[5px] py-[7px] px-[18px] md:px-[15px] rounded-[26px] ">
                Profile
              </button>
              <button @click="employerLogout" class="bg-blue-500 text-[15px] text-white font-bold md:py-[5px] py-[7px] px-[18px] md:px-[15px] rounded-[26px] ">
                Logout
              </button>
            </div>
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

      router.push("/employer-dashboard");
    };
    const home = async () => {
      router.push("/");
    };

    const  viewJob = async() =>
    {
        router.push("/employer-job-view");

    }
     const toggleDropdown = async () => {
      isDropdown.value = !isDropdown.value;
    };

    return {
        viewJob,
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

