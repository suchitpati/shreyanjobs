<template>
    <div class="bg-[#ebf4ff] relative">
      <div class="max-w-[1080px] mx-auto flex flex-col md:flex-row items-center justify-between gap-4 pt-5 pb-5">

        <div class="mb-4 md:mb-0">
          <img class="w-[150px]" src="../../assets/logo-no-background.png" alt="" />
        </div>

        <!-- Success Modal -->
        <!-- ... Your existing success modal code ... -->

        <!-- Loading spinner -->
        <div class="absolute inset-0 flex items-center justify-center" v-if="isLoading">
          <div class="animate-spin rounded-full h-16 w-16 border-t-4 border-blue-500"></div>
        </div>

        <!-- Buttons Section -->
        <div class="flex gap-[5px] items-center">
            <button
              class="bg-blue-500 text-[15px] text-white font-bold md:py-[5px] py-[7px] px-[18px] md:px-[15px] rounded-[26px] mb-2 md:mb-0"
              @click="home"
            >
              Job Search
            </button>

            <button
              class="bg-blue-500 text-[15px] text-white font-bold md:py-[5px] py-[7px] px-[18px] md:px-[15px] rounded-[26px] mb-2 md:mb-0"
              @click="home"

            >
              Manage consultant
            </button>
            <button
              class="bg-blue-500 text-[15px] text-white font-bold md:py-[5px] py-[7px] px-[18px] md:px-[15px] rounded-[26px] mb-2 md:mb-0"
              @click="editConsultant"
            >
              View /Edit Profile
            </button>
            <button
              class="bg-blue-500 text-[15px] text-white font-bold md:py-[5px] py-[7px] px-[18px] md:px-[15px] rounded-[26px] mb-2 md:mb-0 text-center"
              @click="recruiterLogout"
            >
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

    const recruiterLogout = async () => {
      try {
        const authToken = localStorage.getItem("recruiter_tocken");

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
          `${apiUrl}/recruiter-logout`,
          null,
          config
        );
        localStorage.removeItem("recruiter_tocken");
        localStorage.removeItem("recruiter_id");

        isLoading.value = false;
        if (response.data.message) {
          successMessage.value = response.data.message;
          showLogoutModal.value = true;

          setTimeout(() => {
            router.push("/recruiter-login");
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
    const admintask = async () => {
      router.push("/admin-task");
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
    const editConsultant = async() => {
        router.push("/edit-recruiter");
    }
    const  viewJob = async() =>
    {
        router.push("/employer-job-view");
    }
     const toggleDropdown = async () => {
      isDropdown.value = !isDropdown.value;
    };

    return {
        editConsultant,
        admintask,
        viewJob,
      isDropdown,
      toggleDropdown,
      searchResume,
      recruiterLogout,
      employerProfile,
      addJob,
      isLoading,
      home,
    };
  },
};
</script>

