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

    <div class="bg-[#ebf4ff] py-7">
      <div class="w-full mx-auto px-[20px]">
        <!-- <h1
                      class="text-[#1890da] sm:text-[26px] text-[22px] font-semibold mt-[30px] sm:mb-[40px] mb-[25px]"
                  >
                      Admin Page - Post Job Requirement
                  </h1> -->
        <div
          class="bg-[#d3ddff4f] rounded-lg py-4 sm:px-8 px-4 w-full shadow-[rgba(100,_100,_111,_0.2)_0px_0px_10px_0px] hover:shadow-[rgba(100,_100,_111,_0.2)_0px_0px_20px_0px] transition-[.5s]"
        >
          <div class="px-4 sm:px-6 lg:px-8">
            <div class="text-center">
              <div class="text-left pl-[180px]">Search Resume</div>
              <div
                class="flex items-center justify-center px-[20px] gap-6 w-[65%] mx-auto md:pt-[28px] pt-5 sm:mb-1 mb-10 md:w-full"
              >
                <div class="flex items-center justify-center w-[40%] relative">
                  <input
                    class="rounded-[40px] md:py-[16px] sm:py-[15px] py-[12px] px-4 sm:pl-[60px] pl-[40px] focus:shadow-outline w-full shadow-[0_25px_60px_rgba(113,106,147,.2)]"
                    type="text"
                    v-model="searchInput"
                    @keyup.enter="fetchSeeker"
                    placeholder="Search resume by name, skill, location"
                  />
                  <!-- @input="handleSearch" -->

                  <img
                    src="../../assets/search.svg"
                    alt="search"
                    class="sm:w-[24px] w-[20px] absolute sm:left-[24px] left-[14px] top-[50%] translate-y-[-50%] opacity-50"
                  />
                </div>
                <button
                  class="bg-blue-700 rounded-[30px] text-white md:p-[13px_30px] sm:p-[7px_20px] p-[5px_14px]"
                  @click="fetchSeeker"
                >
                  Search
                </button>

                <!-- <button
                  class="bg-blue-700 rounded-[30px] text-white md:p-[13px_30px] sm:p-[7px_20px] p-[5px_14px]"
                  @click="addJob"
                >
                Post Job
            </button> -->
              </div>
              <span class="text-[14px] pr-[135px]"
                >Please email to support@shreyanjobs.com to get the contact
                detail &amp; Resume.</span
              >
            </div>
            <div class="mt-8 flow-root">
              <div class="-mx-4 -my-2 overflow-x-auto sm:-mx-6 lg:-mx-8">
                <div
                  class="inline-block min-w-full py-2 align-middle sm:px-6 lg:px-8"
                >
                  <table class="min-w-full divide-y divide-gray-300">
                    <thead>
                      <tr class="divide-x divide-gray-200">
                        <th
                          scope="col"
                          class="py-3.5 pl-4 pr-4 text-left text-sm font-semibold text-gray-900 sm:pl-0"
                        >
                          Name
                        </th>
                        <th
                          scope="col"
                          class="px-4 py-3.5 text-left text-sm font-semibold text-gray-900"
                        >
                          Primary skill
                        </th>
                        <th
                          scope="col"
                          class="px-4 py-3.5 text-left text-sm font-semibold text-gray-900"
                        >
                          Yrs of Exp
                        </th>
                        <th
                          scope="col"
                          class="py-3.5 pl-4 pr-4 text-left text-sm font-semibold text-gray-900 sm:pr-0"
                        >
                          Secondary skill
                        </th>
                        <th
                          scope="col"
                          class="py-3.5 pl-4 pr-4 text-left text-sm font-semibold text-gray-900 sm:pr-0"
                        >
                          Yrs of Exp
                        </th>
                        <th
                          scope="col"
                          class="py-3.5 pl-4 pr-4 text-left text-sm font-semibold text-gray-900 sm:pr-0"
                        >
                          Location
                        </th>
                        <th
                          scope="col"
                          class="py-3.5 pl-4 pr-4 text-left text-sm font-semibold text-gray-900 sm:pr-0"
                        >
                          OK to Relocate
                        </th>
                        <th
                          scope="col"
                          class="py-3.5 pl-4 pr-4 text-left text-sm font-semibold text-gray-900 sm:pr-0"
                        >
                          Work Visa
                        </th>
                        <th
                          scope="col"
                          class="py-3.5 pl-4 pr-4 text-left text-sm font-semibold text-gray-900 sm:pr-0"
                        >
                          Resume & Contact
                        </th>
                        <!-- <th
                          scope="col"
                          class="py-3.5 pl-4 pr-4 text-left text-sm font-semibold text-gray-900 sm:pr-0"
                        >
                          Job Seeker Contact Detail & Resume
                        </th> -->
                      </tr>
                    </thead>
                    <tbody class="divide-y divide-gray-200 bg-white">
                      <tr
                        v-for="person in allSeeker"
                        :key="person.email"
                        class="divide-x divide-gray-200"
                      >
                        <td
                          class="whitespace-nowrap py-4 pl-4 pr-4 text-sm font-medium text-gray-900 sm:pl-0"
                        >
                          {{ person.fullname }}
                        </td>
                        <td class="whitespace-nowrap p-4 text-sm text-gray-500">
                          {{ person.primary_skill }}
                        </td>
                        <td class="whitespace-nowrap p-4 text-sm text-gray-500">
                          {{ person.primary_skill_experience }}
                        </td>
                        <td
                          class="whitespace-nowrap py-4 pl-4 pr-4 text-sm text-gray-500 sm:pr-0"
                        >
                          {{ person.secondary_skill }}
                        </td>
                        <td
                          class="whitespace-nowrap py-4 pl-4 pr-4 text-sm text-gray-500 sm:pr-0"
                        >
                          {{ person.secondary_skill_experience }}
                        </td>
                        <td
                          class="whitespace-nowrap py-4 pl-4 pr-4 text-sm text-gray-500 sm:pr-0"
                        >
                          {{
                            person.city +
                            "," +
                            person.state +
                            "," +
                            person.country
                          }}
                        </td>
                        <td
                          class="whitespace-nowrap py-4 pl-4 pr-4 text-sm text-gray-500 sm:pr-0"
                        >
                          {{ person.relocate ? "Yes" : "No" }}
                        </td>
                        <td
                          class="whitespace-nowrap py-4 pl-4 pr-4 text-sm text-gray-500 sm:pr-0"
                        >
                          {{ person.work_authorization }}
                        </td>
                        <td
                          class="whitespace-nowrap py-4 pl-4 pr-4 text-sm text-gray-500 sm:pr-0"
                        >
                          <div>
                            <div
                                v-if="!viewContactStatus && contact_id != person.id"
                                class="cursor-pointer underline"
                                @click="openConfirmationmodel(person.id)"
                              >
                                View Contact Detail
                              </div>
                            <div v-else-if="contact_id == person.id">
                              <div>{{ email }}</div>
                              <div>{{ contact_number }}</div>
                            </div>
                            <div v-else class="cursor-pointer underline"
                            @click="openConfirmationmodel(person.id)"
                          >
                            View Contact Detail
                          </div>

                          </div>
                          <br />
                          <div class="cursor-pointer">
                            <a><u>View Resume</u></a>
                          </div>
                        </td>
                        <!-- <td
                          class="whitespace-nowrap py-4 pl-4 pr-4 text-sm text-gray-500 sm:pr-0"
                        >
                          {{ person.contact_number }}
                        </td> -->
                      </tr>
                      <tr v-if="allSeeker == null || allSeeker == ''">
                        <td
                          colspan="9"
                          class="whitespace-nowrap py-4 pl-4 pr-4 text-sm font-medium text-gray-900 sm:pl-0"
                        >
                          No Profile match
                        </td>
                      </tr>
                    </tbody>
                  </table>
                </div>
              </div>
            </div>
          </div>
        </div>
      </div>
    </div>
    <div
      class="modal fixed inset-0 bg-gray-800 bg-opacity-50 flex items-center justify-center"
      v-if="confirmModel"
    >
      <div class="bg-white p-8 rounded shadow-lg w-100">
        <p class="mb-1">$0.5 will be deducted from your account balance.</p>
        <p class="mb-3">Do you want to continue ?</p>

        <div class="flex justify-end">
          <button class="mr-2 px-4 py-2 bg-gray-500 text-white rounded">
            No
          </button>
          <button
            class="px-4 py-2 bg-green-500 text-white rounded"
            @click="fetchSeeekerContactDetail"
          >
            Yes
          </button>
        </div>
      </div>
    </div>
  </div>
</template>

  <script>
import { reactive, ref, onMounted } from "vue";
import { useRouter } from "vue-router";
import axios from "axios";
import apiUrl from "../../api";
import SuccessModal from "../SuccessModal.vue";
import EmployerNev from "../Employer/EmployerNavbar.vue";
import { debounce } from "lodash";
import { State } from "country-state-city";

export default {
  components: {
    SuccessModal,
    EmployerNev,
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
    const company_name = ref("");
    const companyurl = ref("");
    const employername = ref("");
    const emailid = ref("");
    const contactno = ref("");
    const contactnoError = ref("");
    const searchInput = ref("");

    const city = ref("");

    const empCountry = ref("");
    const empState = ref("");
    const employernameError = ref("");

    const allSeeker = ref({});

    const confirmModel = ref(false);
    const viewContactStatus = ref(false);
    const contact_id = ref("");
    const target_id = ref("");
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
    const addJob = async () => {
      router.push("/add-job");
    };
    const updateProfile = async () => {
      if (employername.value == null || employername.value == "") {
        employernameError.value = "Enter name";
      } else {
        employernameError.value = "";
      }
      if (contactno.value == null || contactno.value == "") {
        contactnoError.value = "Enter Contact no";
      } else {
        contactnoError.value = "";
      }

      const formData = new FormData();
      formData.append("employername", employername.value);
      formData.append("contactno", contactno.value);
      formData.append("country", selectedCountry.value);
      formData.append("state", selectedState.value);
      formData.append("city", city.value);
      formData.append("employer_id", localStorage.getItem("employer_id"));
      showLogoutModal.value = true;

      await axios
        .post(`${apiUrl}/employer-update-profile`, formData)
        .then((response) => {
          //   countries.value = response.data;
          console.log(response);
          successMessage.value = response.data.message;
          showLogoutModal.value = true;
        })
        .catch((error) => {
          console.error(error);
        });
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

    const employerProfile = async () => {
      router.push("/employer-profile");
    };
    const openConfirmationmodel = async (id) => {

        target_id.value = id;
      confirmModel.value = !confirmModel.value;
    };

    const fetchSeeker = debounce(async () => {
      try {
        const authToken = localStorage.getItem("employer_tocken");

        const formData = new FormData();
        formData.append("searchInput", searchInput.value);
        const response = await axios.post(`${apiUrl}/seeker-all`, formData, {
          headers: {
            Authorization: `Bearer ${authToken}`,
          },
        });

        console.log(response, "response");
        allSeeker.value = response.data.seeker_details;
      } catch (error) {
        console.error(error);
      }
    }, 500);

    const fetchSeeekerContactDetail = debounce(async () => {
      try {
        const authToken = localStorage.getItem("employer_tocken");
        const employer_id = localStorage.getItem("employer_id");

        const formData = new FormData();
        formData.append("searchInput", searchInput.value);
        const response = await axios.get(
          `${apiUrl}/seeker-contact-detail/${target_id.value}/${employer_id}`,
          formData,
          {
            headers: {
              Authorization: `Bearer ${authToken}`,
            },
          }
        );
        viewContactStatus.value = !viewContactStatus.value;
        email.value = response.data.seeker_details[0].email;
        contact_number.value = response.data.seeker_details[0].contact_number;
        confirmModel.value = !confirmModel.value;
        contact_id.value = target_id.value;
        console.log(email.value, "response");
      } catch (error) {
        console.error(error);
      }
    });

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
        { employer_id: employer_id },

        config
      );

      company_name.value = response.data.employer_details.companyname;
      companyurl.value = response.data.employer_details.companyurl;
      employername.value = response.data.employer_details.employername;
      emailid.value = response.data.employer_details.emailid;
      contactno.value = response.data.employer_details.contactno;
      selectedCountry.value = response.data.employer_details.country;
      console.log("selectedCountry", selectedCountry.value);
      selectedState.value = response.data.employer_details.state;

      city.value = response.data.employer_details.city;
      states.value = countries.value
        ? State.getStatesOfCountry(selectedCountry.value)
        : "";
    };
    onMounted(() => {
      countries_state.value = someCountry.value;

      getEmployerDeatails();
      fetchCountries();
      fetchSeeker();
      //   defaultSelectedState();
    });

    return {
        target_id,
      contact_id,
      viewContactStatus,
      fetchSeeekerContactDetail,
      openConfirmationmodel,
      confirmModel,
      addJob,
      fetchSeeker,
      searchInput,
      allSeeker,
      employernameError,
      contactnoError,
      updateProfile,
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
      employerProfile,
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
