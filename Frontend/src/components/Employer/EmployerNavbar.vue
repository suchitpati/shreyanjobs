<template>
  <div class="bg-[#ebf4ff] relative">
    <div
      class="max-w-[1080px] mx-auto flex flex-col md:flex-row items-center justify-between gap-4 pt-5 pb-5"
    >
      <div class="mb-4 md:mb-0">
        <img
          class="w-[150px]"
          src="../../assets/logo-no-background.png"
          alt=""
        />
      </div>

      <!-- Success Modal -->
      <!-- ... Your existing success modal code ... -->

      <!-- Loading spinner -->
      <div
        class="absolute inset-0 flex items-center justify-center"
        v-if="isLoading"
      >
        <div
          class="animate-spin rounded-full h-16 w-16 border-t-4 border-blue-500"
        ></div>
      </div>

      <!-- Buttons Section -->
      <div class="flex flex-col md:flex-row items-center gap-4">
        <button
          @click="addJob"
          class="bg-blue-500 text-[15px] text-white font-bold md:py-[5px] py-[7px] px-[18px] md:px-[15px] rounded-[26px] mb-2 md:mb-0"
        >
          Post Job
        </button>
        <button
          @click="easyJobPost"
          class="bg-blue-500 text-[15px] text-white font-bold md:py-[5px] py-[7px] px-[18px] md:px-[15px] rounded-[26px] mb-2 md:mb-0"
        >
          Easy Post Job
        </button>
        <button
          @click="viewJob"
          class="bg-blue-500 text-[15px] text-white font-bold md:py-[5px] py-[7px] px-[18px] md:px-[15px] rounded-[26px] mb-2 md:mb-0"
        >
          View/ Edit Jobs
        </button>
        <button
          @click="searchResume"
          class="bg-blue-500 text-[15px] text-white font-bold md:py-[5px] py-[7px] px-[18px] md:px-[15px] rounded-[26px] mb-2 md:mb-0"
        >
          Search Resume
        </button>
        <button
          @click="home"
          class="bg-blue-500 text-[15px] text-white font-bold md:py-[5px] py-[7px] px-[18px] md:px-[15px] rounded-[26px] mb-2 md:mb-0"
        >
          Job Search
        </button>

        <button
          v-if="employer_role == 1"
          @click="admintask"
          class="bg-blue-500 text-[15px] text-white font-bold md:py-[5px] py-[7px] px-[18px] md:px-[15px] rounded-[26px] mb-2 md:mb-0"
        >
          Admin task
        </button>

        <button
          @click="employerProfile"
          class="bg-blue-500 text-[15px] text-white font-bold md:py-[5px] py-[7px] px-[18px] md:px-[15px] rounded-[26px] mb-2 md:mb-0"
        >
          Profile
        </button>
        <button
          @click="employerLogout"
          class="bg-blue-500 text-[15px] text-white font-bold md:py-[5px] py-[7px] px-[18px] md:px-[15px] rounded-[26px] mb-2 md:mb-0 m-auto"
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

    const employer_role = localStorage.getItem("employer_role");
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
        localStorage.removeItem("employer_role");

        isLoading.value = false;
        if (response.data.message) {
          successMessage.value = response.data.message;
          showLogoutModal.value = true;

          setTimeout(() => {
            router.push("/");
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
    const easyJobPost = async () => {
      router.push("/employer-easy-post");
    };

    const searchResume = async () => {
      router.push("/employer-dashboard");
    };
    const home = async () => {
      router.push("/job-search");
    };

    const viewJob = async () => {
      router.push("/employer-job-view");
    };
    const toggleDropdown = async () => {
      isDropdown.value = !isDropdown.value;
    };

    return {
      easyJobPost,
      admintask,
      employer_role,
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

