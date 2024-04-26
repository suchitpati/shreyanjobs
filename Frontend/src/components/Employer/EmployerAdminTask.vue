    <template>
  <div>
    <EmployerNev />

    <div class="bg-[#ebf4ff] py-7 overflow-y-auto">
      <div class="max-w-[1080px] w-full mx-auto px-[20px]">
        <div
          class="text-[#1890da] sm:text-[26px] text-[22px] font-semibold mt-[0px] sm:mb-[0px] mb-[25px] cursor-pointer"
        >
          Admin Task
        </div>
        <span  v-if="sendJobEmailStatus === 'true'" class="text-green-600"
        >Job SEND_NEW_JOB_NOTIFICATION is completed successfully</span
      >

      <span  v-if="batchJobStatus === true"  class="text-green-600"
      >Job SEND_NEW_JOB_NOTIFICATION is Disabled </span
    >
    <span   v-if="batchJobError === true"  class="text-green-600"
    >{{batchJobErrorMessage  }} </span
  >
        <div
          class="bg-[#d3ddff4f] rounded-lg py-4 sm:px-8 px-4 w-full shadow-[rgba(100,_100,_111,_0.2)_0px_0px_10px_0px] hover:shadow-[rgba(100,_100,_111,_0.2)_0px_0px_20px_0px] transition-[.5s]"
        >
          <h2
            class="text-[#1890da] sm:text-[22px] text-[28px] font-semibold mt-[0px] sm:mb-[0px] mb-[25px] text-left"
          >
            Send Email Notification
          </h2>
          <div
              class="w-full flex sm:flex-row flex-col justify-between sm:gap-6 gap-2"
            >
              <div
                class="border border-gray-500 flex justify-between w-full p-4 items-center rounded-lg"
              >
                <div>
                  <p class="font-bold text-[15px] text-gray-800">
                    <!-- {{ job.short_description }} -->
                    <input type="text" v-model="seeker_start_id" class="border border-gray-400 rounded-lg py-2 px-4 " placeholder="Job Seeker Start ID">(Optional)
                  </p>
                </div>
                <div>
                  <p class="font-bold text-[15px] text-gray-800">
                    <!-- {{ job.job_title }} -->
                  </p>
                </div>
                <div>
                  <button
                    class="py-[5px] px-[15px] rounded-full bg-[#3B82F6] text-white font-bold text-[15px]"
                    @click="sendJobEmailNotification()" :disabled="batchJobStatus === true || batchJobError === true"
                  >
                    Send Email Notification
                  </button>
                </div>
              </div>
            </div>
          <!-- <div class="mt-4" v-for="job in jobDetail" :key="job.id">
            <div
              class="w-full flex sm:flex-row flex-col justify-between sm:gap-6 gap-2"
            >
              <div
                class="border border-gray-500 flex justify-between w-full p-4 items-center rounded-lg"
              >
                <div>
                  <p class="font-bold text-[15px] text-gray-800">
                    {{ job.short_description }}
                  </p>
                </div>
                <div>
                  <p class="font-bold text-[15px] text-gray-800">
                    {{ job.job_title }}
                  </p>
                </div>
                <div>
                  <button
                    class="py-[5px] px-[15px] rounded-full bg-[#3B82F6] text-white font-bold text-[15px]"
                    @click="sendJobEmailNotification(job.id)"
                  >
                    Send Email Notification
                  </button>
                </div>
              </div>
            </div>
          </div> -->
        </div>
      </div>
    </div>
    <div class="">
      <FooterPage />
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
import { ref, onMounted } from "vue";
import axios from "axios";
import apiUrl from "../../api";
import EmployerNev from "../Employer/EmployerNavbar.vue";
import FooterPage from "../FooterPage.vue";
import { debounce } from "lodash";

export default {
  components: {
    EmployerNev,
    FooterPage,
  },
  setup() {
    const jobDetail = ref("");
    const isLoading = ref(false);
    const seeker_start_id = ref('');
    const sendJobEmailStatus = ref(false);
    const sendJobMessage = ref(false);

    const batchJobStatus = ref(false);
    const batchJobError = ref(false);
    const batchJobErrorMessage = ref('');


    const getJobEmailNotification = async () => {
      const response = await axios.get(`${apiUrl}/admin-task`);
      jobDetail.value = response.data.JobDetails;
      console.log("response", response.data);
    };

    const checkBatchJobStatus = async () => {
      const response = await axios.get(`${apiUrl}/check-batchJob-status`);

      console.log("response", response.data);
      if(response.data.JobDetails.status == 0)
      {
          batchJobStatus.value = true;
      }
      else
      {
        batchJobStatus.value = false;
      }
    };

    const sendJobEmailNotification = debounce(async () => {
      isLoading.value = true;
      const response = await axios.post(`${apiUrl}/send-notification-email`, {
        'seeker_start_id' : seeker_start_id.value,
      });
      if(response.data.error == 100)
      {
        batchJobErrorMessage.value = response.data.message;
        batchJobError.value = true;
        console.log(response.data.message,'response.data.message');
        isLoading.value = false;

      }
      else
      {
          localStorage.setItem("sendJobEmailStatus", true);
          localStorage.setItem("sendJobMessage", true);

          isLoading.value = false;

          console.log("response", response);
        //   window.location.reload();
      }
    });
    onMounted(() => {
      getJobEmailNotification();
      checkBatchJobStatus();
      sendJobMessage.value = localStorage.getItem("sendJobMessage");
      sendJobEmailStatus.value = localStorage.getItem("sendJobEmailStatus");

      if (sendJobMessage.value && !sendJobEmailStatus.value) {
        localStorage.setItem("sendJobEmailStatus", true);
      }

      if (sendJobMessage.value && sendJobEmailStatus) {
        localStorage.setItem("sendJobEmailStatus", false);
      }



    });

    return {
        batchJobErrorMessage,
        batchJobError,
        batchJobStatus,
        sendJobMessage,
        sendJobEmailStatus,
        seeker_start_id,
      isLoading,
      sendJobEmailNotification,
      jobDetail,
    };
  },
};
</script>

