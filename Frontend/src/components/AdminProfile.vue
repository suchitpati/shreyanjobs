<template>
  <div class="flex justify-center items-center h-screen overflow-y-auto p-4">
    <div
      v-if="showSuccessModal"
      class="fixed inset-0 flex items-center justify-center bg-gray-900 bg-opacity-75"
    >
      <div class="bg-white p-8 rounded-lg shadow-lg">
        <h2 class="text-2xl font-bold mb-4">Password updated Successfully!</h2>
        <button
          @click="closeSuccessModal"
          class="bg-blue-500 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded"
        >
          Close
        </button>
      </div>
    </div>
    <div
      class="max-w-[560px] w-full bg-white rounded-lg py-4 px-8 ml-[20px] shadow-[rgba(100,_100,_111,_0.2)_0px_5px_30px_0px]"
    >
      <h1 class="text-[28px] font-bold mt-[20px] mb-[50px] text-[#1890da]">
        Admin Profile
      </h1>
      <ul></ul>
      <div class="mt-4" v-for="admin in admins" :key="admin.id">
        <div class="w-full">
          <label
            class="block text-gray-700 font-bold mb-1 text-start text-[14px]"
            for="field2"
          >
            Update email
          </label>
          <input
            class="border border-gray-400 rounded-lg py-2 px-4 mb-4 outline-[#264dd9] focus:shadow-outline w-full"
            type="text"
            id="field1"
            placeholder="Email"
            v-model="admin.email"
          />
        </div>
        <div class="w-full mt-[10px]">
          <label
            class="block text-gray-700 font-bold mb-1 text-start text-[14px]"
            for="field2"
          >
            Update Password
          </label>
          <input
            :type="showPassword ? 'text' : 'password'"
            class="border border-gray-400 rounded-lg py-2 px-4 mb-4 outline-[#264dd9] focus:shadow-outline w-full"
            id="field1"
            placeholder="Password"
            v-model="admin.password"
          />
        </div>
        <div class="mt-2">
            <input type="checkbox" v-model="showPassword" />
            Show Password
        </div>
        <button
          class="bg-[#1890da] hover:bg-blue-500 text-white font-bold py-2 px-8 mb-[20px] rounded focus:outline-none focus:shadow-outline mt-[20px]"
          @click="editData(admin)"
        >
          Update
        </button>
      </div>
    </div>
  </div>
</template>

<script>
import { ref, onMounted } from "vue";
import axios from "axios";
import apiUrl from "../api";

export default {
  setup() {
    const email = ref("");
    const password = ref("");
    const admins = ref([]);
    const showSuccessModal = ref(false);
    const showPassword = ref(false);

    const authToken = localStorage.getItem("accessToken");
    const config = authToken
      ? {
          headers: {
            Authorization: `Bearer ${authToken}`,
          },
        }
      : null;

    const fetchAdminData = async () => {
      try {
        const authToken = localStorage.getItem("accessToken");

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
          `${apiUrl}/admin/getAdmin/`,
          null,
          config
        );
        admins.value = response.data;
      } catch (error) {
        console.log(error);
      }
    };

    const editData = async (admin) => {
      try {
        const updatedAdmin = {
          email: admin.email,
          password: admin.password,
        };
        await axios.post(
          `${apiUrl}/admin/passwordChange/${admin.id}`,
          updatedAdmin,
          config
        );
        showSuccessModal.value = true;
      } catch (error) {
        console.log(error.response.data);
      }
    };

    const closeSuccessModal = () => {
      showSuccessModal.value = false;
    };

    onMounted(() => {
      fetchAdminData();
    });

    return {
      admins,
      email,
      password,
      authToken,
      config,
      editData,
      showSuccessModal,
      closeSuccessModal,
      showPassword,
    };
  },
};
</script>

<style></style>
