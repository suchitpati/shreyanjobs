<template>
  <div class="bg-[#eaf4ff] h-screen">
    <RecruiterNavbar />
    <div class="bg-[#ebf4ff]">
      <div class="max-w-[1080px] mx-auto px-[20px]">
        <div class="flex justify-end bg-[#ebf4ff] px-11 py-5">
          <div>
            <p>Welcome {{ recruiter_name }}</p>
            <p>(Bench Sales Recruiter)</p>
          </div>
        </div>
      </div>
    </div>

    <!-- <div class="w-full flex justify-end pt-4 pr-4 pl-4">
        <img class="w-[150px]" src="../../assets/logo-no-background.png" alt="" />
        <a
          href="/"
          class="border-[#1890da] hover:bg-[#f7f7f9] border-[1px] w-max sm:ml-auto text-[#1890da] font-bold md:py-[10px] py-[7px] px-[18px] md:px-[26px] rounded-[26px] focus:outline-none"
          >Home
        </a>
      </div> -->

    <div
      class="flex justify-center flex-col gap-6 items-center"
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
              Register Completed Successfully
            </h2>
            <button
              @click="closeSuccessModal"
              class="bg-blue-500 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded"
            >
              Ok
            </button>
          </div>
        </div>

        <div class="w-full max-w-[700px]">
          <div
            class="w-full bg-[#d3ddff4f] rounded-lg py-4 sm:px-8 px-4 lg:ml-[20px] shadow-[rgba(100,_100,_111,_0.2)_0px_5px_30px_0px]"
          >
            <h1
              class="sm:text-[28px] text-[22px] font-bold mt-[20px] sm:mb-[50px] mb-[30px] text-[#1890da]"
            >
              Edit to your account
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
                  Company website URL
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

              <div class="w-full flex gap-2 items-center">
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
                    disabled
                  />
                </div>
                <router-link
                  to="/recruiter-update-password"
                  class="hover:underline text-red-600 pt-5 w-[250px]"
                  >Change Password</router-link
                >
                <div
                  v-if="emailError"
                  class="text-red-600 block text-[14px] text-left"
                >
                  {{ emailError }}
                </div>
              </div>

              <!-- <div class="w-full mt-[10px]">
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

                <div class="w-full mt-[10px]">
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
                </div> -->

              <div class="w-full mt-[10px]">
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
                class="bg-[#1890da] hover:bg-blue-500 text-white font-bold py-2 px-8 mb-[20px] rounded focus:outline-none focus:shadow-outline mt-[40px]"
                @click.prevent="updateRecruiter"
              >
                Update
              </button>
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
import { ref, onMounted } from "vue";
import { useRouter } from "vue-router";
import axios from "axios";
import apiUrl from "../../api";
import RecruiterNavbar from "../Recruitment/RecruiterNavbar.vue";

export default {
  components: {
    RecruiterNavbar,
  },
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
    const enter_otp = ref("");

    const seeker_id = ref("");

    const stateError = ref("");

    const formContainer = ref(null);
    const isLoading = ref(false);
    const final_otp = ref("");

    const recruiter_data = ref({});
    const recruiter_name = ref("");

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

    const fetchRecruiterDetails = async () => {
      const recruiter_id = localStorage.getItem("recruiter_id");

      const recruiterResponse = await axios.post(
        `${apiUrl}/recruiter-details`,
        { id: recruiter_id }
      );
      recruiter_name.value = recruiterResponse.data.recruiter_details.fullname;
      console.log(recruiterResponse, "recruiterResponse");
    };
    const updateRecruiter = async () => {
      try {
        if (fullname.value == null || fullname.value == "") {
          fullnamenameError.value = "Please Enter Employer Name";
          return false;
        } else {
          fullnamenameError.value = "";
        }

        if (email.value == null || email.value == "") {
          emailError.value = "Please Enter Email";
          return false;
        } else {
          emailError.value = "";
        }

        var emailRegex = /^[^\s@]+@[^\s@]+\.[^\s@]+$/;
        if (emailRegex.test(email.value) == false) {
          emailError.value = "Please valid Email";
          return false;
        } else {
          emailError.value = "";
        }
        if (contactno.value == null || contactno.value == "") {
          contactnoError.value = "Enter contact no";
          return false;
        } else {
          contactnoError.value = "";
        }

        if (companyname.value == null || companyname.value == "") {
          companynameError.value = "Please Enter Comapany Name";
          return false;
        } else {
          companynameError.value = "";
        }

        if (companyurl.value == null || companyurl.value == "") {
          companyurlError.value = "Please Enter Comapany Url";
          return false;
        } else {
          companyurlError.value = "";
        }

        const recruiter_id = localStorage.getItem("recruiter_id");
        const formData = new FormData();
        formData.append("fullname", fullname.value);
        formData.append("email", email.value);
        formData.append("contactno", contactno.value);
        formData.append("companyname", companyname.value);
        formData.append("companyurl", companyurl.value);
        formData.append("recruiter_id", recruiter_id);

        await axios
          .post(`${apiUrl}/recruiter-update`, formData)
          .then((response) => {
            console.log(response);
            isLoading.value = false;
            if (response.data.error == 100) {
              validationError.value = response.data.message;
              return false;
            } else {
              window.location.reload();
            }
          })
          .catch((error) => {
            console.error(error);
          });
      } catch (error) {
        console.error(error);
      }
    };

    const getRecruiter = async () => {
      try {
        isLoading.value = true;
        const recruiter_ids = localStorage.getItem("recruiter_id");

        await axios
          .post(`${apiUrl}/recruiter-details`, {
            id: recruiter_ids,
          })
          .then((response) => {
            isLoading.value = false;
            if (response.data.error == 100) {
              otpError.value = true;
              return false;
            } else {
              fullname.value = response.data.recruiter_details.fullname;
              email.value = response.data.recruiter_details.emailid;
              companyname.value = response.data.recruiter_details.companyname;
              companyurl.value = response.data.recruiter_details.companyurl;
              contactno.value = response.data.recruiter_details.contactno;
            }
          })
          .catch((error) => {
            console.error(error);
          });
      } catch (error) {
        console.error(error);
      }
    };

    onMounted(() => {
      fetchRecruiterDetails(), getRecruiter();
    });

    return {
      recruiter_name,
      fetchRecruiterDetails,
      recruiter_data,
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
      seeker_id,
      otpError,
      enter_otp,
      formContainer,
      updateRecruiter,
      final_otp,
    };
  },
};
</script>

