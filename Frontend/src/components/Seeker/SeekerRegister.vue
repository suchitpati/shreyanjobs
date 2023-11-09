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
              Registration Completed Successfully
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
              Register to your account
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
                  placeholder="Full Name"
                  v-model="fullname"
                />
                <div
                  v-if="fullnameError"
                  class="text-red-600 block text-[14px] text-left"
                >
                  {{ fullnameError }}
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
                  placeholder="Email"
                  v-model="email"
                />
                <div
                  v-if="emailError"
                  class="text-red-600 block text-[14px] text-left"
                >
                  {{ emailError }}
                </div>
              </div>
              <div class="w-full mt-[10px]">
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
                  placeholder="Password"
                  v-model="password"
                />
                <div
                  v-if="passwordError"
                  class="text-red-600 block text-[14px] text-left"
                >
                  {{ passwordError }}
                </div>
              </div>
              <div class="w-full mt-[10px] flex gap-2 items-center">
                <label
                  class="block text-gray-700 font-bold text-start text-[14px]"
                  for="field2"
                >
                  Gender
                </label>
                <div class="flex items-center gap-1">
                  <input class="" type="radio" value="1" v-model="gender" />
                  <label for="">Male</label>
                  <input class="" type="radio" value="2" v-model="gender" />
                  <label for="">Female</label>
                </div>
                <div
                  v-if="genderError"
                  class="text-red-600 block text-[14px] text-left"
                >
                  {{ genderError }}
                </div>
              </div>

              <button
                class="bg-[#1890da] hover:bg-blue-500 text-white font-bold py-2 px-8 mb-[20px] rounded focus:outline-none focus:shadow-outline mt-[40px]"
                @click.prevent="seekerRegister"
              >
                Register
              </button>
            </div>
          </div>
        </div>
        <div v-else-if="steps == 2">
          <div class="fixed inset-0 flex items-center justify-center">
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
            </div>
          </div>
        </div>
        <div v-else>
          <div class="bg-[#eaf4ff]">
            <div
              class="bg-[#ebf4ff] py-7 h-[calc(100vh_-_62px)] overflow-y-auto"
            >
              <div class="max-w-[1080px] w-full mx-auto px-[20px]">
                <div
                  class="bg-[#fff] rounded-lg py-4 sm:px-8 px-4 w-full shadow-[rgba(100,_100,_111,_0.2)_0px_0px_10px_0px] hover:shadow-[rgba(100,_100,_111,_0.2)_0px_0px_20px_0px] transition-[.5s]"
                >
                  <h1
                    class="text-[#1890da] sm:text-[26px] text-[22px] font-semibold mt-[30px] sm:mb-[40px] mb-[25px]"
                  >
                    Few more details to complete your profile (Will take less
                    than a minute to complete)
                  </h1>
                  <div class="mt-4">
                    <div
                      class="w-full flex sm:flex-row flex-col justify-between md:gap-6 gap-3 sm:mb-4 mb-7"
                    >
                      <div class="w-[25%]">
                        <label
                          class="block text-gray-700 font-bold mb-1 text-start text-[14px]"
                          for="field2"
                        >
                          Country
                        </label>
                        <select
                          v-model="selectedCountry"
                          @change="onCountryChange"
                          class="block w-full bg-white border text-sm rounded-lg p-2"
                        >
                          <option value="">Select Country</option>
                          <option
                            v-for="country in countries_state"
                            :key="country.isoCode"
                            :value="country.isoCode"
                            class="flex items-center"
                            :selected="country.isoCode == 'US'"
                          >
                            <span
                              class="flag-icon flag-icon-{{ country.isoCode.toLowerCase() }} inline-block w-4 h-4 mr-2"
                            ></span>
                            <div>{{ country.name }}</div>
                          </option>
                        </select>
                        <div
                          class="text-red-600 block text-[14px] text-left"
                          v-if="err_country != ''"
                        >
                          {{ err_country }}
                        </div>
                      </div>
                      <div class="w-[25%]">
                        <label
                          class="block text-gray-700 font-bold mb-1 text-start text-[14px]"
                          for="field2"
                        >
                          State
                        </label>
                        <select
                          v-model="selectedState"
                          class="block w-full bg-white border text-sm rounded-lg p-2"
                          :disabled="remote"
                          @change="setSelectedState"
                        >
                          <option value="">Select State</option>
                          <option
                            v-for="state in states"
                            :key="state.isoCode"
                            :value="state.isoCode"
                          >
                            {{ state.name }}
                          </option>
                        </select>

                        <div
                          class="text-red-600 block text-[14px] text-left"
                          v-if="err_state != ''"
                        >
                          {{ err_state }}
                        </div>
                      </div>
                      <div class="w-[25%]">
                        <label
                          class="block text-gray-700 font-bold mb-1 text-start text-[14px]"
                          for="field2"
                        >
                          City
                        </label>

                        <input
                          v-model="city"
                          type="text"
                          placeholder="Enter City"
                          class="block w-full bg-white border text-sm rounded-lg p-2"
                        />
                        <div
                          class="text-red-600 block text-[14px] text-left"
                          v-if="err_city != ''"
                        >
                          {{ err_city }}
                        </div>
                      </div>
                      <div class="w-[25%]">
                        <label
                          class="block text-gray-700 font-bold mb-1 text-start text-[14px]"
                          for="field2"
                        >
                          Contact Number
                        </label>
                        <input
                          type="text"
                          v-model="contact_number"
                          placeholder="Enter Contact number"
                          class="block w-full bg-white border text-sm rounded-lg p-2"
                        />
                        <div
                          class="text-red-600 block text-[14px] text-left"
                          v-if="err_contact_number != ''"
                        >
                          {{ err_contact_number }}
                        </div>
                      </div>
                    </div>
                    <div
                      class="w-full flex sm:flex-row flex-col justify-between sm:gap-6 gap-2"
                    >
                      <div class="sm:w-[50%] mb-4">
                        <label
                          class="block text-gray-700 font-bold mb-1 text-start text-[14px]"
                          for="field1"
                        >
                          Work authorization
                        </label>
                        <input
                          class="border border-gray-400 rounded-lg py-2 px-4 outline-[#264dd9] focus:shadow-outline w-full"
                          type="text"
                          id="field1"
                          v-model="work_authorization"
                          placeholder="Enter skill"
                        />
                        <div
                          class="text-red-600 block text-[14px] text-left"
                          v-if="err_work_authorization != ''"
                        >
                          {{ err_work_authorization }}
                        </div>
                        <div
                          class="text-red-600 block text-[14px] text-left"
                          v-if="err_skill != ''"
                        >
                          {{ err_skill }}
                        </div>
                      </div>

                      <div class="sm:w-[50%] mb-4">
                        <label
                          class="block text-gray-700 font-bold mb-1 text-start text-[14px]"
                          for="field1"
                        >
                          Total IT Yrs of Experience
                        </label>
                        <input
                          class="border border-gray-400 rounded-lg py-2 px-4 outline-[#264dd9] focus:shadow-outline w-full"
                          type="number"
                          id="field1"
                          v-model="total_experience"
                          placeholder="Enter Experience"
                        />
                        <div
                          class="text-red-600 block text-[14px] text-left"
                          v-if="err_total_experience != ''"
                        >
                          {{ err_total_experience }}
                        </div>
                      </div>
                    </div>
                    <div
                      class="w-full flex sm:flex-row flex-col justify-between sm:gap-6 gap-2"
                    >
                      <div class="sm:w-[50%] mb-4">
                        <label
                          class="block text-gray-700 font-bold mb-1 text-start text-[14px]"
                          for="field2"
                        >
                          Primary skill
                        </label>
                        <input
                          class="border border-gray-400 rounded-lg py-2 px-4 outline-[#264dd9] focus:shadow-outline w-full"
                          type="text"
                          id="field1"
                          v-model="primary_skill"
                          placeholder="Enter  Primary skill"
                        />
                        <div
                          class="text-red-600 block text-[14px] text-left"
                          v-if="err_primary_skill != ''"
                        >
                          {{ err_primary_skill }}
                        </div>
                      </div>

                      <div class="sm:w-[50%] mb-4">
                        <label
                          class="block text-gray-700 font-bold mb-1 text-start text-[14px]"
                          for="field1"
                        >
                          Yrs. Of experience in Primary skill
                        </label>
                        <input
                          class="border border-gray-400 rounded-lg py-2 px-4 outline-[#264dd9] focus:shadow-outline w-full"
                          type="number"
                          id="field1"
                          v-model="primary_experience"
                          placeholder="Enter Yrs. Of experience in Primary skill"
                        />
                        <div
                          class="text-red-600 block text-[14px] text-left"
                          v-if="err_primary_experience != ''"
                        >
                          {{ err_primary_experience }}
                        </div>
                      </div>
                    </div>
                    <div
                      class="w-full flex sm:flex-row flex-col justify-between sm:gap-6 gap-2"
                    >
                      <div class="sm:w-[50%] mb-4">
                        <label
                          class="block text-gray-700 font-bold mb-1 text-start text-[14px]"
                          for="field2"
                        >
                          Secondary skill
                        </label>
                        <input
                          class="border border-gray-400 rounded-lg py-2 px-4 outline-[#264dd9] focus:shadow-outline w-full"
                          type="text"
                          id="field1"
                          v-model="secondary_skill"
                          placeholder="Enter  Secondary skill"
                        />
                        <div
                          class="text-red-600 block text-[14px] text-left"
                          v-if="err_secondary_skill != ''"
                        >
                          {{ err_secondary_skill }}
                        </div>
                      </div>

                      <div class="sm:w-[50%] mb-4">
                        <label
                          class="block text-gray-700 font-bold mb-1 text-start text-[14px]"
                          for="field1"
                        >
                          Yrs. Of experience in Secondary skill
                        </label>
                        <input
                          class="border border-gray-400 rounded-lg py-2 px-4 outline-[#264dd9] focus:shadow-outline w-full"
                          type="number"
                          id="field1"
                          v-model="secondary_experience"
                          placeholder="Enter Yrs. Of experience in Secondary skill"
                        />
                        <div
                          class="text-red-600 block text-[14px] text-left"
                          v-if="err_secondary_experience != ''"
                        >
                          {{ err_secondary_experience }}
                        </div>
                      </div>
                    </div>
                    <div
                      class="w-full flex sm:flex-row flex-col justify-between sm:gap-6 gap-2 items-center"
                    >
                      <div class="sm:w-[50%] mb-4">
                        <label
                          class="block text-gray-700 font-bold mb-1 text-start text-[14px]"
                          for="email"
                        >
                          Resume
                        </label>

                        <input
                          class="border border-gray-400 rounded-lg py-2 px-4 outline-[#264dd9] focus:shadow-outline w-full"
                          type="file"
                          id="file"
                          placeholder="Enter Email"
                          @change="image_details"
                        />
                        <div
                          class="text-red-600 block text-[14px] text-left"
                          v-if="err_file != ''"
                        >
                          {{ err_file }}
                        </div>
                      </div>
                      <div class="sm:w-[50%] ">
                        <div class="flex items-center gap-2">
                          <label
                            class="block text-gray-700 font-bold text-start text-[14px]"
                            for="field2"
                          >
                            OK to Relocate
                          </label>
                          <input type="checkbox" v-model="relocate" />
                        </div>
                      </div>
                    </div>
                  </div>
                  <button
                    class="bg-blue-500 hover:bg-blue-700 text-white font-bold py-2 px-8 mb-4 mt-4 rounded-full focus:outline-none focus:shadow-outline"
                    @click="addSeekerDetails"
                  >
                    Complete Registration
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
import { reactive, ref, onMounted, watch } from "vue";
import { useRouter } from "vue-router";
import axios from "axios";
import { debounce } from "lodash";
import { Country, State } from "country-state-city";
// import "vue-loading-overlay/dist/css/index.css";

import apiUrl from "../../api";

export default {
  setup() {
    const data = reactive({});

    const fullname = ref("");
    const fullnameError = ref("");
    const email = ref("");
    const emailError = ref("");
    const passwordError = ref("");
    const password = ref("");
    const gender = ref("");
    const genderError = ref("");
    const validationError = ref("");
    const showSuccessModal = ref(false);
    const otpError = ref(false);

    const router = useRouter();
    const route = useRouter();

    const countries_state = ref([]);
    const country = ref("");
    const countries = ref([]);
    const selectedCountry = ref("US");
    const states = ref([]);
    const state = ref("");
    const selectedState = ref("");
    const selectedState_main = ref("");

    const steps = ref(1);
    const enter_otp = ref("");

    const final_otp = ref("");
    const seeker_id = ref("");

    const city = ref("");
    const contact_number = ref("");
    const work_authorization = ref("");
    const total_experience = ref("");
    const primary_skill = ref("");
    const primary_experience = ref("");
    const secondary_skill = ref("");
    const secondary_experience = ref("");
    const err_country = ref("");
    const err_state = ref("");
    const err_contact_number = ref("");
    const err_work_authorization = ref("");
    const err_total_experience = ref("");
    const err_primary_skill = ref("");
    const err_primary_experience = ref("");
    const err_secondary_skill = ref("");
    const err_secondary_experience = ref("");
    const err_city = ref("");
    const file = ref("");
    const err_file = ref("");
    const fullPage = ref(true);
    const formContainer = ref(null);
    const isLoading = ref(false);
    const relocate = ref(0);

    const closeSuccessModal = () => {
      showSuccessModal.value = false;
    };

    const seekerRegister = async () => {
      try {
        console.log(gender.value, "gender.value");
        if (fullname.value == null || fullname.value == "") {
          fullnameError.value = "Please Enter FullName";
          return false;
        } else {
          fullnameError.value = "";
        }

        if (email.value == null || email.value == "") {
          emailError.value = "Please Enter Email";
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
        const regex = /^(?=.*[A-Z])(?=.*\d).{8,}$/;

        if (regex.test(password.value) == false) {
          passwordError.value =
            "Enter At least 8 characters long with one capital and one number ";
          return false;
        } else {
          passwordError.value = "";
        }
        if (gender.value == null || gender.value == "") {
          genderError.value = "Please select Gender";
          return false;
        } else {
          genderError.value = "";
        }

        console.log(relocate.value, "relocaterelocate");

        isLoading.value = true;
        await axios
          .post(`${apiUrl}/registerSeeker`, {
            fullname: fullname.value,
            email: email.value,
            password: password.value,
            gender: gender.value,
          })
          .then((response) => {
            console.log(response);
            isLoading.value = false;
            if (response.data.error == 100) {
              validationError.value = response.data.message;
              return false;
            } else {
              steps.value = 2;
              seeker_id.value = response.data.seeker_id;
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

    const image_details = async (event) => {
      file.value = event.target.files[0]; // Get the first selected file
    };

    const validateOtp = async () => {
      try {
        isLoading.value = true;

        final_otp.value = enter_otp.value;

        await axios
          .post(`${apiUrl}/validateOtp`, {
            otp: final_otp.value,
            seeker_id: seeker_id.value,
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
    const addSeekerDetails = async () => {
      if (selectedCountry.value == null || selectedCountry.value == "") {
        err_country.value = "The country field is required";
        return false;
      } else {
        err_country.value = "";
      }
      if (selectedState.value == null || selectedState.value == "") {
        err_state.value = "The State field is required";
        return false;
      } else {
        err_state.value = "";
      }
      if (city.value == null || city.value == "") {
        err_city.value = "The City field is required";
        return false;
      } else {
        err_city.value = "";
      }
      if (contact_number.value == null || contact_number.value == "") {
        err_contact_number.value = "The field is required";
        return false;
      } else {
        err_contact_number.value = "";
      }
      if (work_authorization.value == null || work_authorization.value == "") {
        err_work_authorization.value =
          "The work authorization field is required";
        return false;
      } else {
        err_work_authorization.value = "";
      }
      if (total_experience.value == null || total_experience.value == "") {
        err_total_experience.value = "The Total Experience field is required";
        return false;
      } else {
        err_total_experience.value = "";
      }
      if (primary_skill.value == null || primary_skill.value == "") {
        err_primary_skill.value = "The Primary skill is required";
        return false;
      } else {
        err_primary_skill.value = "";
      }
      if (primary_experience.value == null || primary_experience.value == "") {
        err_primary_experience.value =
          "The primary experience field is required";
        return false;
      } else {
        err_primary_experience.value = "";
      }
      if (secondary_skill.value == null || secondary_skill.value == "") {
        err_secondary_skill.value = "The secondary skill field is required";
        return false;
      } else {
        err_secondary_skill.value = "";
      }
      if (
        secondary_experience.value == null ||
        secondary_experience.value == ""
      ) {
        err_secondary_experience.value =
          "The secondary experience field is required";
        return false;
      } else {
        err_secondary_experience.value = "";
      }

      if (file.value == null || file.value == "") {
        err_file.value = "Pleas select file";
        return false;
      } else {
        err_file.value = "";
      }

      if (relocate.value == true) {
          relocate.value = 1;
        }
      const formData = new FormData();
      formData.append("pdf", file.value);
      formData.append("country", selectedCountry.value);
      formData.append("state", selectedState.value);
      formData.append("city", city.value);
      formData.append("contact_number", contact_number.value);
      formData.append("work_authorization", work_authorization.value);
      formData.append("total_experience", total_experience.value);
      formData.append("primary_skill", primary_skill.value);
      formData.append("primary_experience", primary_experience.value);
      formData.append("secondary_skill", secondary_skill.value);
      formData.append("secondary_experience", secondary_experience.value);
      formData.append("seeker_id", seeker_id.value);
      formData.append("relocate", relocate.value);


      try {
        await axios
          .post(`${apiUrl}/addSeekerDetails`, formData, {
            headers: {
              "Content-Type": "multipart/form-data",
            },
          })
          .then((response) => {
            console.log(response);
            isLoading.value = false;
            if (response.data.error == 100) {
              alert("Something wrong");
            } else {
              showSuccessModal.value = true;
              setTimeout(() => {
                router.push("/seeker-login");
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

    const onCountryChange = async () => {
      const selectedCountryObj = await countries_state.value.find(
        (countrys) => countrys.isoCode === selectedCountry.value
      );
      console.log("selectedCountryObj", selectedCountryObj);

      country.value = selectedCountryObj
        ? JSON.parse(JSON.stringify(selectedCountryObj)).name
        : "";
      // err_country.value = "";
      states.value = selectedCountryObj
        ? State.getStatesOfCountry(selectedCountryObj.isoCode)
        : "";
      selectedState.value = "";
      selectedState_main.value = "";
    };

    const fetchCountries = debounce(async () => {
      await axios
        .get(`${apiUrl}/countries`)
        .then((response) => {
          countries.value = response.data;
        })
        .catch((error) => {
          console.error(error);
        });
    });
    const defaultSelectedState = async () => {
      states.value = countries.value ? State.getStatesOfCountry("US") : "";
    };
    watch([country]);
    onMounted(() => {
      countries_state.value = Country.getAllCountries();
      console.log(countries_state.value, "countries_state.value");
      fetchCountries();
      defaultSelectedState();
    });

    return {
      isLoading,
      state,
      country,
      countries_state,
      fullname,
      fullnameError,
      data,
      email,
      password,
      gender,
      genderError,
      showSuccessModal,
      closeSuccessModal,
      router,
      route,
      emailError,
      passwordError,
      seekerRegister,
      validationError,
      steps,
      fetchCountries,
      onCountryChange,
      selectedState,
      selectedState_main,
      selectedCountry,
      states,
      validateOtp,
      seeker_id,
      otpError,
      city,
      contact_number,
      work_authorization,
      total_experience,
      primary_skill,
      primary_experience,
      secondary_skill,
      secondary_experience,
      addSeekerDetails,
      err_country,
      err_state,
      err_contact_number,
      err_work_authorization,
      err_total_experience,
      err_primary_skill,
      err_secondary_skill,
      err_primary_experience,
      err_secondary_experience,
      err_city,
      image_details,
      file,
      err_file,
      enter_otp,
      fullPage,
      relocate,

      formContainer,
    };
  },
};
</script>
