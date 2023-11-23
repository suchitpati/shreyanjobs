<template>
  <div class="bg-[#eaf4ff]">
    <div class="w-full flex justify-end pt-4 pr-4 pl-4">
      <img class="w-[150px]" src="../../assets/logo-no-background.png" alt="" />
      <a
        href="/"
        class="border-[#1890da] hover:bg-[#f7f7f9] border-[1px] w-max sm:ml-auto text-[#1890da] font-bold md:py-[10px] py-[7px] px-[18px] md:px-[26px] rounded-[26px] focus:outline-none"
        >Home
      </a>
    </div>
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
                Password is changed Successfully
            </h2>
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
        <div
          class="md:w-[50%] w-full md:max-w-[100%] max-w-[500px]"
          v-if="steps == 1"
        >
          <div
            class="w-full bg-white rounded-lg py-4 sm:px-8 px-4 lg:ml-[20px] shadow-[rgba(100,_100,_111,_0.2)_0px_5px_30px_0px]"
          >
            <h1
              class="sm:text-[28px] text-[22px] font-bold mt-[20px] sm:mb-[50px] mb-[30px] text-[#1890da]"
            >
              Forgot Password
            </h1>
            <div
              v-if="validationError"
              class="text-red-600 block text-[20px] text-center"
            >
              {{ validationError }}
            </div>
            <div class="mt-4">
              <div class="w-full">
                <label
                  class="block text-gray-700 font-bold mb-1 text-start text-[14px]"
                  for="field2"
                >
                  Enter Email
                </label>
                <input
                  class="border border-gray-400 rounded-lg py-2 px-4 mb-1 outline-[#264dd9] focus:shadow-outline w-full"
                  type="text"
                  id="field1"
                  placeholder="Enter Email"
                  v-model="email"
                />
                <div
                  v-if="emailError"
                  class="text-red-600 block text-[14px] text-left"
                >
                  {{ emailError }}
                </div>
              </div>

              <button
                class="bg-[#1890da] hover:bg-blue-500 text-white font-bold py-2 px-8 mb-[20px] rounded focus:outline-none focus:shadow-outline mt-[40px]"
                @click.prevent="forgotPassword"
              >
                Submit
              </button>
            </div>
          </div>
        </div>
        <div v-else-if="steps == 2">
          <div class="fixed inset-0 flex items-center justify-center">
            <div class="bg-white p-8 rounded-lg shadow-lg w-[28%] h-[60%]">
              <h2 class="text-2xl font-bold mb-[50px]">Enter OTP</h2>
              <div class="text-[14px]">OTP has been sent to your email ID</div>
              <div class="text-[11px]">Please check your spam/ junk folder</div>
              <div v-if="otpError" class="text-red-500">OTP invalid</div>

              <div class="flex space-x-2">
                <input
                  type="text"
                  class="border border-gray-400 rounded-lg py-2 px-4 mb-1 outline-[#264dd9] focus:shadow-outline w-full"
                  placeholder="Enter OTP"
                  v-model="enter_otp"
                />
              </div>
              <button
                @click="validateOtp"
                class="bg-blue-500 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded mt-8"
              >
                Submit
              </button>
            </div>
          </div>
        </div>
        <div v-else class="w-[50%]">
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
// import "vue-loading-overlay/dist/css/index.css";

import apiUrl from "../../api";

export default {
  setup() {
    const data = reactive({});


    const email = ref("");
    const emailError = ref("");
    const passwordError = ref("");

    const password = ref("");
    const confirmPassword = ref("");
    const confirmPasswordError = ref("");
    const employer_email = ref("");

    const validationError = ref("");
    const showSuccessModal = ref(false);
    const otpError = ref(false);

    const router = useRouter();
    const route = useRouter();


    const steps = ref(1);
    const enter_otp = ref("");

    const final_otp = ref("");
    const seeker_id = ref("");
    const formContainer = ref(null);
    const isLoading = ref(false);
    const seeker_email = ref("");
    const closeSuccessModal = () => {
      showSuccessModal.value = false;
    };

    const forgotPassword = async () => {
      try {
        if (email.value == null || email.value == "") {
          emailError.value = "Please Enter Email";
          return false;
        } else {
          emailError.value = "";
        }

        isLoading.value = true;

        await axios
          .post(`${apiUrl}/employer-send-forgot-email-otp`, {
            email: email.value,
          })
          .then((response) => {
            console.log(response);
            isLoading.value = false;
            if (response.data.error == 100) {
              validationError.value = response.data.message;
              return false;
            } else {
              steps.value = 2;
              employer_email.value = response.data.email;
              //   const token = response.data.token;
              //   localStorage.setItem("accessToken", token);
              //   showSuccessModal.value = true;

              //   setTimeout(() => {
              //       router.push("/");
              //   }, 1000);
            }
          })
          .catch((error) => {
            console.error(error);
          });
      } catch (error) {
        console.error(error);
      }
    };

    const validateOtp = async () => {
      try {
        isLoading.value = true;

        final_otp.value = enter_otp.value;

        await axios
          .post(`${apiUrl}/employer-check-forgot-otp`, {
            otp: final_otp.value,
            employer_email: employer_email.value,
          })
          .then((response) => {
            console.log(response);
            isLoading.value = false;
            if (response.data.error == 100) {
              otpError.value = true;
              return false;
            } else {
              steps.value = 3;
            }
          })
          .catch((error) => {
            console.error(error);
          });
      } catch (error) {
        console.error(error);
      }
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
      const formData = new FormData();
      formData.append("password", password.value);
      formData.append("employer_email", employer_email.value);

      try {
        await axios
          .post(`${apiUrl}/employer-update-forgot-password`, formData)
          .then((response) => {
            console.log(response);
            isLoading.value = false;
            if (response.data.error == 100) {
              alert("Something wrong");
            } else {
              showSuccessModal.value = true;
              setTimeout(() => {
                router.push("/");
              }, 3000);
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
      employer_email,
      updatePassword,
      confirmPassword,
      confirmPasswordError,
      forgotPassword,
      isLoading,
    //   state,
    //   countries_state,
      data,
      email,
      password,
      showSuccessModal,
      closeSuccessModal,
      router,
      route,
      emailError,
      passwordError,
      validationError,
      steps,
      validateOtp,
      seeker_email,
      seeker_id,
      otpError,
      enter_otp,

      formContainer,
    };
  },
};
</script>
