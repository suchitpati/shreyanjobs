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
      <div class="text-[18px] max-w-[1080px] mx-auto"  v-if="employer_role != 1">
        Welcome {{ employername }}
        <br />
        (Employer/ IT Recruiter)
      </div>

      <div class="text-[18px] max-w-[1080px] mx-auto" v-else>
        Welcome {{ employername }}
        <br />
        (Admin)
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
          <div class="underline text-blue-600 text-[14px] cursor-pointer">
            <a
              href="https://shreyanjobs.com/backend/public/easy_job_post/Easy_Job_Posting_Guidelines.pdf"
              target="_blank"
            >
              Download instruction guide on how to use "Easy Job Posting"(PDF
              File)</a
            >
          </div>

          <div
            class="text-[#1890da] sm:text-[22px] text-[22px] font-semibold mt-[0px] sm:mb-[0px] mb-[25px] cursor-pointer underline"
          >
            <router-link to="/employer-job-view"
              >View/ Edit Past Jobs</router-link
            >
          </div>
        </div>

        <div
          class="text-red-600 block text-[14px] text-center"
          v-if="err != ''"
        >
          {{ err }}
        </div>

        <span v-if="addJobMessageStatus === 'true'" class="text-green-600"
          >Your job is posted successfully.</span
        >
        <div
          class="bg-[#d3ddff4f] rounded-lg py-4 sm:px-8 px-4 w-full shadow-[rgba(100,_100,_111,_0.2)_0px_0px_10px_0px] hover:shadow-[rgba(100,_100,_111,_0.2)_0px_0px_20px_0px] transition-[.5s]"
        >
          <div class="flex justify-start gap-2 mb-2" v-if="employer_role != 1">
            <input type="checkbox" v-model="paid" />
            <p class="text-[#1890da]">
              <b>Make it Premium job ($1 Posting fee)</b>
            </p>
          </div>
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
            @click="addEasyJob"
          >
          Preview the job
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
    const job_details1 = ref("");
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
    const err = ref("");
    const email = ref("");
    const job_email = ref("");
    const contact_number1 = ref("");
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
      ////console.log("selectedCountry.value", selectedCountry.value);
      const selectedCountryObj = await countries_state.value.find(
        (countrys) => countrys.isoCode === selectedCountry.value
      );
      ////console.log("selectedCountryObj", selectedCountryObj);

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
      ////console.log(selectedState.value, "selectedState.value");
      const selectedStateObj = states.value.find((statess) => {
        return statess.isoCode == selectedState.value;
      });

      ////console.log("state.value,selectedStateObj", selectedStateObj);
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

    const makePremiumJob = () => {
      paid.value = true;
    };
    const makeFreeJob = () => {
      paid.value = false;
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

    const addEasyJob = async () => {
      const lines = job_details.value.trim().split("\n");
      let currentKey = "";
      let reachedJobDescription = false;

      job_title.value = "";
      city.value = "";
      state.value = "";
      additional_detail.value = "";
      skill.value = "";
      job_email.value = "";
      year_of_experience.value = "";
      contact_number1.value = "";
      technical_skill.value = "";
      job_details1.value = "";
      short_description.value = "";

      lines.forEach((line) => {
        const trimmedLine = line.trim();
        if (trimmedLine.toLowerCase().includes("job description")) {
          reachedJobDescription = true;
        }

        if (!reachedJobDescription && trimmedLine !== "") {
          if (trimmedLine.toLowerCase().includes("email")) {
            //console.log(trimmedLine);
          } else {
            additional_detail.value += trimmedLine + "\n";
          }
        }

        if (trimmedLine.includes(":") && (trimmedLine.toLowerCase().includes("job description") || trimmedLine.toLowerCase().includes("job title") || trimmedLine.toLowerCase().includes("job role") || trimmedLine.toLowerCase().includes("role") || trimmedLine.toLowerCase().includes("title") || trimmedLine.toLowerCase().includes("location") || trimmedLine.toLowerCase().includes("type") || trimmedLine.toLowerCase().includes("job type") || trimmedLine.toLowerCase().includes("employment type") || trimmedLine.toLowerCase().includes("contract type")  || trimmedLine.toLowerCase().includes("skill")  || trimmedLine.toLowerCase().includes("email")  || trimmedLine.toLowerCase().includes("yrs. of exp") ||  trimmedLine.toLowerCase().includes("exp")  ||  trimmedLine.toLowerCase().includes("contact number")  ||  trimmedLine.toLowerCase().includes("employer contact number") )) {
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
            job_title.value = value;
          }
          if (key.toLowerCase().includes("location")) {
            if (value.toLowerCase() == "remote") {
              remote.value = 1;
            } else {
              const [city1, stateAndRest] = value.split(",");
              const state1 = stateAndRest
                ? stateAndRest.trim().slice(0, 2)
                : "";
              //console.log("statestate", state1);
              // result["location"] = `${city.trim()}, ${state}`;
              city.value = city1.trim();
              state.value = state1.trim();
              remote.value = 0;
            }
          }

          if (
            key.toLowerCase().includes("type") ||
            key.toLowerCase().includes("job type") ||
            key.toLowerCase().includes("employment type") ||
            key.toLowerCase().includes("contract type")
          ) {
            if (value.toLowerCase() == "c2c") {
              employment_type.value = "contract-c2c";
            } else if (value.toLowerCase() == "w2") {
              employment_type.value = "contract-w2";
            } else if (value.toLowerCase() == "fulltime") {
              employment_type.value = "fulltime";
            } else if (value.toLowerCase() == "parttime") {
              employment_type.value = "parttime";
            } else {
              employment_type.value = "contract-others";
            }
          }

          if (
            key.toLowerCase().includes("skill") &&
            !key.toLowerCase().includes("technical skill")
          ) {
            skill.value = value;
          }

          if (key.toLowerCase().includes("email")) {
            job_email.value = value;
          }

          if (
            key.toLowerCase().includes("yrs. of exp") ||
            key.toLowerCase().includes("exp")
          ) {
            year_of_experience.value = value;
          }

          if (
            key.toLowerCase().includes("contact number") ||
            key.toLowerCase().includes("employer contact number")
          ) {
            contact_number1.value = value;
          }
        } else if (currentKey) {
          console.log(currentKey, "currentKey");

          if (currentKey.toLowerCase().includes("technical skill")) {
            technical_skill.value += "\n" + trimmedLine;
          }

          if (currentKey.toLowerCase().includes("job description")) {
            job_details1.value += "\n" + trimmedLine;
          }

          //   result[currentKey] += "\n" + trimmedLine;
        }
      });
      console.log(employment_type.value, "employment_typeemployment_type");

      short_description.value =
        job_title.value + " - " + city.value + ", " + state.value;
      if(remote.value == 0)
      {
        short_description.value =
        job_title.value + " - " + city.value + ", " + state.value;
      }
      else
      {
        short_description.value =
        job_title.value + " - Remote";
      }
      if (employment_type.value != "") {
        short_description.value += " - " + employment_type.value;
      }
      const employer_id = localStorage.getItem("employer_id");

      if (job_title.value == "") {
        err.value = "Job Title not found. Please correct and retry. ";
        return false;
      } else {
        err.value = "";
      }

      if (city.value == "" && state.value == "" && remote.value != 1) {
        err.value = "Location not found. Please correct and retry. ";
        return false;
      } else {
        err.value = "";
      }

      if (job_details1.value == "") {
        err.value = "Job Description not found. Please correct and retry. ";
        return false;
      } else {
        err.value = "";
      }

      if (skill.value == "") {
        skill.value = job_title.value;
      }

      if (contact_number1.value == "") {
        contact_number1.value = "";
      }

      year_of_experience.value = year_of_experience.value.replace(/\D/g, "");

      if (year_of_experience.value == "") {
        year_of_experience.value = 7;
      }

      if (job_email.value == "") {
        job_email.value = email.value;
      }
      if (employment_type.value == "") {
        employment_type.value = "contract-others";
      }

      const authToken = localStorage.getItem("employer_tocken");
      country.value = "US";

      if (!authToken) {
        // //console.log("Authentication token is missing.");
        return;
      }

      //   const config = {
      //     headers: {
      //       Authorization: `Bearer ${authToken}`,
      //     },
      //   };
      ////console.log(paid.value,'paidpaidpaidpaid');
      const requestData = {
        employer_id: employer_id.value,
        country: country.value,
        state: state.value,
        city: city.value,
        remote: remote.value,
        skill: skill.value,
        year_of_experience: year_of_experience.value,
        employment_type: employment_type.value,
        short_description: short_description.value,
        detailed_description: job_details1.value,
        job_title: job_title.value,
        email: job_email.value,
        contact_number: contact_number1.value,
        additional_detail: additional_detail.value,
        technical_skill: technical_skill.value,
        paid: paid.value,
        job_owner_id: localStorage.getItem("employer_id"),
      };
      isLoading.value = true;

      localStorage.setItem("job_data", JSON.stringify(requestData));

      router.push({
        name: "employer-easy-post-preview",
      });

      //   const response = await axios.post(
      //     `${apiUrl}/easy-jobs`,
      //     requestData,
      //     config
      //   );
      //   isLoading.value = false;

      //   if (response.data.success == 200) {
      //     setTimeout(() => {
      //       router.push("/employer-job-view");
      //     }, 1000);

      //     // window.location.reload();
      //     // window.scrollTo(0, 0);
      //     localStorage.setItem("addJobMessage", true);
      //     localStorage.setItem("addJobMessageStatus", true);
      //   }

      //   ////console.log(response, "addEasyJob");
    };

    const adminLogout = async () => {
      try {
        const authToken = localStorage.getItem("accessToken");

        if (!authToken) {
          ////console.log("Authentication token is missing.");
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

        ////console.log(response);
      } catch (error) {
        ////console.log(error);
      }
    };

    const getEmployerDeatails = async () => {
      const employer_id = localStorage.getItem("employer_id");

      const authToken = localStorage.getItem("employer_tocken");

      if (!authToken) {
        ////console.log("Authentication token is missing.");
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
      ////console.log("employer_role", employer_role.value);
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
        localStorage.removeItem('job_data');

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

      ////console.log(lastJobPaidStatus.value, "lastJobPaidStatus");
      ////console.log(lastJobFreeStatus.value, "lastJobFreeStatus");

      // countries_state.value = Country.getAllCountries();
      countries_state.value = someCountry.value;

      fetchCountries();
      defaultSelectedState();
      getEmployerDeatails();
    });

    return {
      contact_number1,
      job_details1,
      err,
      addEasyJob,
      lastJobFreeStatus,
      lastJobPaidStatus,
      makePremiumJob,
      paid,
      acct_balance,
      employer_role,
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
      job_email,
      contact_number,
      defaultSelectedState,
      remaining_additional_detail,
      employername,
    };
  },
};
</script>

  <style></style>
