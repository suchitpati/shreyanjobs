<template>
    <div class="bg-[#eaf4ff]">
        <RecruiterNavbar />

      <div
        class="p-4 h-[calc(100vh-62px)] flex justify-center flex-col gap-6 items-center"
      >
        <div
          class="rounded-lg flex items-center justify-center max-w-[1120px] sm:px-[20px] bg-img w-full"
        >
          <div
            v-if="showSuccessModal"
            class="fixed inset-0 flex items-center justify-center bg-gray-900 bg-opacity-75"
          >
            <div class="bg-white p-8 rounded-lg shadow-lg">
              <h2 class="text-2xl font-bold mb-4">
                Password is updated successfully              </h2>
              <button
                @click="closeSuccessModal"
                class="bg-blue-500 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded"
              >
                Ok
              </button>
            </div>
          </div>
          <!-- <div class="w-[50%] md:block hidden">
                <img src="../assets/illustration.svg" alt="" class="m-auto mr-0" />
              </div> -->


          <div  class="w-[50%]">
            <div class="bg-[#eaf4ff]">
              <div
                class="bg-[#ebf4ff] py-7 h-[calc(100vh_-_62px)]"
              >
                <div class="w-full mx-auto px-[20px]">
                  <div
                    class="bg-[#fff] rounded-lg py-4 sm:px-8 px-4 w-full shadow-[rgba(100,_100,_111,_0.2)_0px_0px_10px_0px] hover:shadow-[rgba(100,_100,_111,_0.2)_0px_0px_20px_0px] transition-[.5s]"
                  >
                    <h1
                      class="text-[#1890da] sm:text-[26px] text-[22px] font-semibold mt-[30px] sm:mb-[40px] mb-[25px]"
                    >
                      Update Your password
                    </h1>
                    <div class="mt-4">
                      <div
                        class="w-full flex sm:flex-row flex-col justify-between sm:gap-6 gap-2"
                      >
                        <div class="sm:w-[100%] mb-4">
                          <label
                            class="block text-gray-700 font-bold mb-1 text-start text-[14px]"
                            for="field1"
                          >
                            Password
                          </label>
                          <input
                            class="border border-gray-400 rounded-lg py-2 px-4 outline-[#264dd9] focus:shadow-outline w-full"
                            type="password"
                            id="field1"
                            v-model="password"
                            placeholder="Enter password"
                          />
                          <div
                            class="text-red-600 block text-[14px] text-left"
                            v-if="passwordError != ''"
                          >
                            {{ passwordError }}
                          </div>
                        </div>
                      </div>
                      <div
                        class="w-full flex sm:flex-row flex-col justify-between sm:gap-6 gap-2"
                      ></div>
                    </div>

                    <div class="mt-1">
                      <div
                        class="w-full flex sm:flex-row flex-col justify-between sm:gap-6 gap-2"
                      >
                        <div class="sm:w-[100%] mb-4">
                          <label
                            class="block text-gray-700 font-bold mb-1 text-start text-[14px]"
                            for="field1"
                          >
                            Confirm Password
                          </label>

                          <input
                            class="border border-gray-400 rounded-lg py-2 px-4 outline-[#264dd9] focus:shadow-outline w-full"
                            type="password"
                            id="field1"
                            v-model="confirmPassword"
                            placeholder="Enter Confirm Password"
                          />
                          <div
                            class="text-red-600 block text-[14px] text-left"
                            v-if="confirmPasswordError != ''"
                          >
                            {{ confirmPasswordError }}
                          </div>
                        </div>
                      </div>
                      <div
                        class="w-full flex sm:flex-row flex-col justify-between sm:gap-6 gap-2"
                      ></div>
                    </div>
                    <button
                      class="bg-blue-500 hover:bg-blue-700 text-white font-bold py-2 px-8 mb-4 mt-4 rounded-full focus:outline-none focus:shadow-outline"
                      @click="updatePassword"
                    >
                      Update
                    </button>
                  </div>
                </div>
              </div>
            </div>
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
  import { reactive, ref } from "vue";
  import { useRouter } from "vue-router";
  import axios from "axios";
  import RecruiterNavbar from "../Recruitment/RecruiterNavbar.vue";

  // import "vue-loading-overlay/dist/css/index.css";

  import apiUrl from "../../api";

  export default {
    components: {
        RecruiterNavbar,
  },
    setup() {
      const data = reactive({});
      const showSuccessModal = ref(false);

      const password = ref("");
      const passwordError = ref("");

      const confirmPassword = ref("");
      const confirmPasswordError = ref("");

      const router = useRouter();
      const route = useRouter();
      const id = ref('');


      const isLoading = ref(false);
      const closeSuccessModal = () => {
        showSuccessModal.value = false;
      };


      const updatePassword = async () => {
        if (password.value == null || password.value == "") {
          passwordError.value = "The password field required";
          return false;
        } else {
          passwordError.value = "";
        }

        if (confirmPassword.value == null || confirmPassword.value == "") {
          confirmPasswordError.value = "The password field required";
          return false;
        } else {
          confirmPasswordError.value = "";
        }
        const regex = /^(?=.*[A-Z])(?=.*\d).{8,}$/;

        if (regex.test(password.value) == false) {
          confirmPasswordError.value =
            "Enter At least 8 characters long with one capital and one number ";
          return false;
        }
        else
        {
          confirmPasswordError.value ="";
        }
        if (password.value != confirmPassword.value ) {
          confirmPasswordError.value = "Both Password not match";
          return false;
        } else {
          confirmPasswordError.value = "";
        }


        id.value = localStorage.getItem('recruiter_id');
        const formData = new FormData();
        formData.append("password", password.value);
        formData.append("recruiter_id", id.value);


        try {
          await axios
            .post(`${apiUrl}/recruiter-update-password`, formData)
            .then((response) => {
              console.log(response);
              isLoading.value = false;
              if (response.data.error == 100) {
                alert("Something wrong");
              } else {
                showSuccessModal.value = true;
                setTimeout(() => {
                  router.push("/edit-recruiter");
                }, 2000);
              }
            })
            .catch((error) => {
              console.error(error);
            });
        } catch (error) {
          console.error(error);
        }
      };

      return {
        updatePassword,
        confirmPassword,
        confirmPasswordError,
        isLoading,
      //   state,
      //   countries_state,
        data,
        password,
        showSuccessModal,
        closeSuccessModal,
        router,
        route,
        passwordError,
      };
    },
  };
  </script>
