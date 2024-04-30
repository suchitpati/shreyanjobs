<template>
  <div class="bg-[#eaf4ff]">
    <div class="w-full flex justify-end pt-4 pr-4 pl-4">
      <!-- <div class="sm:w-full xs:w-auto w-[50%]">
        </div> -->
      <img class="w-[150px]" src="../../assets/logo-no-background.png" alt="" />
      <router-link
        to="/"
        class="border-[#1890da] hover:bg-[#f7f7f9] border-[1px] w-max sm:ml-auto text-[#1890da] font-bold md:py-[10px] py-[7px] px-[18px] md:px-[26px] rounded-[26px] focus:outline-none"
        >Home</router-link
      >
    </div>
    <div
      class="p-4 h-[calc(100vh-62px)] flex justify-center flex-col gap-6 items-center overflow-y-auto"
    >
      <div
        class="rounded-lg flex items-center justify-center max-w-[1120px] sm:px-[20px] bg-img w-full"
      >
        <div
          v-if="showSuccessModal"
          class="fixed inset-0 flex items-center justify-center bg-gray-900 bg-opacity-75"
        >
          <div class="bg-white p-8 rounded-lg shadow-lg">
            <h2 class="text-2xl font-bold mb-4">Logged in Successfully!</h2>
            <button
              @click="closeSuccessModal"
              class="bg-blue-500 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded"
            >
              Ok
            </button>
          </div>
        </div>
        <div
        class="w-[50%] md:block hidden shadow-[rgba(100,_100,_111,_0.2)_0px_5px_30px_0px] rounded-lg mr-[10%]"
      >
        <div class="p-[20px_20px_50px_20px]">
          <h5 class="text-2xl underline text-[#1890da] font-bold mb-5">
              <router-link
              to="/seeker-register"
              > Job Seeker registration </router-link>
          </h5>
          <div class="flex py-3">
            <div class="flex">
              <input
                type="checkbox"
                readonly
                checked
                class="accent-[green] w-[20px] h-[20[px]"
              />
              <p class="text-base font-bold ps-2">Search Jobs with advanced filters</p>
            </div>

          </div>
          <div class="flex py-3">
              <div class="flex">
                <input
                  type="checkbox"
                  readonly
                  checked
                  class="accent-[green] w-[20px] h-[20[px]"
                />
                <p class="text-base font-bold ps-2">Apply for jobs with one click</p>
              </div>

            </div>
            <div class="flex py-3">
              <div class="flex">
                <input
                  type="checkbox"
                  readonly
                  checked
                  class="accent-[green] w-[20px] h-[20[px]"
                />
                <p class="text-base font-bold ps-2">Receive New Job Notification in Email</p>
              </div>

            </div>
            <div class="flex py-3">
              <div class="flex">
                <input
                  type="checkbox"
                  readonly
                  checked
                  class="accent-[green] w-[20px] h-[20[px]"
                />
                <p class="text-base font-bold ps-2">Resume visible to all Registered Employers</p>
              </div>

            </div>



        </div>
        <!-- <img src="../../assets/illustration.svg" alt="" class="m-auto mr-0" /> -->
      </div>
        <!-- <div class="w-[50%] md:block hidden">

          <img src="../../assets/illustration.svg" alt="" class="m-auto mr-0" />
        </div> -->
        <div class="md:w-[50%] w-full md:max-w-[100%] max-w-[500px]">
          <div
            class="w-full bg-white rounded-lg py-4 sm:px-8 px-4 lg:ml-[20px] shadow-[rgba(100,_100,_111,_0.2)_0px_5px_30px_0px]"
          >
            <h1
              class="sm:text-[28px] text-[22px] font-bold mt-[20px] sm:mb-[5px] mb-[30px] text-[#1890da]"
            >
              Job Seeker Login
            </h1>
            <div class="flex justify-center gap-[5px]">
              Don't have account ?
              <router-link
                to="/seeker-register"
                class="hover:underline hover:decoration-[#FF0000] text-[#FF0000]"
                >Register here</router-link
              >
            </div>
            <div
              v-if="validationError"
              class="text-red-600 block text-[20px] text-center"
            >
              {{ validationError }}
            </div>
            <div class="mt-4">
              <div class="w-full">
                <label
                  class="block text-gray-700 font-bold mb-1 text-start text-[14px]"
                  for="field2"
                >
                  Email
                </label>
                <input
                  class="border border-gray-400 rounded-lg py-2 px-4 mb-1 outline-[#264dd9] focus:shadow-outline w-full"
                  type="text"
                  id="field1"
                  placeholder="Email"
                  v-model="email"
                />
                <div
                  v-if="emailError"
                  class="text-red-600 block text-[14px] text-left"
                >
                  {{ emailError }}
                </div>
              </div>
              <div class="w-full mt-[10px]">
                <label
                  class="block text-gray-700 font-bold mb-1 text-start text-[14px]"
                  for="field2"
                >
                  Password
                </label>
                <input
                  class="border border-gray-400 rounded-lg py-2 px-4 mb-1 outline-[#264dd9] focus:shadow-outline w-full"
                  type="password"
                  id="field1"
                  placeholder="Password"
                  @keyup.enter="adminPage"
                  v-model="password"
                />
                <div
                  v-if="passwordError"
                  class="text-red-600 block text-[14px] text-left"
                >
                  {{ passwordError }}
                </div>
              </div>
              <button
                class="bg-[#1890da] hover:bg-blue-500 text-white font-bold py-2 px-8 mb-[20px] rounded focus:outline-none focus:shadow-outline mt-[40px]"
                @click="adminPage"
              >
                Sign in
              </button>
              <div class="flex justify-center gap-[5px]">
                Forgot your password?
                <router-link
                  to="/seeker-forgot-password"
                  class="hover:underline hover:decoration-[#FF0000] text-[#FF0000]"
                  >click here</router-link
                >
              </div>
            </div>
          </div>
        </div>
      </div>
    </div>
  </div>
</template>

  <script>
import { reactive, ref } from "vue";
import { useRouter } from "vue-router";
import axios from "axios";
import apiUrl from "../../api";
// import { useSeekerStore } from "../../store/seeker";

export default {
  setup() {
    // const store = useSeekerStore();
    const data = reactive({});

    const email = ref("");
    const emailError = ref("");
    const passwordError = ref("");
    const validationError = ref("");

    const password = ref("");
    const showSuccessModal = ref(false);

    const router = useRouter();
    const route = useRouter();

    const closeSuccessModal = () => {
      showSuccessModal.value = false;
    };

    const adminPage = async () => {
      try {
        console.log(email.value, "email.value");
        if (email.value == null || email.value == "") {
          emailError.value = "Please Enter Email";
          return false;
        } else {
          emailError.value = "";
        }
        if (password.value == null || password.value == "") {
          passwordError.value = "Please Enter Password";
          return false;
        } else {
          passwordError.value = "";
        }

        const response = await axios.post(`${apiUrl}/seeker-login`, {
          email: email.value,
          password: password.value,
        });

        // const result = await store.loginSeeker(formData);

        if (response.data.code == 100) {
          validationError.value = response.data.message;
        } else {
          if (response.data.is_active == 1) {
            localStorage.setItem("seeker_id", response.data.seeker_id);
            localStorage.setItem("is_active", response.data.is_active);
            router.push("/seeker-register");
          } else {
            showSuccessModal.value = true;
            localStorage.setItem("seeker_id", response.data.seeker_id);
            localStorage.setItem("seeker_tocken", response.data.token);

            // Set a timer to remove data after 60 minutes
            setTimeout(() => {
              // Remove data from local storage
              localStorage.removeItem("seeker_id", response.data.seeker_id);
              localStorage.removeItem("seeker_tocken", response.data.token);
              window.location.reload();
            }, 60 * 60 * 1000);

            setTimeout(() => {
              router.push("/");
            }, 1000);
          }
        }
      } catch (error) {
        console.error(error);
      }
    };

    return {
      data,
      adminPage,
      email,
      password,
      showSuccessModal,
      closeSuccessModal,
      router,
      route,
      emailError,
      passwordError,
      validationError,
    };
  },
};
</script>

  <style></style>
