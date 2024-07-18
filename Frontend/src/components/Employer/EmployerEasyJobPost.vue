<template>
  <div>
    <SuccessModal v-if="showLogoutModal" :message="successMessage" />
    <div
      v-if="showSuccessModal"
      class="fixed inset-0 flex items-center justify-center bg-gray-900 bg-opacity-75"
    >
      <div class="bg-white p-8 rounded-lg shadow-lg">
        <h2 class="text-2xl font-bold mb-4">Insuficience balance</h2>
        <button
          @click="closeSuccessModal"
          class="bg-blue-500 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded"
        >
          Close
        </button>
      </div>
    </div>
    <EmployerNev />
    <div class="text-right bg-[#ebf4ff]">
      <div class="text-[18px] max-w-[1080px] mx-auto">
        Welcome {{ employername }}
        <br />
        (Employer/ IT Recruiter)
      </div>
    </div>

    <div class="text-right bg-[#ebf4ff]" v-if="employer_role != 1">
      <div class="text-[18px] max-w-[1080px] mx-auto">
        Account Balance : ${{ acct_balance }}
      </div>
    </div>

    <div class="bg-[#ebf4ff] py-0">
      <div class="max-w-[980px] w-full mx-auto px-[20px]">
        <div class="flex justify-between items-center mb-5">
          <h1
            class="text-[#1890da] sm:text-[22px] text-[22px] font-semibold mt-[0px] sm:mb-[0px] mb-[25px]"
          >
            Easy Job Posting
          </h1>
          <div
            class="text-[#1890da] sm:text-[22px] text-[22px] font-semibold mt-[0px] sm:mb-[0px] mb-[25px] cursor-pointer underline"
          >
            <router-link to="/employer-job-view"
              >View/ Edit Past Jobs</router-link
            >
          </div>
        </div>
        <span
          v-if="addJobMessageStatus === 'true' && lastJobPaidStatus === 'true'"
          class="text-green-600"
          >Your job is posted successfully.you can get a list of matching active
          resumes for this job from the Edit Job Page.</span
        >
        <span
          v-if="addJobMessageStatus === 'true' && lastJobFreeStatus === 'true'"
          class="text-green-600"
          >Your job is posted successfully.</span
        >
        <div
          class="bg-[#d3ddff4f] rounded-lg py-4 sm:px-8 px-4 w-full shadow-[rgba(100,_100,_111,_0.2)_0px_0px_10px_0px] hover:shadow-[rgba(100,_100,_111,_0.2)_0px_0px_20px_0px] transition-[.5s]"
        >
          <div>
            <label
              class="block text-gray-700 font-bold mb-1 text-start text-[14px]"
              for="field2"
              >Job Details</label
            >
            <textarea
              class="w-full border border-gray-400 rounded-lg py-2 px-4 outline-[#264dd9] focus:shadow-outline"
              id="textArea1"
              v-model="job_details"
              rows="25"
              maxlength="5000"
              placeholder="Enter Job Details"
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
                >Characters left: {{ remaining }}/5000</span
              >
            </div>
          </div>

          <button
            class="bg-blue-500 hover:bg-blue-700 text-white font-bold py-2 px-8 mb-4 mt-4 rounded-full focus:outline-none focus:shadow-outline"
            @click="extractValues"
          >
            Submit
          </button>
        </div>
      </div>
      <div class="">
        <FooterPage />
      </div>
    </div>
    <div
      class="fixed inset-0 flex items-center justify-center"
      v-if="isLoading"
    >
      <div
        class="animate-spin rounded-full h-16 w-16 border-t-4 border-blue-500"
      ></div>
    </div>
    <div
      class="modal fixed inset-0 bg-gray-800 bg-opacity-50 flex items-center justify-center"
      v-if="confirmModel"
    >
      <div class="bg-white p-8 rounded shadow-lg w-100">
        <p class="mb-1">$1 will be deducted from your account balance.</p>

        <div class="flex justify-end">
          <button
            @click="makeFreeJob"
            class="mr-2 px-4 py-2 bg-gray-500 text-white rounded"
          >
            No,Please post as Free Job
          </button>
          <button
            @click="addJob"
            class="px-4 py-2 bg-green-500 text-white rounded"
          >
            Yes,submit Premium job for $1
          </button>
        </div>
      </div>
    </div>

    <div
      class="modal fixed inset-0 bg-gray-800 bg-opacity-50 flex items-center justify-center"
      v-if="freeJobConfirmModel"
    >
      <div class="bg-white p-8 rounded shadow-lg w-100">
        <p class="mb-1">
          Do you want to post this job with Premium benefits for just $1?
        </p>

        <div class="flex justify-end">
          <button
            @click="addJob"
            class="mr-2 px-4 py-2 bg-gray-500 text-white rounded"
          >
            No, Please post as Free Job
          </button>
          <button
            @click="makePremiumJob"
            class="px-4 py-2 bg-green-500 text-white rounded"
          >
            Yes, submit Premium job for $1
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
import EmployerNev from "./EmployerNavbar.vue";
import FooterPage from "../FooterPage.vue";

export default {
  components: {
    SuccessModal,
    EmployerNev,
    FooterPage,
  },
  setup() {
    const data = reactive({});
    const selectedCountry = ref("US");
    const country = ref("");
    const state = ref("");
    const remote = ref(false);
    const paid = ref(false);
    const skill = ref("");
    const year_of_experience = ref("");
    const employment_type = ref("");
    const short_description = ref("");
    const job_title = ref("");
    const job_details = ref("");
    const showSuccessModal = ref(false);
    const remaining = ref(5000);
    const remaining_additional_detail = ref(500);
    const remaining_technical_skill = ref(5000);
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
    const lastJobPaidStatus = ref(false);
    const lastJobFreeStatus = ref(false);
    const addJobMessageStatus = ref(false);
    const employername = ref("");
    const employer_role = ref("");
    const acct_balance = ref("");

    const city = ref("");
    const confirmModel = ref(false);
    const freeJobConfirmModel = ref(false);

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
      const selectedCountryObj = await countries_state.value.find(
        (countrys) => countrys.isoCode === selectedCountry.value
      );

      country.value = selectedCountryObj
        ? JSON.parse(JSON.stringify(selectedCountryObj)).name
        : "";
      console.log(paid.value, "paid.value");

      if (employer_role.value != 1) {
        if (freeJobConfirmModel.value == true) {
          freeJobConfirmModel.value = false;
        }

        if (confirmModel.value == true) {
          confirmModel.value = false;
        }
      }

      try {
        const authToken = localStorage.getItem("accessToken");
        const config = {
          headers: {
            Authorization: `Bearer ${authToken}`,
          },
        };

        const requestData = {
          country: country.value,
          state: selectedState_main.value,
          city: city.value,
          remote: remote.value,
          skill: skill.value,
          year_of_experience: year_of_experience.value,
          employment_type: employment_type.value,
          short_description: short_description.value,
          job_details: job_details.value,
          job_title: job_title.value,
          email: email.value,
          contact_number: contact_number.value,
          additional_detail: additional_detail.value,
          technical_skill: technical_skill.value,
          paid: paid.value,
          job_owner_id: localStorage.getItem("employer_id"),
        };
        console.log("requestData", requestData);
        isLoading.value = true;
        const response = await axios.post(
          `${apiUrl}/admin-jobs`,
          requestData,
          config
        );
        if (paid.value == true) {
          console.log("paid.value", paid.value);
          localStorage.setItem("lastJobPaidStatus", true);
        } else {
          localStorage.setItem("lastJobFreeStatus", true);
        }
        isLoading.value = false;

        if (response.data.code == 100) {
          showSuccessModal.value = true;
          return false;
        }
        console.log(response, "job ===>");
        (country.value = ""),
          (state.value = ""),
          (remote.value = false),
          (skill.value = ""),
          (year_of_experience.value = ""),
          (employment_type.value = ""),
          (short_description.value = ""),
          (job_details.value = ""),
          (selectedState.value = ""),
          (selectedCountry.value = ""),
          (selectedState_main.value = ""),
          (job_title.value = "");
        window.location.reload();
        window.scrollTo(0, 0);
        // setTimeout(() => {
        // }, 2000);
        localStorage.setItem("addJobMessage", true);
        localStorage.setItem("addJobMessageStatus", true);
      } catch (error) {
        console.error(error.response.data.errors);
      }
    };

    const closeSuccessModal = () => {
      showSuccessModal.value = false;
    };

    const makePremiumJob = () => {
      paid.value = true;
      addJob();
    };
    const makeFreeJob = () => {
      paid.value = false;
      addJob();
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

    const extractValues = async () => {
      const lines = job_details.value.trim().split("\n");
      const result = {};
      let currentKey = "";

      lines.forEach((line) => {
        const trimmedLine = line.trim();
        if (trimmedLine.includes(":")) {
          const [key, value] = trimmedLine
            .split(":")
            .map((part) => part.trim());
          currentKey = key;
          //   result[currentKey.toLowerCase()] = value;
          console.log(key.toLowerCase(), "key");
          if (
            key.toLowerCase().includes("job title") ||
            key.toLowerCase().includes("job role") ||
            key.toLowerCase().includes("role") ||
            key.toLowerCase().includes("title")
          ) {
            result["job_title"] = value;
          }
          if (key.toLowerCase().includes("location")) {
            result["location"] = value;
          }

          if (
            key.toLowerCase().includes("type") ||
            key.toLowerCase().includes("job type") ||
            key.toLowerCase().includes("employment type") ||
            key.toLowerCase().includes("contract type")
          ) {
            result["contract_type"] = value;
          }

          if (key.toLowerCase().includes("visa")) {
            result["visa"] = value;
          }

          if (
            key.toLowerCase().includes("skill") &&
            !key.toLowerCase().includes("technical skill")
          ) {
            result["skill"] = value;
          }

          if (key.toLowerCase().includes("email")) {
            result["email"] = value;
          }

          if (key.toLowerCase().includes("yrs. of exp")  ) {
            result["exp"] = value;
          }

          if (key.toLowerCase().includes("contact number") || key.toLowerCase().includes("employer contact number") ) {
            result["contact_number"] = value;
          }
        } else if (currentKey) {
          console.log(currentKey, "currentKey");

          if (currentKey.toLowerCase().includes("technical skill")) {
            result["technical_skill"] += "\n" + trimmedLine;
          }

          if (currentKey.toLowerCase().includes("job description")) {
            result["job_description"] += "\n" + trimmedLine;
          }

          //   result[currentKey] += "\n" + trimmedLine;
        }
      });

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
        `${apiUrl}/easy-jobs`,
        {
          employer_id: employer_id,
          result: result,
        },
        config
      );

      console.log(response, "extractValues");
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
    const opemConfirmationmodel = async () => {
      console.log("paid.valu", paid.value);
      if (selectedCountry.value == null || selectedCountry.value == "") {
        err_country.value = "The country field is required";
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
      if (skill.value == null || skill.value == "") {
        err_skill.value = "The skill field is required";
        return false;
      }
      if (year_of_experience.value == null || year_of_experience.value == "") {
        err_exp.value = "The year of experience field is required";
        return false;
      }

      if (short_description.value == null || short_description.value == "") {
        err_short.value = "The short description field is required";
        return false;
      }
      if (job_details.value == null || job_details.value == "") {
        err_detail.value = "The detailed description field is required";
        return false;
      }

      if (employer_role.value == 1) {
        addJob();
      } else if (employer_role.value != 1 && paid.value == false) {
        freeJobConfirmModel.value = !freeJobConfirmModel.value;
      } else {
        confirmModel.value = !confirmModel.value;
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
      acct_balance.value = response.data.employer_details.acct_balance;

      employer_role.value = response.data.employer_details.role;
      console.log("employer_role", employer_role.value);
    };
    watch(job_details, (newValue) => {
      remaining.value = 5000 - newValue.length;
    });

    watch(technical_skill, (newValue) => {
      remaining_technical_skill.value = 5000 - newValue.length;
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
        job_details,
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
      addJobMessage.value = localStorage.getItem("addJobMessage");
      addJobMessageStatus.value = localStorage.getItem("addJobMessageStatus");
      lastJobPaidStatus.value = localStorage.getItem("lastJobPaidStatus");
      lastJobFreeStatus.value = localStorage.getItem("lastJobFreeStatus");

      if (addJobMessage.value && !addJobMessageStatus.value) {
        localStorage.setItem("addJobMessageStatus", true);
      }

      if (addJobMessage.value && addJobMessageStatus) {
        localStorage.setItem("addJobMessageStatus", false);
        localStorage.setItem("lastJobPaidStatus", false);
        localStorage.setItem("lastJobFreeStatus", false);
      }

      console.log(lastJobPaidStatus.value, "lastJobPaidStatus");
      console.log(lastJobFreeStatus.value, "lastJobFreeStatus");

      // countries_state.value = Country.getAllCountries();
      countries_state.value = someCountry.value;

      fetchCountries();
      defaultSelectedState();
      getEmployerDeatails();
    });

    return {
      extractValues,
      lastJobFreeStatus,
      lastJobPaidStatus,
      makePremiumJob,
      paid,
      acct_balance,
      employer_role,
      opemConfirmationmodel,
      confirmModel,
      freeJobConfirmModel,
      addJobMessageStatus,
      city,
      addJobMessage,
      technical_skill,
      additional_detail,
      isLoading,
      getEmployerDeatails,
      data,
      addJob,
      makeFreeJob,
      country,
      state,
      remote,
      skill,
      year_of_experience,
      employment_type,
      short_description,
      job_details,
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
