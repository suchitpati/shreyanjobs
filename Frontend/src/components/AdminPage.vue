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
        <h1
          class="text-[#1890da] sm:text-[26px] text-[22px] font-semibold mt-[30px] sm:mb-[40px] mb-[25px]"
        >
          Admin Page - Post Job Requirement
        </h1>
        <div
          class="bg-[#d3ddff4f] rounded-lg py-4 sm:px-8 px-4 w-full shadow-[rgba(100,_100,_111,_0.2)_0px_0px_10px_0px] hover:shadow-[rgba(100,_100,_111,_0.2)_0px_0px_20px_0px] transition-[.5s]"
        >
          <div class="mt-4">
            <div class="w-full flex sm:flex-row flex-col justify-between md:gap-6 gap-3 sm:mb-4 mb-7">
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
                  >
                    <span
                      class="flag-icon flag-icon-{{ country.isoCode.toLowerCase() }} inline-block w-4 h-4 mr-2"
                    ></span>
                    <div class="mr-2">{{ country.flag }}</div>
                    <div>{{ country.name }}</div>
                  </option>
                </select>
              </div>
              <!-- <div class="w-[80%]">
                <label
                  class="block text-gray-700 font-bold mb-1 text-start text-[14px]"
                  for="field2"
                >
                  Country
                </label>
                <select
                  class="border border-gray-400 rounded-lg bg-white py-2 px-4 outline-[#264dd9] focus:shadow-outline w-full"
                  id="field2"
                  v-model="country"
                >
                  <option value="">Select an country</option>
                  <option
                      v-for="country in countries"
                      :key="country.id"
                      :value="country.name"
                    >
                    <div> {{country.emoji}} </div> - {{ country.name }}
                    </option>
                </select>
              </div> -->
              <div class="sm:w-[80%]">
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
                <!-- <label
                  class="block text-gray-700 font-bold mb-1 text-start text-[14px]"
                  for="field2"
                >
                  State
                </label>
                <select
                  class="border border-gray-400 rounded-lg bg-white py-2 px-4 outline-[#264dd9] focus:shadow-outline w-full"
                  id="field2"
                  v-model="state"
                  :disabled="remote"
                >
                  <option value="">Select an state</option>
                  <option
                    v-for="stateName in stateNames"
                    :value="stateName"
                    :key="stateName"
                  >
                    {{ stateName }}
                  </option>
                </select> -->
              </div>
              <div class="sm:w-[25%]">
                <div class="flex gap-2 items-center h-full">
                  <input
                    id="check"
                    type="checkbox"
                    class="w-[20px] h-[20px] border border-gray-400 sm:mt-[18px]"
                    v-model="remote"
                  />
                  <label
                    for="check"
                    class="text-gray-700 font-bold text-start text-[14px] sm:mt-[18px]"
                    >Remote</label
                  >
                </div>
              </div>
            </div>
            <div class="w-full flex sm:flex-row flex-col justify-between sm:gap-6 gap-2">
              <div class="sm:w-[50%]">
                <label
                  class="block text-gray-700 font-bold mb-1 text-start text-[14px]"
                  for="field1"
                >
                  Skill
                </label>
                <input
                  class="border border-gray-400 rounded-lg py-2 px-4 mb-4 outline-[#264dd9] focus:shadow-outline w-full"
                  type="text"
                  id="field1"
                  v-model="skill"
                />
              </div>
              <div class="sm:w-[50%]">
                <label
                  class="block text-gray-700 font-bold mb-1 text-start text-[14px]"
                  for="field1"
                >
                  Min Years of Exp
                </label>
                <input
                  class="border border-gray-400 rounded-lg py-2 px-4 mb-4 outline-[#264dd9] focus:shadow-outline w-full"
                  type="number"
                  id="field1"
                  v-model="year_of_experience"
                />
              </div>
            </div>
            <div class="w-full flex sm:flex-row flex-col justify-between sm:gap-6 gap-2">
              <div class="sm:w-[50%]">
                <label
                  class="block text-gray-700 font-bold mb-1 text-start text-[14px]"
                  for="field2"
                >
                  Employee Type
                </label>
                <select
                  class="border border-gray-400 rounded-lg bg-white py-[10px] px-4 mb-4 outline-[#264dd9] focus:shadow-outline w-full"
                  id="field2"
                  v-model="employment_type"
                >
                  <option value="fulltime">Fulltime</option>
                  <option value="parttime">Parttime</option>
                  <option value="contract">Contract</option>
                  <option value="third-party contract">
                    Third-Party Contract
                  </option>
                </select>
              </div>
              <div class="sm:w-[50%]">
                <label
                  class="block text-gray-700 font-bold mb-1 text-start text-[14px]"
                  for="field1"
                >
                  Job Title
                </label>
                <input
                  class="border border-gray-400 rounded-lg py-2 px-4 mb-4 outline-[#264dd9] focus:shadow-outline w-full"
                  type="text"
                  id="field1"
                  v-model="job_title"
                />
              </div>
            </div>
            <div class="sm:w-[calc(50%-15px)]">
              <label
                class="block text-gray-700 font-bold mb-1 text-start text-[14px]"
                for="field1"
              >
                Short Description
              </label>
              <input
                class="border border-gray-400 rounded-lg py-2 px-4 mb-4 outline-[#264dd9] focus:shadow-outline w-full"
                type="text"
                id="field1"
                v-model="short_description"
              />
            </div>
          </div>
          <div>
            <label
              class="block text-gray-700 font-bold mb-1 text-start text-[14px]"
              for="field2"
              >Detailed Description</label
            >
            <textarea
              class="w-full border border-gray-400 rounded-lg py-2 px-4 outline-[#264dd9] focus:shadow-outline"
              id="textArea1"
              v-model="detailed_description"
              rows="4"
              maxlength="1000"
            >
            </textarea>
            <div class="text-end">
              <span class="text-blue-700 text-[16px]"
                >Characters left: {{ remaining }}/1000</span
              >
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
import apiUrl from "../api";
import SuccessModal from "./SuccessModal.vue";
import { debounce } from "lodash";
import { Country, State } from "country-state-city";

export default {
  components: {
    SuccessModal,
  },
  setup() {
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
    const remaining = ref(1000);
    const showLogoutModal = ref(false);
    const successMessage = ref("");
    const countries = ref([]);
    const countries_state = ref([]);
    const selectedState = ref("");
    const states = ref([]);

    const countryNames = ["Country 1", "Country 2", "Country 3"];

    const stateNames = ["State 1", "State 2", "State 3"];

    const router = useRouter();

    const route = useRouter();

    const onCountryChange = async () => {
      if (selectedCountry.value === "") {
        selectedCountry.value = null;
        country.value = null;
        states.value = [];
        selectedState.value = null;
        return;
      }

      const selectedCountryObj = await countries_state.value.find(
        (countrys) => countrys.isoCode === selectedCountry.value
      );

      if (!selectedCountryObj) {
        selectedCountry.value = null;
        country.value = null;
        states.value = [];
        selectedState.value = null;
        return;
      }

      country.value = JSON.parse(JSON.stringify(selectedCountryObj)).name;
      states.value = State.getStatesOfCountry(selectedCountryObj.isoCode);
      selectedState.value = "";
    };

    const setSelectedState = async () => {
      if (selectedState.value === "") {
        selectedState.value = null;
        country.value = null;
        states.value = [];
        selectedState.value = null;
        return;
      }
      const selectedStateObj = states.value.find((statess) => {
        return statess.isoCode == selectedState.value;
      });

      if (!selectedStateObj) {
        selectedState.value = null;
        // country.value = null;
        states.value = [];
        selectedState.value = null;
        return;
      }
      state.value = JSON.parse(JSON.stringify(selectedStateObj)).name;
    };

    const addJob = async () => {
      try {
        const authToken = localStorage.getItem("accessToken");
        const config = {
          headers: {
            Authorization: `Bearer ${authToken}`,
          },
        };

        const requestData = {
          country: country.value,
          state: state.value,
          remote: remote.value,
          skill: skill.value,
          year_of_experience: year_of_experience.value,
          employment_type: employment_type.value,
          short_description: short_description.value,
          detailed_description: detailed_description.value,
          job_title: job_title.value,
        };
        const response = await axios.post(
          `${apiUrl}/admin-jobs`,
          requestData,
          config
        );

        (country.value = ""),
          (state.value = ""),
          (remote.value = ""),
          (skill.value = ""),
          (year_of_experience.value = ""),
          (employment_type.value = ""),
          (short_description.value = ""),
          (detailed_description.value = ""),
          (selectedState.value = ""),
          (selectedCountry.value = ""),
          (job_title.value = "");
        console.log(response.data, "response");

        showSuccessModal.value = true;
      } catch (error) {
        console.error(error);
      }
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

    watch(detailed_description, (newValue) => {
      remaining.value = 1000 - newValue.length;
    });

    onMounted(() => {
      countries_state.value = Country.getAllCountries();
      fetchCountries();
    });

    return {
      data,
      addJob,
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
      countryNames,
      stateNames,
      adminLogout,
      adminProfile,
      router,
      route,
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
    };
  },
};
</script>

<style></style>
