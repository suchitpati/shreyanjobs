<template>
  <div class="bg-[#eaf4ff] h-screen">
    <div class="w-full flex justify-end pt-4 pr-4 pl-4">
      <img class="w-[150px]" src="../../assets/logo-no-background.png" alt="" />
      <a
        href="/"
        class="border-[#1890da] hover:bg-[#f7f7f9] border-[1px] w-max sm:ml-auto text-[#1890da] font-bold md:py-[10px] py-[7px] px-[18px] md:px-[26px] rounded-[26px] focus:outline-none"
        >Home
      </a>
    </div>
    <div
      class="p-3 h-[calc(100vh-110px)] flex justify-center flex-col gap-6 items-center"
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
                Bench Sales Recruiter account is created successfully.
            </h2>
            <button
              @click="closeSuccessModal"
              class="bg-blue-500 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded"
            >
              Ok
            </button>
          </div>
        </div>
        <div
          class="md:w-[50%] w-full md:max-w-[100%] max-w-[500px]"
          v-if="steps == 1"
        >
          <div
            class="w-full bg-white rounded-lg py-4 sm:px-8 px-4 lg:ml-[20px] shadow-[rgba(100,_100,_111,_0.2)_0px_5px_30px_0px]"
          >
            <h1
              class="sm:text-[28px] text-[22px] font-bold mt-[10px] sm:mb-[5px] mb-[1px] text-[#1890da]"
            >
              Bench Sales Recruiter Registration
            </h1>
            <div class="text-red-600 mt-0">
              Enter the details of bench sales recruiter below.
            </div>
            <div class="text-red-600">
              (**Consultants can be added after you login)
            </div>
            <div
              v-if="validationError"
              class="text-red-600 block text-[20px] text-center"
            >
              {{ validationError }}
            </div>
            <div class="mt-2">
              <div class="w-full">
                <label
                  class="block text-gray-700 font-bold mb-1 text-start text-[14px]"
                  for="field2"
                >
                  Full Name
                </label>
                <input
                  class="border border-gray-400 rounded-lg py-2 px-4 mb-1 outline-[#264dd9] focus:shadow-outline w-full"
                  type="text"
                  id="field1"
                  placeholder="Enter Full Name"
                  v-model="fullname"
                />
                <div
                  v-if="fullnamenameError"
                  class="text-red-600 block text-[14px] text-left"
                >
                  {{ fullnamenameError }}
                </div>
              </div>
              <div class="w-full">
                <label
                  class="block text-gray-700 font-bold mb-1 text-start text-[14px]"
                  for="field2"
                >
                  Company Name
                </label>
                <input
                  class="border border-gray-400 rounded-lg py-2 px-4 mb-1 outline-[#264dd9] focus:shadow-outline w-full"
                  type="text"
                  id="field1"
                  placeholder="Enter Company Name"
                  v-model="companyname"
                />
                <div
                  v-if="companynameError"
                  class="text-red-600 block text-[14px] text-left"
                >
                  {{ companynameError }}
                </div>
              </div>

              <div class="w-full">
                <label
                  class="block text-gray-700 font-bold mb-1 text-start text-[14px]"
                  for="field2"
                >
                  Company website URL (Optional)
                </label>
                <input
                  class="border border-gray-400 rounded-lg py-2 px-4 mb-1 outline-[#264dd9] focus:shadow-outline w-full"
                  type="text"
                  id="field1"
                  placeholder="Enter Website Url"
                  v-model="companyurl"
                />
                <div
                  v-if="companyurlError"
                  class="text-red-600 block text-[14px] text-left"
                >
                  {{ companyurlError }}
                </div>
              </div>

              <div class="w-full">
                <label
                  class="block text-gray-700 font-bold mb-1 text-start text-[14px]"
                  for="field2"
                >
                  Email
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

              <div class="w-full mt-1">
                <label
                  class="block text-gray-700 font-bold mb-1 text-start text-[14px]"
                  for="field2"
                >
                  Password
                </label>
                <input
                  class="border border-gray-400 rounded-lg py-2 px-4 mb-1 outline-[#264dd9] focus:shadow-outline w-full"
                  type="password"
                  id="field1"
                  placeholder="Enter Password"
                  v-model="password"
                />
                <div
                  v-if="passwordError"
                  class="text-red-600 block text-[14px] text-left"
                >
                  {{ passwordError }}
                </div>
              </div>

              <div class="w-full mt-1">
                <label
                  class="block text-gray-700 font-bold mb-1 text-start text-[14px]"
                  for="field2"
                >
                  Confirm Password
                </label>
                <input
                  class="border border-gray-400 rounded-lg py-2 px-4 mb-1 outline-[#264dd9] focus:shadow-outline w-full"
                  type="password"
                  id="field1"
                  placeholder="Enter Confirm Password"
                  v-model="confirmpassword"
                />
                <div
                  v-if="confirmpasswordError"
                  class="text-red-600 block text-[14px] text-left"
                >
                  {{ confirmpasswordError }}
                </div>
                <div
                  v-if="matchpasswordError"
                  class="text-red-600 block text-[14px] text-left"
                >
                  {{ matchpasswordError }}
                </div>
              </div>

              <div class="w-full mt-1">
                <label
                  class="block text-gray-700 font-bold mb-1 text-start text-[14px]"
                  for="field2"
                >
                  Contact Number (Optional)
                </label>
                <input
                  class="border border-gray-400 rounded-lg py-2 px-4 mb-1 outline-[#264dd9] focus:shadow-outline w-full"
                  type="text"
                  id="field1"
                  placeholder="Enter Contact number"
                  v-model="contactno"
                />
                <div
                  v-if="contactnoError"
                  class="text-red-600 block text-[14px] text-left"
                >
                  {{ contactnoError }}
                </div>
              </div>

              <button
                class="bg-[#1890da] hover:bg-blue-500 text-white font-bold py-2 px-8 rounded focus:outline-none focus:shadow-outline my-2"
                @click.prevent="registerRecruiter"
              >
                Register
              </button>
            </div>
          </div>
        </div>
        <div v-else>
          <div
            class="fixed inset-0 flex items-center justify-center enter_otp_class"
          >
            <div class="bg-white p-8 rounded-lg shadow-lg">
              <h2 class="text-2xl font-bold mb-2">Enter OTP</h2>
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
                class="bg-blue-500 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded mt-4"
              >
                Submit
              </button>
              <div class="text-[14px] mt-1">
                It may take 1 – 2 mins to receive the OTP in email.
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
import { ref } from "vue";
import { useRouter } from "vue-router";
import axios from "axios";
import apiUrl from "../../api";
export default {
  setup() {
    const companyname = ref("");
    const companynameError = ref("");

    const companyurl = ref("");
    const companyurlError = ref("");

    const fullname = ref("");
    const fullnamenameError = ref("");

    const email = ref("");
    const emailError = ref("");

    const password = ref("");
    const passwordError = ref("");

    const contactno = ref("");
    const contactnoError = ref("");

    const confirmpassword = ref("");
    const confirmpasswordError = ref("");

    const matchpasswordError = ref("");

    const validationError = ref("");
    const showSuccessModal = ref(false);
    const otpError = ref(false);

    const router = useRouter();
    const route = useRouter();
    const steps = ref(1);
    const enter_otp = ref("");

    const seeker_id = ref("");
    const recruiter_id = ref("");

    const stateError = ref("");

    const formContainer = ref(null);
    const isLoading = ref(false);
    const final_otp = ref("");

    const closeSuccessModal = () => {
      showSuccessModal.value = false;
    };

    function IsEmail(email) {
      var emailRegex = /^[^\s@]+@[^\s@]+\.[^\s@]+$/;
      if (emailRegex.test(email)) {
        return false;
      } else {
        return true;
      }
    }
    const registerRecruiter = async () => {
      try {
        if (fullname.value == null || fullname.value == "") {
          fullnamenameError.value = "Please Enter Employer Name";
          return false;
        } else {
          fullnamenameError.value = "";
        }
        if (companyname.value == null || companyname.value == "") {
          companynameError.value = "Please Enter Comapany Name";
          return false;
        } else {
          companynameError.value = "";
        }

        // if (companyurl.value == null || companyurl.value == "") {
        //   companyurlError.value = "Please Enter Comapany Url";
        //   return false;
        // } else {
        //   companyurlError.value = "";
        // }

        if (email.value == null || email.value == "") {
          emailError.value = "Please Enter Email";
          return false;
        } else {contactno
          emailError.value = "";
        }

        var emailRegex = /^[^\s@]+@[^\s@]+\.[^\s@]+$/;
        if (emailRegex.test(email.value) == false) {
          emailError.value = "Please valid Email";
          return false;
        } else {
          emailError.value = "";
        }


        if (password.value == null || password.value == "") {
          passwordError.value = "Please Enter Password";
          return false;
        } else {
          passwordError.value = "";
        }

        if (confirmpassword.value == null || confirmpassword.value == "") {
          confirmpasswordError.value = "Please Enter Confirm Password";
          return false;
        } else {
          confirmpasswordError.value = "";
        }
        const regex = /^(?=.*[A-Z])(?=.*\d).{8,}$/;

        if (regex.test(password.value) == false) {
          confirmpasswordError.value =
            "Enter At least 8 characters long with one capital and one number ";
          return false;
        } else {
          confirmpasswordError.value = "";
        }
        if (
          password.value != confirmpassword.value &&
          confirmpassword.value != null
        ) {
          matchpasswordError.value =
            "Please match password and Confirm Password";
          return false;
        } else {
          matchpasswordError.value = "";
        }


        const formData = new FormData();
        formData.append("fullname", fullname.value);
        formData.append("email", email.value);
        formData.append("contactno", contactno.value);
        formData.append("password", password.value);
        formData.append("companyname", companyname.value);
        formData.append("companyurl", companyurl.value);
        isLoading.value = true;

        await axios
          .post(`${apiUrl}/recruiter-register`, formData)
          .then((response) => {
            console.log(response);
            isLoading.value = false;
            if (response.data.error == 100) {
              validationError.value = response.data.message;
              return false;
            } else {
              steps.value = 2;
              recruiter_id.value = response.data.recruiter_id;
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
          .post(`${apiUrl}/recruiter-validate-otp`, {
            otp: final_otp.value,
            recruiter_id: recruiter_id.value,
          })
          .then((response) => {
            console.log(response);
            isLoading.value = false;
            if (response.data.error == 100) {
              otpError.value = true;
              return false;
            } else {
              const elementToHide = document.querySelector(".enter_otp_class");
              elementToHide.classList.add("hidden");

              showSuccessModal.value = true;
              setTimeout(() => {
                router.push("/recruiter-login");
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
      IsEmail,
      stateError,
      companyname,
      companynameError,
      companyurl,
      companyurlError,
      fullname,
      fullnamenameError,
      email,
      emailError,
      password,
      passwordError,
      confirmpassword,
      confirmpasswordError,
      matchpasswordError,
      contactno,
      contactnoError,
      isLoading,
      showSuccessModal,
      closeSuccessModal,
      router,
      route,
      validationError,
      steps,
      seeker_id,
      otpError,
      enter_otp,
      formContainer,
      registerRecruiter,
      validateOtp,
      final_otp,
    };
  },
};
</script>

<style>
  .hidden {
    display: none !important;
  }
</style>
