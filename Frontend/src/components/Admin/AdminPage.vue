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
    <EmployerNev />
    <div class="text-right pr-[105px] bg-[#ebf4ff] text-[18px]">
      Welcome,{{ employername }}
    </div>

    <div class="bg-[#ebf4ff] py-0 h-[calc(100vh-80px)] overflow-y-auto">
      <div class="max-w-[1080px] w-full mx-auto px-[20px]">
        <h1
          class="text-[#1890da] sm:text-[26px] text-[22px] font-semibold mt-[0px] sm:mb-[0px] mb-[25px]"
        >
          Post a Job         </h1>
        <span  v-if="addJobMessageStatus === 'true'" class="text-green-600"
          >Your job was posted successfully and can be viewed in the home
          page.</span
        >
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
                  for="field2"
                >
                  If this job has multiple locations or you want to specify
                  hybrid/ Day 1 onsite work model, use “Additional Job Position
                  Detail” section below
                </label>

              </div>
            </div>
            <fieldset
              class="border border-gray-400 px-3 pb-[10px] rounded sm:mb-4 mb-7"
            >
              <legend class="text-left ml-4 pl-1 pr-1">Location :</legend>
              <div
                class="w-full flex sm:flex-row flex-col justify-between md:gap-6 gap-3"
              >
                <div class="flex gap-2 items-center pb-4 pt-2">
                  <input
                    id="check"
                    type="checkbox"
                    class="w-[20px] h-[20px] border border-gray-400"
                    :checked="remote"
                    v-model="remote"
                  />
                  <label
                    for="check"
                    class="text-gray-700 font-bold text-start text-[14px]"
                    >Remote</label
                  >
                </div>
              </div>

              <div
                class="w-full flex sm:flex-row flex-col justify-between md:gap-6 gap-3"
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
                <div class="sm:w-[33%]">
                  <label
                    class="block text-gray-700 font-bold mb-1 text-start text-[14px]"
                    for="field2"
                  >
                    City
                  </label>
                  <input
                  :disabled="remote"
                  class="border border-gray-400 rounded-lg py-2 px-4 outline-[#264dd9] focus:shadow-outline w-full"
                  type="text"
                  id="field1"
                  v-model="city"
                  placeholder="Enter City"
                />
                </div>
              </div>
            </fieldset>

            <div
              class="w-full flex sm:flex-row flex-col justify-between sm:gap-6 gap-2"
            >
              <div class="sm:w-[50%] mb-4">
                <label
                  class="block text-gray-700 font-bold mb-1 text-start text-[14px]"
                  for="field2"
                >
                  Employment Type
                </label>
                <select
                  class="border border-gray-400 rounded-lg bg-white py-[10px] px-4 outline-[#264dd9] focus:shadow-outline w-full"
                  id="field2"
                  v-model="employment_type"
                >
                  <option value="">Select</option>
                  <option value="fulltime">Fulltime</option>
                  <option value="parttime">Parttime</option>
                  <option value="contract">Contract</option>
                  <option value="contracttohire">Contract to Hire</option>
                  <!-- <option value="third-party contract">
                                        Third-Party Contract
                                    </option> -->
                </select>
                <div
                  class="text-red-600 block text-[14px] text-left"
                  v-if="err_emp != ''"
                >
                  {{ err_emp }}
                </div>
              </div>

              <div class="sm:w-[50%] mb-4">
                <label
                  class="block text-gray-700 font-bold mb-1 text-start text-[14px]"
                  for="field1"
                >
                  Job Title
                </label>
                <input
                  class="border border-gray-400 rounded-lg py-2 px-4 outline-[#264dd9] focus:shadow-outline w-full"
                  type="text"
                  id="field1"
                  v-model="job_title"
                  placeholder="Enter job Title"
                />
                <div
                  class="text-red-600 block text-[14px] text-left"
                  v-if="err_job != ''"
                >
                  {{ err_job }}
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
                  Skill
                </label>
                <input
                  class="border border-gray-400 rounded-lg py-2 px-4 outline-[#264dd9] focus:shadow-outline w-full"
                  type="text"
                  id="field1"
                  v-model="skill"
                  placeholder="Enter skill"
                />
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
                  Min Years of Exp
                </label>
                <input
                  class="border border-gray-400 rounded-lg py-2 px-4 outline-[#264dd9] focus:shadow-outline w-full"
                  type="number"
                  id="field1"
                  v-model="year_of_experience"
                  placeholder="Enter Experience"
                />
                <div
                  class="text-red-600 block text-[14px] text-left"
                  v-if="err_exp != ''"
                >
                  {{ err_exp }}
                </div>
              </div>
            </div>

            <div
              class="w-full flex sm:flex-row flex-col justify-between sm:gap-6 gap-2"
            >
              <div class="sm:w-[50%] mb-4">
                <label
                  class="block text-gray-700 font-bold mb-1 text-start text-[14px]"
                  for="email"
                >
                  Employer Email
                </label>
                <input
                  class="border border-gray-400 rounded-lg py-2 px-4 outline-[#264dd9] focus:shadow-outline w-full"
                  type="email"
                  id="email"
                  placeholder="Enter Email"
                  v-model="email"
                />
              </div>

              <div class="sm:w-[50%] mb-4">
                <label
                  class="block text-gray-700 font-bold mb-1 text-start text-[14px]"
                  for="contact_number"
                >
                  Employer Contact Number
                </label>
                <input
                  class="border border-gray-400 rounded-lg py-2 px-4 outline-[#264dd9] focus:shadow-outline w-full"
                  type="text"
                  id="contact_number"
                  v-model="contact_number"
                  placeholder="Enter contact number"
                />
              </div>
            </div>
            <div class="sm:w-[calc(50%-15px)] mb-4">
              <label
                class="block text-gray-700 font-bold mb-1 text-start text-[14px]"
                for="short_description"
              >
                Short Description
              </label>
              <input
                class="border border-gray-400 rounded-lg py-2 px-4 outline-[#264dd9] focus:shadow-outline w-full"
                type="text"
                id="short_description"
                v-model="short_description"
                placeholder="Enter short description"
              />
              <div
                class="text-red-600 block text-[14px] text-left"
                v-if="err_short != ''"
              >
                {{ err_short }}
              </div>
            </div>
          </div>
          <div>
            <label
              class="block text-gray-700 font-bold mb-1 text-start text-[14px]"
              for="field2"
              >Additional Job Position Detail (Optional)</label
            >
            <textarea
              class="w-full border border-gray-400 rounded-lg py-2 px-4 outline-[#264dd9] focus:shadow-outline"
              id="textArea1"
              v-model="additional_detail"
              rows="4"
              maxlength="500"
              placeholder="Please specify additional information about the job which could not be provided above such as Multiple job location, contract type (C2C/ W2), Work timing, hybrid/onsite, specific skillset or any other detail."
            >
            </textarea>

            <div class="text-end">
              <span class="text-blue-700 text-[16px]"
                >Characters left: {{ remaining_additional_detail }}/500</span
              >
            </div>
          </div>
          <div>
            <label
              class="block text-gray-700 font-bold mb-1 text-start text-[14px]"
              for="field2"
              >Job Description</label
            >
            <textarea
              class="w-full border border-gray-400 rounded-lg py-2 px-4 outline-[#264dd9] focus:shadow-outline"
              id="textArea1"
              v-model="detailed_description"
              rows="8"
              maxlength="2000"
              placeholder="Enter description"
            >
            </textarea>
            <div
              class="text-red-600 block text-[14px] text-left"
              v-if="err_detail != ''"
            >
              {{ err_detail }}
            </div>

            <div class="text-end">
              <span class="text-blue-700 text-[16px]"
                >Characters left: {{ remaining }}/2000</span
              >
            </div>
          </div>
          <div>
            <label
              class="block text-gray-700 font-bold mb-1 text-start text-[14px]"
              for="field2"
              >Technical skill Requirement (Optional)</label
            >
            <textarea
              class="w-full border border-gray-400 rounded-lg py-2 px-4 outline-[#264dd9] focus:shadow-outline"
              id="textArea1"
              v-model="technical_skill"
              rows="8"
              maxlength="2000"
              placeholder="Enter Technical skill Requirement"
            >
            </textarea>

            <div class="text-end">
              <span class="text-blue-700 text-[16px]"
                >Characters left: {{ remaining_technical_skill }}/2000</span
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
import { reactive, ref, watch, onMounted } from "vue";
import { useRouter } from "vue-router";
import axios from "axios";
import apiUrl from "../../api";
import SuccessModal from "../SuccessModal.vue";
import { debounce } from "lodash";
import { State } from "country-state-city";
import EmployerNev from "../Employer/EmployerNavbar.vue";

export default {
  components: {
    SuccessModal,
    EmployerNev,
  },
  setup() {
    const data = reactive({});
    const selectedCountry = ref("US");
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
    const remaining_additional_detail = ref(500);
    const remaining_technical_skill = ref(2000);
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
    const isLoading = ref(false);
    const additional_detail = ref("");
    const technical_skill = ref("");
    const addJobMessage = ref(false);
    const addJobMessageStatus = ref(false);
    const employername = ref("");
    const city = ref("");

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

    const countryNames = ["Country 1", "Country 2", "Country 3"];

    const stateNames = ["State 1", "State 2", "State 3"];

    const router = useRouter();

    const route = useRouter();

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

    const addJob = async () => {
      if (selectedCountry.value == null || selectedCountry.value == "") {
        err_country.value = "The country field is required";
        return false;
      }

      if (skill.value == null || skill.value == "") {
        err_skill.value = "The skill field is required";
        return false;
      }
      if (year_of_experience.value == null || year_of_experience.value == "") {
        err_exp.value = "The year of experience field is required";
        return false;
      }
      if (employment_type.value == null || employment_type.value == "") {
        err_emp.value = "The employment type field is required";
        return false;
      }
      if (job_title.value == null || job_title.value == "") {
        err_job.value = "The job title field is required";
        return false;
      }
      if (short_description.value == null || short_description.value == "") {
        err_short.value = "The short description field is required";
        return false;
      }
      if (
        detailed_description.value == null ||
        detailed_description.value == ""
      ) {
        err_detail.value = "The detailed description field is required";
        return false;
      }

      const selectedCountryObj = await countries_state.value.find(
        (countrys) => countrys.isoCode === selectedCountry.value
      );

      country.value = selectedCountryObj
        ? JSON.parse(JSON.stringify(selectedCountryObj)).name
        : "";
        // const employer_id = localStorage.getItem("employer_id");

      try {
        const authToken = localStorage.getItem("accessToken");
        const config = {
          headers: {
            Authorization: `Bearer ${authToken}`,
          },
        };
        console.log("");
        const requestData = {
          country: country.value,
          state: selectedState_main.value,
          city: city.value,
          remote: remote.value,
          skill: skill.value,
          year_of_experience: year_of_experience.value,
          employment_type: employment_type.value,
          short_description: short_description.value,
          detailed_description: detailed_description.value,
          job_title: job_title.value,
          email: email.value,
          contact_number: contact_number.value,
          additional_detail: additional_detail.value,
          technical_skill: technical_skill.value,
          job_owner_id : localStorage.getItem("employer_id")
        };
        console.log("requestData", requestData);
        isLoading.value = true;
        const response = await axios.post(
          `${apiUrl}/admin-jobs`,
          requestData,
          config
        );
        console.log(response, "job ===>");
        (country.value = ""),
          (state.value = ""),
          (remote.value = false),
          (skill.value = ""),
          (year_of_experience.value = ""),
          (employment_type.value = ""),
          (short_description.value = ""),
          (detailed_description.value = ""),
          (selectedState.value = ""),
          (selectedCountry.value = ""),
          (selectedState_main.value = ""),
          (job_title.value = "");
        isLoading.value = false;
        // showSuccessModal.value = true;
        window.location.reload();
        // setTimeout(() => {
        // }, 2000);
        localStorage.setItem('addJobMessage',true);
        localStorage.setItem('addJobMessageStatus',true);

      } catch (error) {
        console.error(error.response.data.errors);
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
    const getEmployerDeatails = async () => {
      const employer_id = localStorage.getItem("employer_id");

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
      const response = await axios.post(
        `${apiUrl}/employer-profile`,
        {
          employer_id: employer_id,
        },
        config
      );

      email.value = response.data.employer_details.emailid;
      contact_number.value = response.data.employer_details.contactno;
      employername.value = response.data.employer_details.employername;
    };
    watch(detailed_description, (newValue) => {
      remaining.value = 2000 - newValue.length;
    });

    watch(technical_skill, (newValue) => {
        remaining_technical_skill.value = 2000 - newValue.length;
    });
    watch(additional_detail, (newValue) => {
      if (newValue != null) {
        remaining_additional_detail.value = 500 - newValue.length;
      }
    });
    watch(
      [
        country,
        employment_type,
        skill,
        year_of_experience,
        job_title,
        short_description,
        short_description,
        detailed_description,
        email,
        contact_number,
      ],
      (newValue) => {
        if (newValue != "") {
          (err_emp.value = ""),
            (err_skill.value = ""),
            (err_exp.value = ""),
            (err_job.value = ""),
            (err_short.value = ""),
            (err_detail.value = ""),
            (err_country.value = "");
        }
      }
    );

    onMounted(() => {
        addJobMessage.value = localStorage.getItem('addJobMessage');
        addJobMessageStatus.value = localStorage.getItem('addJobMessageStatus');



        if(addJobMessage.value &&  !addJobMessageStatus.value )
        {
            localStorage.setItem('addJobMessageStatus',true);
        }

        if(addJobMessage.value   && addJobMessageStatus )
        {
            localStorage.setItem('addJobMessageStatus',false);
        }
      // countries_state.value = Country.getAllCountries();
      countries_state.value = someCountry.value;

      fetchCountries();
      defaultSelectedState();
      getEmployerDeatails();
    });

    return {
        addJobMessageStatus,
      city,
      addJobMessage,
      technical_skill,
      additional_detail,
      isLoading,
      getEmployerDeatails,
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
      remaining_technical_skill,
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
      remaining_additional_detail,
      employername,
    };
  },
};
</script>

<style></style>
