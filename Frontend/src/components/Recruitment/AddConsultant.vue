<template>
  <div>
    <RecruiterNavbar />

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
    <!-- <SeekerNavbar /> -->
    <div class="bg-[#ebf4ff] py-7">
      <div class="max-w-[1080px] w-full mx-auto">
        <div class="text-right bg-[#ebf4ff] text-[18px]">
          Welcome {{ recruiter_name }} <br> (Bench Sales Consultant)
        </div>
      </div>
    </div>

    <div class="bg-[#ebf4ff] py-7">
      <div class="max-w-[1080px] w-full mx-auto px-[20px]">
        <!-- <h1
                      class="text-[#1890da] sm:text-[26px] text-[22px] font-semibold mt-[30px] sm:mb-[40px] mb-[25px]"
                  >
                      Admin Page - Post Job Requirement
                  </h1> -->
        <!-- <span
                    v-if="updateSeekerProfileMessageStatus === 'true'"
                    class="text-green-600"
                    >Profile is updated successfully</span
                > -->
        <div
          v-if="validationError"
          class="text-red-600 block text-[20px] text-center"
        >
          {{ validationError }}
        </div>
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
                  Full Name
                </label>
                <input
                  class="border border-gray-400 rounded-lg py-2 px-4 outline-[#264dd9] focus:shadow-outline w-full"
                  type="text"
                  id="field1"
                  v-model="fullname"
                  placeholder="Full Name"
                />
                <div
                  class="text-red-600 block text-[14px] text-left"
                  v-if="fullnamenameError != ''"
                >
                  {{ fullnamenameError }}
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
              <div class="sm:w-[34%]">
                <label
                  class="block text-gray-700 font-bold mb-1 text-start text-[14px]"
                  for="field2"
                >
                  City
                </label>
                <input
                  type="text"
                  class="border border-gray-400 rounded-lg py-2 px-4 outline-[#264dd9] focus:shadow-outline w-full"
                  v-model="city"
                  placeholder="Enter City"
                />
              </div>
              <div
                class="text-red-600 block text-[14px] text-left"
                v-if="err_city != ''"
              >
                {{ err_city }}
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
                  placeholder="Enter Work authorization"
                />
                <div
                  class="text-red-600 block text-[14px] text-left"
                  v-if="err_work_authorization != ''"
                >
                  {{ err_work_authorization }}
                </div>
              </div>
              <div class="sm:w-[50%] mb-4">
                <label
                  class="block text-gray-700 font-bold mb-1 text-start text-[14px]"
                  for="field1"
                >
                Linkedin URL
                </label>
                <input
                  class="border border-gray-400 rounded-lg py-2 px-4 outline-[#264dd9] focus:shadow-outline w-full"
                  type="text"
                  id="field1"
                  v-model="linkedin_url"
                  placeholder="Enter Linkedin URL"
                />
                <div
                  class="text-red-600 block text-[14px] text-left"
                  v-if="err_linkedin_url != ''"
                >
                  {{ err_linkedin_url }}
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
                  Primary skill
                </label>
                <input
                  class="border border-gray-400 rounded-lg py-2 px-4 outline-[#264dd9] focus:shadow-outline w-full"
                  type="text"
                  id="field1"
                  v-model="primary_skill"
                  placeholder="Enter Primary skill"
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
                  v-model="primary_skill_experience"
                  placeholder="Enter Yrs. Of experience in Secondary skill"
                />
                <div
                  class="text-red-600 block text-[14px] text-left"
                  v-if="err_primary_skill_experience != ''"
                >
                  {{ err_primary_skill_experience }}
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
                  Secondary skill
                </label>
                <input
                  class="border border-gray-400 rounded-lg py-2 px-4 outline-[#264dd9] focus:shadow-outline w-full"
                  type="text"
                  id="field1"
                  v-model="secondary_skill"
                  placeholder="Enter Secondary skill"
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
                  v-model="secondary_skill_experience"
                  placeholder="Enter Yrs. Of experience in Secondary skill"
                />
                <div
                  class="text-red-600 block text-[14px] text-left"
                  v-if="err_secondary_skill_experience != ''"
                >
                  {{ err_secondary_skill_experience }}
                </div>
              </div>
            </div>
            <div
              class="w-full flex sm:flex-row flex-col justify-between sm:gap-6 gap-2"
            >
              <div class="sm:w-[100%] mb-4 flex">
                <label
                  class="block text-gray-700 font-bold mb-1 text-start text-[14px] mr-3"
                  for="field1"
                >
                  OK to Relocate
                </label>
                <input
                  class="border border-gray-400 rounded-lg py-2 px-4 outline-[#264dd9] focus:shadow-outline mr-2"
                  type="checkbox"
                  id="field1"
                  v-model="relocate"
                  :checked="relocate == 1"
                />
              </div>
            </div>
            <div
              class="w-full flex sm:flex-row flex-col justify-between sm:gap-6 gap-2"
            >
              <div class="sm:w-[100%] mb-4">
                <div class="flex text-sm py-1">
                  <b>Upload Resume :</b>
                  <input
                    class="border border-gray-400 rounded-lg py-2 px-4 outline-[#264dd9] focus:shadow-outline w-[80%] ml-3"
                    type="file"
                    id="file"
                    @change="image_details"
                  />
                </div>

                <div
                  class="text-red-600 block text-[14px] text-left"
                  v-if="err_file != ''"
                >
                  {{ err_file }}
                </div>

                <div class="text-xs text-left text-gray-500">
                  ( Only Doc,docx & pdf file extantion are allowed,Files must be
                  less than 3 MB )
                </div>

                <!-- <a href="https://www.shreyanjobs.com/public/pdf/1699523056.pdf" target="_blank">resume</a> -->
              </div>
            </div>
            <button
              class="bg-blue-500 hover:bg-blue-700 text-white font-bold py-2 px-8 mb-4 mt-4 rounded-full focus:outline-none focus:shadow-outline"
              @click="addConsultant"
            >
              Add
            </button>
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
    <div class="">
      <FooterPage />
    </div>
  </div>
</template>

<script>
import { reactive, ref, onMounted } from "vue";
import { useRouter } from "vue-router";
import axios from "axios";
import apiUrl from "../../api";
import SuccessModal from "../SuccessModal.vue";
import { debounce } from "lodash";
import { State } from "country-state-city";
// import SeekerNavbar from "../Seeker/SeekerNavbar.vue";
import RecruiterNavbar from "../Recruitment/RecruiterNavbar.vue";

import FooterPage from "../FooterPage.vue";

export default {
  components: {
    SuccessModal,
    RecruiterNavbar,
    FooterPage,
  },
  setup() {
    const data = reactive({});
    const fullname = ref("");
    const recruiter_name = ref("");
    const work_authorization = ref("");
    const linkedin_url = ref("");
    const primary_skill = ref("");
    const primary_skill_experience = ref("");
    const all_skill = ref([]);
    const secondary_skill = ref("");
    const secondary_skill_experience = ref("");
    const section = ref(1);
    const fullnamenameError = ref("");
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
    const err_city = ref("");
    const err_state = ref("");
    const err_skill = ref("");
    const err_exp = ref("");
    const err_emp = ref("");
    const err_short = ref("");
    const err_detail = ref("");
    const err_job = ref("");
    const err_remote = ref("");
    const someCountry = ref([]);
    const city = ref("");
    const resume = ref("");
    const err_work_authorization = ref("");
    const err_linkedin_url = ref("");


    const err_primary_skill = ref("");
    const err_file = ref("");
    const err_primary_skill_experience = ref("");
    const err_secondary_skill = ref("");
    const err_secondary_skill_experience = ref("");
    const empCountry = ref("");
    const empState = ref("");
    const employernameError = ref("");

    const skillError = ref("");
    const validationError = ref("");

    const relocate = ref(0);
    const file = ref("");
    const isLoading = ref(false);
    const updateSeekerProfileMessage = ref(false);
    const updateSeekerProfileMessageStatus = ref(false);

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
    const image_details = async (event) => {
      file.value = event.target.files[0]; // Get the first selected file
    };
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
      if (selectedState.value != "") {
        const selectedStateObj = states.value.find((statess) => {
          return statess.isoCode == selectedState.value;
        });

        selectedState_main.value = JSON.parse(
          JSON.stringify(selectedStateObj)
        ).name;
      } else {
        selectedState.value = "";
      }
    };

    const defaultSelectedState = async () => {
      console.log(selectedCountry.value, "selectedCountry.value");
      states.value = countries.value
        ? State.getStatesOfCountry("" + selectedCountry.value + "")
        : "";
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

    const fetchRecruiterDetails = async () => {
      const recruiter_id = localStorage.getItem("recruiter_id");

      const recruiterResponse = await axios.post(
        `${apiUrl}/recruiter-details`,
        { id: recruiter_id }
      );
      recruiter_name.value = recruiterResponse.data.recruiter_details.fullname;
      console.log(recruiterResponse, "recruiterResponse");
    };

    const addConsultant = async () => {
      try {
        if (fullname.value == null || fullname.value == "") {
          fullnamenameError.value = "Please Enter Consultant Name";
          return false;
        } else {
          fullnamenameError.value = "";
        }
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
        //   if (contact_number.value == null || contact_number.value == "") {
        //     err_contact_number.value = "The field is required";
        //     return false;
        //   } else {
        //     err_contact_number.value = "";
        //   }
        if (
          work_authorization.value == null ||
          work_authorization.value == ""
        ) {
          err_work_authorization.value =
            "The work authorization field is required";
          return false;
        } else {
          err_work_authorization.value = "";
        }
        if (
            linkedin_url.value == null ||
            linkedin_url.value == ""
        ) {
          err_linkedin_url.value =
            "The Linkedin Url field is required";
          return false;
        } else {
          err_linkedin_url.value = "";
        }
        //   if (total_experience.value == null || total_experience.value == "") {
        //     err_total_experience.value = "The Total Experience field is required";
        //     return false;
        //   } else {
        //     err_total_experience.value = "";
        //   }
        //   if (
        //     parseInt(total_experience.value) < 0 ||
        //     parseInt(total_experience.value) == 0
        //   ) {
        //     err_total_experience.value =
        //       "Please enter Total Experience greater then 0 ";
        //     return false;
        //   } else {
        //     err_total_experience.value = "";
        //   }

        if (primary_skill.value == null || primary_skill.value == "") {
          err_primary_skill.value = "The Primary skill is required";
          return false;
        } else {
          err_primary_skill.value = "";
        }
        if (
          primary_skill_experience.value == null ||
          primary_skill_experience.value == ""
        ) {
          err_primary_skill_experience.value =
            "The primary experience field is required";
          return false;
        } else {
          err_primary_skill_experience.value = "";
        }
        if (
          parseInt(primary_skill_experience.value) < 0 ||
          parseInt(primary_skill_experience.value) == 0
        ) {
          err_primary_skill_experience.value =
            "Please enter primary Experience greater then 0 ";
          return false;
        } else {
          err_primary_skill_experience.value = "";
        }
        if (secondary_skill.value == null || secondary_skill.value == "") {
          err_secondary_skill.value = "The secondary skill field is required";
          return false;
        } else {
          err_secondary_skill.value = "";
        }
        if (
          secondary_skill_experience.value == null ||
          secondary_skill_experience.value == ""
        ) {
          err_secondary_skill_experience.value =
            "The secondary experience field is required";
          return false;
        } else {
          err_secondary_skill_experience.value = "";
        }

        //   if (
        //     parseInt(secondary_experience.value) < 0 ||
        //     parseInt(secondary_experience.value) == 0
        //   ) {
        //     err_secondary_experience.value =
        //       "Please enter secondary Experience greater then 0 ";
        //     return false;
        //   } else {
        //     err_secondary_experience.value = "";
        //   }
        if (file.value == null || file.value == "") {
          err_file.value = "Pleas select file";
          return false;
        } else {
          err_file.value = "";
        }

        if (relocate.value == true) {
          relocate.value = 1;
        }
        const recruiter_id = localStorage.getItem("recruiter_id");

        const formData = new FormData();
        formData.append("fullname", fullname.value);
        formData.append("country", selectedCountry.value);
        formData.append("state", selectedState.value);
        formData.append("city", city.value);
        formData.append("work_authorization", work_authorization.value);
        formData.append("linkedin_url", linkedin_url.value);
        formData.append("relocate", relocate.value ? 1 : 0);
        formData.append("primary_skill", primary_skill.value);
        formData.append("recruiter_id", recruiter_id);

        formData.append(
          "primary_skill_experience",
          primary_skill_experience.value
        );
        formData.append("secondary_skill", secondary_skill.value);
        formData.append(
          "secondary_skill_experience",
          secondary_skill_experience.value
        );
        formData.append("resume", file.value);
        isLoading.value = true;
        const consultantResponse = await axios.post(
          `${apiUrl}/add-Consultants-Details`,
          formData
        );
        isLoading.value = false;

        console.log(consultantResponse.data.error, "asdasd");

        if (consultantResponse.data.error == 100) {
          validationError.value = consultantResponse.data.message;

          return false;
        } else {
            localStorage.setItem("consultantMessageStatus", 1);
          localStorage.setItem("updateConsultantProfileMessage", true);

          localStorage.setItem("updateConsultantProfileMessageStatus", true);
          router.push("/manage-consultant");
        }
        // Handle consultant response data as needed
      } catch (error) {
        // alert("asd");
        console.error(error);
        // Handle error
      }
    };

    function changeSection() {
      if (section.value == 1) {
        section.value = 2;
      } else {
        section.value = 1;
      }
    }
    const backHome = async () => {
      section.value = 1;
    };

    onMounted(() => {
      updateSeekerProfileMessage.value = localStorage.getItem(
        "updateSeekerProfileMessage"
      );
      updateSeekerProfileMessageStatus.value = localStorage.getItem(
        "updateSeekerProfileMessageStatus"
      );

      if (
        updateSeekerProfileMessage.value &&
        !updateSeekerProfileMessageStatus.value
      ) {
        localStorage.setItem("updateSeekerProfileMessageStatus", true);
      }

      if (
        updateSeekerProfileMessage.value &&
        updateSeekerProfileMessageStatus
      ) {
        localStorage.setItem("updateSeekerProfileMessageStatus", false);
      }

      countries_state.value = someCountry.value;

      fetchCountries();
      fetchRecruiterDetails();
    });

    return {
      recruiter_name,
      fetchRecruiterDetails,
      validationError,
      addConsultant,
      updateSeekerProfileMessageStatus,
      updateSeekerProfileMessage,
      isLoading,
      backHome,
      resume,
      image_details,
      relocate,
      err_city,
      skillError,
      all_skill,
      err_file,
      changeSection,
      section,
      fullname,
      work_authorization,
      linkedin_url,
      primary_skill,
      primary_skill_experience,
      secondary_skill,
      secondary_skill_experience,
      employernameError,
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
      err_state,
      err_work_authorization,
      err_linkedin_url,
      err_primary_skill,
      err_primary_skill_experience,
      err_secondary_skill,
      err_secondary_skill_experience,
      defaultSelectedState,
      apiUrl,
      fullnamenameError,
    };
  },
};
</script>

<style></style>
