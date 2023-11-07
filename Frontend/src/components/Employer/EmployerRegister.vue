<template>
  <div class="bg-[#eaf4ff]">
    <div class="w-full flex justify-end pt-4 pr-4 pl-4">
      <img class="w-[150px]" src="../../assets/logo-no-background.png" alt="" />
      <a
        href="/"
        class="border-[#1890da] hover:bg-[#f7f7f9] border-[1px] w-max sm:ml-auto text-[#1890da] font-bold md:py-[10px] py-[7px] px-[18px] md:px-[26px] rounded-[26px] focus:outline-none"
        >Job search page
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
                  Company Website URL
                </label>
                <input
                  class="border border-gray-400 rounded-lg py-2 px-4 mb-1 outline-[#264dd9] focus:shadow-outline w-full"
                  type="text"
                  id="field1"
                  placeholder="Enter Website Url"
                  v-model="companywebsite"
                />
                <div
                  v-if="companywebsiteError"
                  class="text-red-600 block text-[14px] text-left"
                >
                  {{ companywebsiteError }}
                </div>
              </div>
              <div class="w-full">
                <label
                  class="block text-gray-700 font-bold mb-1 text-start text-[14px]"
                  for="field2"
                >
                  Employer Name
                </label>
                <input
                  class="border border-gray-400 rounded-lg py-2 px-4 mb-1 outline-[#264dd9] focus:shadow-outline w-full"
                  type="text"
                  id="field1"
                  placeholder="Enter Employer Name"
                  v-model="employername"
                />
                <div
                  v-if="employernameError"
                  class="text-red-600 block text-[14px] text-left"
                >
                  {{ employernameError }}
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
              </div>
              <div class="w-full mt-[10px]">
                <label
                  class="block text-gray-700 font-bold mb-1 text-start text-[14px]"
                  for="field2"
                >
                  Contact No
                </label>
                <input
                  class="border border-gray-400 rounded-lg py-2 px-4 mb-1 outline-[#264dd9] focus:shadow-outline w-full"
                  type="text"
                  id="field1"
                  placeholder="Enter Contact number"
                  v-model="contact_no"
                />
                <div
                v-if="contact_noError"
                class="text-red-600 block text-[14px] text-left"
              >
                {{ contact_noError }}
              </div>
                <div class="flex gap-[15px]">
                  <div class="w-[33.33%]">
                    <div
                      class="w-full flex sm:flex-row flex-col justify-between md:gap-6 gap-3 sm:mb-4 mb-7"
                    >
                      <div class="">
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
                            :selected="country.isoCode === 'US'"
                          >
                            <span
                              class="flag-icon flag-icon-{{ country.isoCode.toLowerCase() }} inline-block w-4 h-4 mr-2"
                            ></span>
                            <!-- <div class="mr-2">{{ country.flag }}</div> -->
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
                    </div>
                  </div>
                  <div class="w-[33.33%]">
                    <!-- <div class="sm:w-[80%]"> -->
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
                      :selected="country.isoCode === 'US'"
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
                    v-if="err_state"
                  >
                    {{ err_state }}
                  </div>                  </div>
                  <div class="w-[33.33%]">
                    <!-- <div class="sm:w-[80%]"> -->
                    <label
                      class="block text-gray-700 font-bold mb-1 text-start text-[14px]"
                      for="field2"
                    >
                      City
                    </label>
                    <input
                    v-model="city"
                      placeholder="City Name"
                      class="bg-[#FFFFFF] border placeholder:text-[#2C3E50] w-full p-2 rounded-lg text-sm"
                    />
                    <div
                      v-if="err_city"
                      class="text-red-600 block text-[14px] text-left"
                    >
                      {{ err_city }}
                    </div>
                  </div>
                </div>
              </div>
              <button
                class="bg-[#1890da] hover:bg-blue-500 text-white font-bold py-2 px-8 mb-[20px] rounded focus:outline-none focus:shadow-outline mt-[40px]"
                @click.prevent="registerEmployer"
              >
                Register
              </button>
            </div>
          </div>
        </div>
        <div v-else>
          <div class="fixed inset-0 flex items-center justify-center enter_otp_class">
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
                @click="verifyotp"
                class="bg-blue-500 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded mt-4"
              >
                Submit
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
    const companyname = ref("");
    const companynameError = ref("");

    const companywebsite = ref("");
    const companywebsiteError = ref("");

    const employername = ref("");
    const employernameError = ref("");

    const email = ref("");
    const emailError = ref("");

    const password = ref("");
    const passwordError = ref("");

    const confirmpassword = ref("");
    const confirmpasswordError = ref("");

    const matchpasswordError = ref("");

    const contact_no = ref("");
    const contact_noError = ref("");

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
    const err_country = ref("");
    const err_state = ref("");
    const err_contact_number = ref("");
    const stateError = ref("");
    const err_city = ref("");
    const formContainer = ref(null);
    const isLoading = ref(false);
    const employer_id = ref('');
    const closeSuccessModal = () => {
      showSuccessModal.value = false;
    };

    const registerEmployer = async () => {
      try {
        if (companyname.value == null || companyname.value == "") {
          companynameError.value = "Please Enter Comapany Name";
          return false;
        } else {
          companynameError.value = "";
        }


        if (employername.value == null || employername.value == "") {
          employernameError.value = "Please Enter Employer Name";
          return false;
        } else {
          employernameError.value = "";
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

        if (confirmpassword.value == null || confirmpassword.value == "") {
          confirmpasswordError.value = "Please Enter Confirm Password";
          return false;
        } else {
          confirmpasswordError.value = "";
        }
             const regex = /^(?=.*[A-Z])(?=.*\d).{8,}$/;

            if(regex.test(password.value) == false )
            {
                confirmpasswordError.value = "Enter At least 8 characters long with one capital and one number "
                return false;

            }
            else
            {
                confirmpasswordError.value = "";
            }
        if (password.value != confirmpassword.value && confirmpassword.value != null) {
            matchpasswordError.value = "Please match password and Confirm Password";
          return false;
        } else {
            matchpasswordError.value = "";
        }
        if (contact_no.value == null || contact_no.value == "") {
            contact_noError.value = "Enter contact no";
          return false;
        } else {
            contact_noError.value = "";
        }

        if (selectedState.value == null || selectedState.value == "") {
            console.log('selectedState',selectedState.value);
            err_state.value = "Select state";
          return false;
        } else {
            err_state.value = "";
        }


        if (city.value == null || city.value == "") {
            err_city.value = "Please Enter City";
          return false;
        } else {
            err_city.value = "";
        }

        const formData = new FormData();
        formData.append("companyname", companyname.value);
        formData.append("companywebsite", companywebsite.value);
        formData.append("employername", employername.value);
        formData.append("email", email.value);
        formData.append("password", password.value);
        formData.append("contact_no", contact_no.value);
        formData.append("country", selectedCountry.value);
        formData.append("state", selectedState.value);
        formData.append("city", city.value);
        isLoading.value = true;

        await axios
          .post(`${apiUrl}/employer-register`, formData)
          .then((response) => {
            console.log(response);
            isLoading.value = false;
            if (response.data.error == 100) {
              validationError.value = response.data.message;
              return false;
            } else {
              steps.value = 2;
              employer_id.value = response.data.employer_id;

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

    const verifyotp = async () => {
      try {
        isLoading.value = true;

        final_otp.value = enter_otp.value;

        await axios
          .post(`${apiUrl}/verify-register-otp`, {
            otp: final_otp.value,
            employer_id: employer_id.value,
          })
          .then((response) => {
            console.log(response);
            isLoading.value = false;
            if (response.data.error == 100) {
              otpError.value = true;
              return false;
            } else {
                const elementToHide = document.querySelector('.enter_otp_class');
                elementToHide.classList.add('hidden');

                showSuccessModal.value = true;
              setTimeout(() => {
                router.push("/");
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
        stateError,
      companyname,
      companynameError,
      companywebsite,
      companywebsiteError,
      employername,
      employernameError,
      email,
      emailError,
      password,
      passwordError,
      confirmpassword,
      confirmpasswordError,
      matchpasswordError,
      contact_no,
      contact_noError,
      isLoading,
      state,
      country,
      countries_state,
      data,
      showSuccessModal,
      closeSuccessModal,
      router,
      route,
      validationError,
      steps,
      fetchCountries,
      onCountryChange,
      selectedState,
      selectedState_main,
      selectedCountry,
      states,
      verifyotp,
      seeker_id,
      otpError,
      city,
      contact_number,
      registerEmployer,
      err_country,
      err_state,
      err_contact_number,
      err_city,
      enter_otp,

      formContainer,
    };
  },
};
</script>
