<template>
  <div>
    <SuccessModal v-if="showLogoutModal" :message="successMessage" />
    <div
      v-if="showSuccessModal"
      class="fixed inset-0 flex items-center justify-center bg-gray-900 bg-opacity-75"
    >
      <div class="bg-white p-8 rounded-lg shadow-lg">
        <h2 class="text-2xl font-bold mb-4">Job Added Successfully!</h2>
        <button
          @click="closeSuccessModal"
          class="bg-blue-500 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded"
        >
          Close
        </button>
      </div>
    </div>
    <div class="flex justify-end gap-4 pr-11 pt-5 pb-5 bg-[#fff]">
      <button
        class="bg-blue-500 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded-full focus:outline-none focus:shadow-outline"
        @click="adminLogout"
      >
        Logout
      </button>
      <button
        class="bg-blue-500 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded-full focus:outline-none focus:shadow-outline"
        @click="adminProfile()"
      >
        Profile
      </button>
    </div>
    <div class="bg-[#ebf4ff] py-7 h-[calc(100vh-80px)] overflow-y-auto">
      <div class="max-w-[1080px] w-full mx-auto px-[20px]">
        <!-- <h1
                    class="text-[#1890da] sm:text-[26px] text-[22px] font-semibold mt-[30px] sm:mb-[40px] mb-[25px]"
                >
                    Admin Page - Post Job Requirement
                </h1> -->
        <div
          class="bg-[#d3ddff4f] rounded-lg py-4 sm:px-8 px-4 w-full shadow-[rgba(100,_100,_111,_0.2)_0px_0px_10px_0px] hover:shadow-[rgba(100,_100,_111,_0.2)_0px_0px_20px_0px] transition-[.5s]"
        >
          <div class="mt-4">
            <div
              class="w-full flex sm:flex-row flex-col justify-between sm:gap-6 gap-2"
            >
              <div class="sm:w-[100%] mb-4">
                <label
                  class="block text-gray-700 font-bold mb-1 text-start text-[14px]"
                  for="field1"
                >
                  Company Name
                </label>
                <input
                  class="border border-gray-400 rounded-lg py-2 px-4 outline-[#264dd9] focus:shadow-outline w-full"
                  type="text"
                  id="field1"
                  v-model="company_name"
                  placeholder="Enter skill"
                />
                <div
                  class="text-red-600 block text-[14px] text-left"
                  v-if="err_skill != ''"
                >
                  {{ err_skill }}
                </div>
              </div>
            </div>
            <div
              class="w-full flex sm:flex-row flex-col justify-between sm:gap-6 gap-2"
            >
              <div class="sm:w-[100%] mb-4">
                <label
                  class="block text-gray-700 font-bold mb-1 text-start text-[14px]"
                  for="field1"
                >
                  Company Website URL
                </label>
                <input
                  class="border border-gray-400 rounded-lg py-2 px-4 outline-[#264dd9] focus:shadow-outline w-full"
                  type="text"
                  id="field1"
                  v-model="companyurl"
                  placeholder="Enter skill"
                />
                <div
                  class="text-red-600 block text-[14px] text-left"
                  v-if="err_skill != ''"
                >
                  {{ err_skill }}
                </div>
              </div>
            </div>
            <div
              class="w-full flex sm:flex-row flex-col justify-between sm:gap-6 gap-2"
            >
              <div class="sm:w-[100%] mb-4">
                <label
                  class="block text-gray-700 font-bold mb-1 text-start text-[14px]"
                  for="field1"
                >
                  Employer Name
                </label>
                <input
                  class="border border-gray-400 rounded-lg py-2 px-4 outline-[#264dd9] focus:shadow-outline w-full"
                  type="text"
                  id="field1"
                  v-model="employername"
                  placeholder="Enter skill"
                />
                <div
                  class="text-red-600 block text-[14px] text-left"
                  v-if="err_skill != ''"
                >
                  {{ err_skill }}
                </div>
              </div>
            </div>
            <div
              class="w-full flex sm:flex-row flex-col justify-between sm:gap-6 gap-2"
            >
              <div class="sm:w-[100%] mb-4">
                <label
                  class="block text-gray-700 font-bold mb-1 text-start text-[14px]"
                  for="field1"
                >
                  Email ID
                </label>
                <input
                  class="border border-gray-400 rounded-lg py-2 px-4 outline-[#264dd9] focus:shadow-outline w-full"
                  type="text"
                  id="field1"
                  v-model="emailid"
                  placeholder="Enter skill"
                />
                <div
                  class="text-red-600 block text-[14px] text-left"
                  v-if="err_skill != ''"
                >
                  {{ err_skill }}
                </div>
              </div>
            </div>
            <div
              class="w-full flex sm:flex-row flex-col justify-between sm:gap-6 gap-2"
            >
              <div class="sm:w-[100%] mb-4">
                <label
                  class="block text-gray-700 font-bold mb-1 text-start text-[14px]"
                  for="field1"
                >
                  Contact No
                </label>
                <input
                  class="border border-gray-400 rounded-lg py-2 px-4 outline-[#264dd9] focus:shadow-outline w-full"
                  type="text"
                  id="field1"
                  v-model="contactno"
                  placeholder="Enter skill"
                />
                <div
                  class="text-red-600 block text-[14px] text-left"
                  v-if="err_skill != ''"
                >
                  {{ err_skill }}
                </div>
              </div>
            </div>

            <div
              class="w-full flex sm:flex-row flex-col justify-between md:gap-6 gap-3 sm:mb-4 mb-7"
            >
              <div class="sm:w-[33%]">
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
                    :selected="empCountry.value === 'FR'"
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
              <div class="sm:w-[33%]">
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
              </div>
              <div class="sm:w-[34%]">
                <label
                  class="block text-gray-700 font-bold mb-1 text-start text-[14px]"
                  for="field2"
                >
                  City
                </label>
                <input type="text"
                class="border border-gray-400 rounded-lg py-2 px-4 outline-[#264dd9] focus:shadow-outline w-full"

            />
              </div>
            </div>
          </div>

          <button
            class="bg-blue-500 hover:bg-blue-700 text-white font-bold py-2 px-8 mb-4 mt-4 rounded-full focus:outline-none focus:shadow-outline"
            @click="addJob"
          >
            Submit
          </button>
        </div>
      </div>
    </div>
  </div>
</template>

<script>
import { reactive, ref, watch, onMounted } from "vue";
import { useRouter } from "vue-router";
import axios from "axios";
import apiUrl from "../../api";
import SuccessModal from "../SuccessModal.vue";
import { debounce } from "lodash";
import { State } from "country-state-city";
import { useEmployerStore } from "../../store/employer";

export default {
  components: {
    SuccessModal,
  },
  setup() {
    const store = useEmployerStore();

    const data = reactive({});
    const selectedCountry = ref("");
    const country = ref("");
    const state = ref("");
    const remote = ref(false);
    const skill = ref("");
    const year_of_experience = ref("");
    const employment_type = ref("");
    const short_description = ref("");
    const job_title = ref("");
    const detailed_description = ref("");
    const showSuccessModal = ref(false);
    const remaining = ref(2000);
    const showLogoutModal = ref(false);
    const successMessage = ref("");
    const countries = ref([]);
    const countries_state = ref([]);
    const selectedState = ref("");
    const selectedState_main = ref("");
    const err_country = ref("");
    const err_skill = ref("");
    const err_exp = ref("");
    const err_emp = ref("");
    const err_short = ref("");
    const err_detail = ref("");
    const err_job = ref("");
    const err_remote = ref("");
    const email = ref("");
    const contact_number = ref("");
    const someCountry = ref([]);
    const company_name = ref('');
    const companyurl = ref('');
    const employername = ref('');
    const emailid = ref('');
    const contactno = ref('');
    const city = ref('');

    const empCountry = ref('');
    const empState = ref('');







    someCountry.value = [
      {
        name: "United States",
        isoCode: "US",
      },
      {
        name: "Canada",
        isoCode: "CA",
      },
      {
        name: "United Kingdom",
        isoCode: "GB",
      },
      {
        name: "Australia",
        isoCode: "AU",
      },
      {
        name: "Singapore",
        isoCode: "SG",
      },
      {
        name: "France",
        isoCode: "FR",
      },
      {
        name: "Germany",
        isoCode: "DE",
      },
      {
        name: "China",
        isoCode: "CN",
      },
      {
        name: "India",
        isoCode: "IN",
      },
      {
        name: "Japan",
        isoCode: "JP",
      },
      {
        name: "Saudi Arabia",
        isoCode: "SA",
      },
      {
        name: "Brazil",
        isoCode: "BR",
      },
    ];
    const states = ref([]);



    const router = useRouter();


    const onCountryChange = async () => {
      console.log("selectedCountry.value", selectedCountry.value);
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

    const setSelectedState = async () => {
      console.log(selectedState.value, "selectedState.value");
      const selectedStateObj = states.value.find((statess) => {
        return statess.isoCode == selectedState.value;
      });

      console.log("state.value,selectedStateObj", selectedStateObj);
      selectedState_main.value = JSON.parse(
        JSON.stringify(selectedStateObj)
      ).name;
    };

    const defaultSelectedState = async () => {
      states.value = countries.value ? State.getStatesOfCountry("US") : "";
    };

    const closeSuccessModal = () => {
      showSuccessModal.value = false;
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

    const adminProfile = async () => {
      router.push("/admin-profile");
    };

    const adminLogout = async () => {
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
          `${apiUrl}/admin/logout`,
          null,
          config
        );
        localStorage.removeItem("accessToken");
        if (response.data.message) {
          successMessage.value = response.data.message;
          showLogoutModal.value = true;

          setTimeout(() => {
            router.push("/admin-login");
          }, 1000);
        }

        console.log(response);
      } catch (error) {
        console.log(error);
      }
    };
    const getEmployerDeatails = async () =>{
       const employer_id =  localStorage.getItem('employer_id');
        const response = await axios.post(
          `${apiUrl}/employer-profile`,
          { employer_id },

        );

        company_name.value =  response.data.employer_details.companyname;
        companyurl.value =  response.data.employer_details.companyurl;
        employername.value =  response.data.employer_details.employername;
        emailid.value =  response.data.employer_details.emailid;
        contactno.value =  response.data.employer_details.contactno;
        selectedCountry.value =  response.data.employer_details.country;
        selectedState.value =  response.data.employer_details.state;






    }
    onMounted(() => {
      countries_state.value = someCountry.value;

      getEmployerDeatails();
      fetchCountries();
      defaultSelectedState();
    });

    return {
        company_name,
        companyurl,
        employername,
        emailid,
        contactno,
        empCountry,
        empState,
        city,
      data,
      country,
      state,
      remote,
      skill,
      year_of_experience,
      employment_type,
      short_description,
      detailed_description,
      showSuccessModal,
      closeSuccessModal,
      showLogoutModal,
      successMessage,
      adminLogout,
      adminProfile,
      router,
      remaining,
      job_title,
      countries,
      fetchCountries,
      selectedCountry,
      onCountryChange,
      countries_state,
      selectedState,
      states,
      setSelectedState,
      selectedState_main,
      err_country,
      err_skill,
      err_exp,
      err_emp,
      err_short,
      err_detail,
      err_job,
      err_remote,
      email,
      contact_number,
      defaultSelectedState,
    };
  },
};
</script>

<style></style>
