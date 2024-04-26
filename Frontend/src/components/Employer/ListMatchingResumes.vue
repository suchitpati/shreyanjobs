<template>
  <div class="">
    <SuccessModal v-if="showLogoutModal" :message="successMessage" />
    <div
      v-if="showSuccessModal"
      class="fixed inset-0 flex items-center justify-center bg-gray-900 bg-opacity-75"
    >
      <div class="bg-white p-8 rounded-lg shadow-lg">
        <h2 class="text-2xl font-bold mb-4">Insufficient balance</h2>
        <button
          @click="closeSuccessModal"
          class="bg-blue-500 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded"
        >
          Close
        </button>
      </div>
    </div>

    <div
      v-if="showResumeModal"
      class="fixed inset-0 flex items-center justify-center bg-gray-900 bg-opacity-75"
    >
      <div class="bg-white p-8 rounded-lg shadow-lg">
        <h2 class="text-2xl font-bold mb-4">
          Resume is not available for this candidate. Please contact the
          candidate via email/ phone
        </h2>
        <button
          @click="closeResumeErrorModal"
          class="bg-blue-500 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded"
        >
          Close
        </button>
      </div>
    </div>
    <EmployerNev />
    <div class="text-right bg-[#ebf4ff]">
      <div class="text-[18px] max-w-[1080px] mx-auto">
        Welcome,{{ employername }}
      </div>
    </div>

    <div class="text-right bg-[#ebf4ff]" v-if="employer_role != 1">
      <div class="text-[18px] max-w-[1080px] mx-auto">
        Account Balance : ${{ acct_balance }}
      </div>
    </div>

    <div class="bg-[#ebf4ff] py-7">
      <div class="max-w-[1080px] mx-auto px-[20px]">
        <div
          class="bg-[#d3ddff4f] rounded-lg py-4 sm:px-8 px-4 w-full shadow-[rgba(100,_100,_111,_0.2)_0px_0px_10px_0px] hover:shadow-[rgba(100,_100,_111,_0.2)_0px_0px_20px_0px] transition-[.5s]"
        >
          <div class="px-4 sm:px-6 lg:px-8">
            <div class="flex justify-between items-center">
              <h1
                class="text-blue-500 text-lg font-semibold mt-0 mb-4 text-left"
              >
                Matching Active resume list for Job : {{ job_title }}
              </h1>
              <div>
                <button
                  class="bg-green-500 hover:bg-green-700 text-white font-bold py-2 px-4 rounded"
                >
                <router-link  to="/employer-job-view">
                  Back to View/Edit Job</router-link>
                </button>
              </div>
            </div>

            <div v-if="allSeeker.length == 0 && showBlankDiv == false">
              No profile match
            </div>

            <div
              class="grid text-left p-4 mt-2"
              v-for="person in allSeeker"
              :key="person.email"
            >
              <div class="grid grid-cols-5 bg-white p-2">
                <div class="font-bold text-base">
                  Name:
                  <span class="font-normal pl-1">{{ person.fullname }}</span>
                </div>
                <div class="font-bold text-base">
                  Location:
                  <span class="font-normal pl-1">{{
                    person.city + "," + person.state + "," + person.country
                  }}</span>
                </div>
                <div class="font-bold text-base">
                  Ok to Reocate:
                  <span class="font-normal pl-1">
                    {{ person.relocate ? "Yes" : "No" }}</span
                  >
                </div>
                <div class="font-bold text-base">
                  Work Visa:
                  <span class="font-normal pl-1">{{
                    person.work_authorization
                  }}</span>
                </div>
                <div class="font-bold text-base">
                  Last Accessed date :
                  <span class="font-normal pl-1">{{
                    person.last_accessed_date ? person.last_accessed_date : "-"
                  }}</span>
                </div>
              </div>
              <div class="grid grid-cols-4 bg-white p-2">
                <div class="col-span-2">
                  <div class="flex">
                    <p class="font-bold text-base w-[150px]">Primary Skill:</p>
                    <span class="font-normal pl-1">
                      {{ person.primary_skill }}</span
                    >
                  </div>
                </div>
                <div class="font-bold text-base">
                  Yrs of Exp:
                  <span class="font-normal pl-1">{{
                    person.primary_skill_experience
                  }}</span>
                </div>
                <div
                  v-if="!viewContactStatus && contact_id != person.id"
                  @click="openConfirmationmodel(person.id)"
                >
                  <p class="underline cursor-pointer">View Contact Detail</p>
                </div>

                <div v-else-if="contact_id == person.id">
                  <div>{{ email }}(Verified)</div>
                  <div>{{ contact_number }}(Not Verified)</div>
                  <div class="text-[10px] text-[red]">
                    (Contact detail is displayed only once. Write it down for
                    future use.)
                  </div>
                </div>
                <div
                  v-else
                  class="cursor-pointer underline"
                  @click="openConfirmationmodel(person.id)"
                >
                  View Contact Detail
                </div>
              </div>
              <div class="grid grid-cols-4 bg-white p-2">
                <div class="col-span-2">
                  <div class="flex">
                    <p class="font-bold text-base w-[200px]">
                      Secondary Skill:
                    </p>
                    <span class="font-normal pl-1">
                      {{ person.secondary_skill }}</span
                    >
                  </div>
                </div>
                <div class="font-bold text-base">
                  Yrs of Exp:
                  <span class="font-normal pl-1">
                    {{ person.secondary_skill_experience }}</span
                  >
                </div>
                <div
                  v-if="!viewContactStatus && resume_contact_id != person.id"
                  class="cursor-pointer underline"
                  @click="openResumeConfirmationmodel(person.id)"
                >
                  Download Resume
                </div>
                <div
                  v-else-if="resume_contact_id == person.id"
                  class="cursor-pointer underline"
                >
                  <div @click="downloadResume">Download Resume</div>
                </div>
                <div v-else class="cursor-pointer underline">
                  <div
                    class="cursor-pointer"
                    @click="openResumeConfirmationmodel(person.id)"
                  >
                    <a><u>Download Resume</u></a>
                  </div>
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
          <button
            class="mr-2 px-4 py-2 bg-gray-500 text-white rounded"
            @click="closeConfirmationmodel"
          >
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

    <div class="">
      <FooterPage />
    </div>
    <div
      class="modal fixed inset-0 bg-gray-800 bg-opacity-50 flex items-center justify-center"
      v-if="confirmModelResume"
    >
      <div class="bg-white p-8 rounded shadow-lg w-100">
        <p class="mb-1">
          $0.5 will be deducted from your account balance Resume.
        </p>
        <p class="mb-3">Do you want to continue ?</p>

        <div class="flex justify-end">
          <button
            class="mr-2 px-4 py-2 bg-gray-500 text-white rounded"
            @click="closeResumeconfirmModel"
          >
            No
          </button>
          <button
            class="px-4 py-2 bg-green-500 text-white rounded"
            @click="fetchSeeekerResumeDetail"
          >
            Yes
          </button>
        </div>
      </div>
    </div>
  </div>
</template>

  <script>
import { reactive, ref, onMounted, watch } from "vue";
import { useRoute, useRouter } from "vue-router";

import axios from "axios";
import apiUrl from "../../api";
import SuccessModal from "../SuccessModal.vue";
import EmployerNev from "../Employer/EmployerNavbar.vue";
import { debounce } from "lodash";
import { State } from "country-state-city";
// import moment from "moment";
import FooterPage from "../FooterPage.vue";

export default {
  components: {
    SuccessModal,
    EmployerNev,
    FooterPage,
  },
  setup() {
    const route = useRoute();

    const total_experience = ref("");
    const data = reactive({});
    const selectedCountry = ref("");
    const country = ref("");
    const state = ref("");
    const relocate = ref("");
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
    const last_accessed = ref("");
    const acct_balance = ref("");

    const city = ref("");
    const datePosted = ref("");

    const empCountry = ref("");
    const empState = ref("");
    const employernameError = ref("");
    // const last_date = ref("");
    const primary_skill_experience = ref("");
    const secondary_skill_experience = ref("");
    const primary_secondary_skill_experience = ref("");

    const work_visa = ref("");
    const target_id = ref("");
    const confirmModel = ref(false);

    const allSeeker = ref({});
    const viewContactStatus = ref(false);
    const contact_id = ref("");
    const target_resume_id = ref("");
    const confirmModelResume = ref(false);
    const download_resume = ref("");
    const resume_contact_id = ref("");
    const inputStatus = ref(false);
    const fetchJobStatus = ref(false);

    const showBlankDiv = ref(false);
    const showResumeModal = ref(false);
    const employer_role = ref("");

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

    const onCountryChange = async () => {
      const selectedCountryObj = await countries_state.value.find(
        (countrys) => countrys.isoCode === selectedCountry.value
      );
      console.log("selectedCountryObj", selectedCountryObj);

      country.value = selectedCountryObj
        ? JSON.parse(JSON.stringify(selectedCountryObj)).name
        : "";
      states.value = selectedCountryObj
        ? State.getStatesOfCountry(selectedCountryObj.isoCode)
        : "";
      // selectedState.value = "";
      selectedState_main.value = "";
    };

    const setSelectedState = async () => {
      const selectedStateObj = states.value.find((statess) => {
        return statess.isoCode == selectedState.value;
      });

      console.log("state.valueeeeeeeeeee", state.value);
      selectedState_main.value = selectedStateObj
        ? JSON.parse(JSON.stringify(selectedStateObj)).name
        : "";
    };

    const closeSuccessModal = () => {
      showSuccessModal.value = false;
    };

    const employerProfile = async () => {
      router.push("/employer-profile");
    };

    const backToViewEditJob = async () => {
      router.push("/employer-job-view");
    };
    const openConfirmationmodel = async (id) => {
      target_id.value = id;
      if (employer_role.value != 1) {
        confirmModel.value = !confirmModel.value;
      } else {
        fetchSeeekerContactDetail();
      }
    };
    const closeConfirmationmodel = () => {
      confirmModel.value = !confirmModel.value;
    };

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
        if (employer_role.value != 1) {
          confirmModel.value = !confirmModel.value;
        }
        if (response.data.code == 100) {
          showSuccessModal.value = true;
          return false;
        }
        viewContactStatus.value = !viewContactStatus.value;
        email.value = response.data.seeker_details[0].email;
        contact_number.value = response.data.seeker_details[0].contact_number;
        contact_id.value = target_id.value;
        console.log(email.value, "response");
      } catch (error) {
        console.error(error);
      }
    });

    const openResumeConfirmationmodel = async (id) => {
      target_resume_id.value = id;
      if (employer_role.value != 1) {
        confirmModelResume.value = !confirmModelResume.value;
      } else {
        fetchSeeekerResumeDetail();
      }
      console.log(target_resume_id, "target_idtarget_idtarget_idtarget_id");
    };
    const closeResumeconfirmModel = () => {
      confirmModelResume.value = false;
    };
    const downloadResume = async () => {
      const fileName = download_resume.value;
      const fileUrl = `https://shreyanjobs.com/backend/public/pdf/${fileName}`;
      //   const fileUrl = `http://127.0.0.1:8000/pdf/${fileName}`;

      const link = document.createElement("a");
      link.href = fileUrl;
      link.download = fileName;
      link.target = "_blank";

      document.body.appendChild(link);

      link.click();

      document.body.removeChild(link);
    };
    const fetchSeeekerResumeDetail = debounce(async () => {
      try {
        const authToken = localStorage.getItem("employer_tocken");
        const employer_id = localStorage.getItem("employer_id");
        const response = await axios.get(
          `${apiUrl}/seeker-resume-detail/${target_resume_id.value}/${employer_id}`,
          {
            headers: {
              Authorization: `Bearer ${authToken}`,
            },
          }
        );
        if (employer_role.value != 1) {
          confirmModelResume.value = !confirmModelResume.value;
        }
        if (response.data.code == 100) {
          showSuccessModal.value = true;
          return false;
        }
        viewContactStatus.value = !viewContactStatus.value;
        console.log(response, "response");
        if (response.data.status == "not") {
          showResumeModal.value = true;
        } else {
          download_resume.value = response.data.seeker_details[0].resume;
          resume_contact_id.value = target_resume_id.value;

          const fileName = download_resume.value;
          const fileUrl = `https://shreyanjobs.com/backend/public/pdf/${fileName}`;
          // const fileUrl = `http://127.0.0.1:8000/pdf/${fileName}`;

          const link = document.createElement("a");
          link.href = fileUrl;
          link.download = fileName;
          link.target = "_blank";
          document.body.appendChild(link);
          link.click();
          document.body.removeChild(link);
        }
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

      employername.value = response.data.employer_details.employername;
      acct_balance.value = response.data.employer_details.acct_balance;

      employer_role.value = response.data.employer_details.role;
      console.log("employer_role", employer_role.value);
    };

    const closeResumeErrorModal = async () => {
      showResumeModal.value = false;
    };
    const fetchSeeker = debounce(async () => {
      try {
        const job_id = route.params.id;

        console.log(job_id, "job_idjob_idjob_id");
        const authToken = localStorage.getItem("employer_tocken");

        const response = await axios.post(
          `${apiUrl}/list-matching-resumes`,
          {
            job_id: job_id,
          },
          {
            headers: {
              Authorization: `Bearer ${authToken}`,
            },
          }
        );
        allSeeker.value = response.data.seeker_details;
        job_title.value = response.data.job_title;

        console.log(response, "response");
      } catch (error) {
        console.error(error);
      }
    }, 500);
    watch(
      [
        skill,
        primary_skill_experience,
        secondary_skill_experience,
        primary_secondary_skill_experience,
        relocate,
        country,
        state,
        selectedState,
        city,
        work_visa,
        last_accessed,
      ],
      () => {
        fetchSeeker();
      }
    );

    onMounted(() => {
      countries_state.value = someCountry.value;

      fetchSeeker();
      getEmployerDeatails();
    });

    return {
      backToViewEditJob,
      job_title,
      employer_role,
      closeResumeErrorModal,
      showResumeModal,
      showBlankDiv,
      last_accessed,
      primary_secondary_skill_experience,
      fetchJobStatus,
      inputStatus,
      closeConfirmationmodel,
      getEmployerDeatails,
      resume_contact_id,
      downloadResume,
      confirmModelResume,
      download_resume,
      closeResumeconfirmModel,
      target_resume_id,
      fetchSeeekerResumeDetail,
      openResumeConfirmationmodel,
      contact_id,
      viewContactStatus,
      fetchSeeekerContactDetail,
      confirmModel,
      target_id,
      openConfirmationmodel,
      work_visa,
      primary_skill_experience,
      secondary_skill_experience,
      datePosted,
      setSelectedState,
      total_experience,
      addJob,
      fetchSeeker,
      searchInput,
      allSeeker,
      employernameError,
      contactnoError,
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
      relocate,
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
      selectedCountry,
      onCountryChange,
      countries_state,
      selectedState,
      states,
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
      acct_balance,
    };
  },
};
</script>

  <style></style>
