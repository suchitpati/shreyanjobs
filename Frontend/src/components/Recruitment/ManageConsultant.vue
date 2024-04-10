<template>
  <div>
    <div class="bg-[#ebf4ff] relative">
      <div class="max-w-[1080px] mx-auto px-[20px]">
        <div class=" bg-[#ebf4ff]">

          <RecruiterNavbar />

          <SuccessModal v-if="showLogoutModal" :message="successMessage" />
          <div
            v-if="showSuccessModal"
            class="fixed inset-0 flex items-center justify-center bg-gray-900 bg-opacity-75"
          >
            <div class="bg-white p-8 rounded-lg shadow-lg">
              <h2 class="text-2xl font-bold mb-4">Job Updated Successfully!</h2>
              <button
                @click="closeSuccessModal"
                class="bg-blue-500 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded"
              >
                Close
              </button>
            </div>
          </div>

        </div>
      </div>
    </div>
    <div class="bg-[#ebf4ff]">
      <div class="max-w-[1080px] mx-auto px-[20px]">
        <div class="flex justify-end bg-[#ebf4ff] px-11 py-5">
          <div>
            <p>Welcome Skip 1</p>
            <p>(branch slaes recruter)</p>
          </div>
        </div>
      </div>
    </div>
    <div class="bg-[#ebf4ff] py-7">
      <div class="max-w-[1080px] mx-auto px-[20px]">
        <div class="px-11">
          <div
            class="bg-[#d3ddff4f] rounded-lg py-4 sm:px-8 px-4 w-full shadow-[rgba(100,_100,_111,_0.2)_0px_0px_10px_0px] hover:shadow-[rgba(100,_100,_111,_0.2)_0px_0px_20px_0px] transition-[.5s]"
          >
            <div class="consultant-table p-10">
              <div class="flex justify-between py-2">
                <h2 class="font-bold text-xl">Consultants List</h2>
                <!-- <button
                  class="underline-offset-3 underline text-[15px] text-sky-500 font-bold md:py-[5px] py-[7px] px-[18px] md:px-[15px] mb-2 md:mb-0"
                >
                  Add Consultant
                </button> -->
                <router-link
                  to="/add-consultant"
                  class="hover:underline-offset-3 underline text-[15px] text-sky-500 font-bold md:py-[5px] py-[7px] px-[18px] md:px-[15px] mb-2 md:mb-0"
                  >Add Consultant</router-link
                >
              </div>
              <div>
                <p class="text-red-500 text-start py-2">
                  **inactive consultant will not be listed when appliying for
                  the job and will not searchable by Employer/IT Recruiter
                </p>
              </div>
              <table class="table-auto w-full bg-white">
                <thead>
                  <tr>
                    <th class="px-4 py-2 border border-gray-300">No</th>
                    <th class="px-4 py-2 border border-gray-300">Name</th>
                    <th class="px-4 py-2 border border-gray-300">Location</th>
                    <th class="px-4 py-2 border border-gray-300">
                      Primary Skills
                    </th>
                    <th class="px-4 py-2 border border-gray-300">Status</th>
                    <th class="px-4 py-2 border border-gray-300">Action</th>
                  </tr>
                </thead>
                <tbody v-for="person in allConsultant" :key="person.email">
                  <tr>
                    <td class="px-4 py-2 border border-gray-300">
                      {{ person.id }}
                    </td>
                    <td class="px-4 py-2 border border-gray-300">
                      {{ person.fullname }}
                    </td>
                    <td class="px-4 py-2 border border-gray-300">
                      {{ person.city }},{{ person.state }},{{ person.country }}
                    </td>
                    <td class="px-4 py-2 border border-gray-300">
                      {{ person.primary_skill }}
                    </td>
                    <td class="px-4 py-2 border border-gray-300">{{person.is_active == 1 ? 'Active' : 'Inactive'}}</td>
                    <td class="border border-gray-300 w-[240px]">
                      <div class="flex">
                        <div
                          class="px-4 py-2 border border-transparent border-r-gray-300 w-[80px] text-center underline"
                        >
                        <router-link :to="'/edit-consultant/' + person.id">Edit</router-link>

                        </div>
                        <div
                          class="px-4 py-2 border border-transparent border-r-gray-300 w-[80px] text-center underline"
                        >
                          <a class="cursor-pointer" @click="statusConsultant(person.id)">{{person.is_active != 1  ? 'Active' : 'Inactive'}}</a>
                        </div>
                        <div class="px-4 py-2 w-[80px] underline">

                          <a class="cursor-pointer" @click="deleteConsultant(person.id)">Delete</a>
                        </div>
                      </div>
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
</template>
<script>
import axios from "axios";
import apiUrl from "../../api";
import { ref, onMounted } from "vue";
import { useRouter } from "vue-router";
import RecruiterNavbar from "../Recruitment/RecruiterNavbar.vue";


export default {
    components: {
        RecruiterNavbar
    },
  setup() {
    const router = useRouter();

    const showLogoutModal = ref(false);
    const successMessage = ref("");
    const consultant = ref({});
    const allConsultant = ref({});

    const fetchConsultants = async () => {
      const response = await axios.get(`${apiUrl}/get-all-consultants`);
      allConsultant.value = response.data.consultant_details;
      console.log(response.data.consultant_details, "responseresponseresponse");
    };

    const recruiterLogout = async () => {
      try {
        const authToken = localStorage.getItem("recruiter_tocken");

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
          `${apiUrl}/recruiter-logout`,
          null,
          config
        );
        localStorage.removeItem("recruiter_tocken");
        localStorage.removeItem("recruiter_id");

        if (response.data.message) {
          successMessage.value = response.data.message;
          showLogoutModal.value = true;

          setTimeout(() => {
            router.push("/recruiter-login");
          }, 1000);
        }

        console.log(response);
      } catch (error) {
        console.log(error);
      }
    };
    const deleteConsultant = async (id) => {
        const response = await axios.post(
          `${apiUrl}/delete-Consultants-Details`,
        {
            'id' : id
        });
        window.location.reload();

        console.log(response)
    }

    const statusConsultant = async (id) => {
        const response = await axios.post(
          `${apiUrl}/status-Consultants-Details`,
        {
            'id' : id
        });
        window.location.reload();

        console.log(response)
    }


    const viewJobs = async () => {
      console.log("View Jobs functionality not implemented yet.");
    };

    const showProfileModal = ref(false);
    const closeProfileModal = () => {
      showProfileModal.value = false;
    };

    onMounted(() => {
      fetchConsultants();
    });
    return {
        statusConsultant,
        deleteConsultant,
      recruiterLogout,
      viewJobs,
      showProfileModal,
      closeProfileModal,
      consultant,
      allConsultant,
    };
  },
};
</script>
