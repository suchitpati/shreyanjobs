<template>
  <div>
    <!-- Rest of the form content -->
    <div>
      <p class="py-2">
        <!-- Search More Result (Total: {{ totalJobCount }}) -->
      </p>
      <div class="bg-white">
        <div
          class="justify-between flex-wrap max-w-[1080px] w-full sm:px-[20px] px-[16px] sm:grid flex sm:grid-cols-3 mx-auto items-center"
        >
          <div class="sm:w-full xs:w-auto w-[50%] order-1">
            <img
              class="md:w-[230px] w-[150px]"
              src="../assets/image_2023_08_03T09_42_52_417Z.png"
              alt=""
            />
          </div>
          <h1
            class="md:text-[28px] sm:w-full xs:w-auto w-[100%] text-[22px] py-3 font-bold text-[#1890da] xs:order-2 order-3"
          >
            IT jobs Portal
          </h1>
          <div
            class="sm:w-full xs:w-auto w-[50%] xs:order-3 order-2 flex justify-end"
          >
            <button
              class="border-[#1890da] hover:bg-[#f7f7f9] border-[1px] w-max sm:ml-auto text-[#1890da] font-bold md:py-[10px] py-[7px] px-[18px] md:px-[26px] rounded-[26px] focus:outline-none focus:shadow-outline"
              @click="handleButtonClick"
            >
              Login
            </button>
          </div>
        </div>
      </div>
    </div>

    <div class="bg-[linear-gradient(180deg,#f5f4fa,rgba(251,251,253,0))]">
      <div>
        <h1
          class="text-black md:text-[36px] sm:text-[28px] text-[22px] font-bold pt-[40px]"
        >
          Find your dream job now
        </h1>
        <!-- <p class="mt-3 text-[18px]">5 lakh+ jobs for you to explore</p> -->
      </div>

      <div
        class="flex items-center justify-end max-w-[720px] px-[20px] w-full mx-auto md:pt-[40px] pt-5 sm:mb-14 mb-10"
      >
        <div class="flex items-center justify-center sm:mt-4 w-full relative">
          <input
            class="rounded-[40px] md:py-[20px] sm:py-[15px] py-[12px] px-4 sm:pl-[60px] pl-[40px] focus:shadow-outline w-full shadow-[0_25px_60px_rgba(113,106,147,.2)]"
            type="text"
            v-model="searchInput"
            placeholder="Job Search"
            @input="handleSearch"
          />
          <img
            src="../assets/search.svg"
            alt="search"
            class="sm:w-[24px] w-[20px] absolute sm:left-[24px] left-[14px] top-[50%] translate-y-[-50%] opacity-50"
          />
          <!-- <button
            class="bg-blue-700 rounded-[30px] text-white md:p-[10px_30px] sm:p-[7px_20px] p-[5px_14px] absolute md:right-[20px] right-[10px]"
          >
            Search
          </button> -->
        </div>
      </div>

      <div class="max-w-[1080px] w-full px-[20px] mx-auto">
        <!-- Form with two parts -->
        <div
          class="rounded-2xl sm:p-10 p-4 m-auto w-full bg-[#d3ddff4f] sm:mt-6 shadow-[0px_0px_14px_0px_rgba(255,255,255,1);] transition-[.5s]"
        >
          <div
            class="grid md:grid-cols-4 sm:grid-cols-3 xs:grid-cols-2 grid-cols-1 md:gap-6 gap-3 items-center"
          >
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
            <div>
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
              <!-- <div class="w-full">
                  <label
                    class="block text-gray-700 font-bold mb-1 text-start text-[14px]"
                    for="field2"
                  >
                    State
                  </label>
                  <select
                    class="border border-gray-400 rounded-lg bg-white py-2 px-4 outline-[#264dd9] hover:text-[#000] focus:shadow-outline w-full"
                    id="field2"
                    v-model="state"
                    :disabled="remote"
                  >
                    <option value="">State</option>
                    <option value="option1">Option 1</option>
                    <option value="option2">Option 2</option>
                    <option value="option3">Option 3</option>
                  </select>
                </div> -->
            </div>
            <!-- <div class="w-[50%] block items-end gap-3">
                <div>
                  <div class="w-full">
                    <label
                      class="block text-gray-700 font-bold mb-1 text-start text-[14px]"
                      for="field2"
                    >
                      State
                    </label>
                    <select
                      class="border border-gray-400 rounded-lg bg-white py-2 px-4 outline-[#264dd9] hover:bg-[#d4d2d0] hover:text-[#000] focus:shadow-outline w-full"
                      id="field2"
                      v-model="state"
                      :disabled="remote"
                    >
                      <option value="">State</option>
                      <option value="option1">Option 1</option>
                      <option value="option2">Option 2</option>
                      <option value="option3">Option 3</option>
                    </select>
                  </div>
                  <div class="w-[50%] mt-[10px]">
                    <div class="h-[22px] flex items-center gap-2">
                      <input
                        id="check"
                        type="checkbox"
                        v-model="remote"
                        class="w-[20px] h-[20px] border border-gray-400"
                      />
                      <label
                        for="check"
                        class="text-gray-700 font-bold text-start text-[14px]"
                      >
                        {{ remote ? "Remote" : "100% Remote" }}
                      </label>
                    </div>
                  </div>
                </div>
              </div> -->
            <div class="">
              <label
                class="block text-gray-700 font-bold mb-1 text-start text-[14px]"
                for="field2"
              >
                Date Posted
              </label>
              <select
                class="border text-sm rounded-lg bg-white py-2 px-4 outline-[#264dd9] hover:text-[#000] focus:shadow-outline w-full"
                id="field2"
                v-model="datePosted"
                @change="fetchJobs"
              >
                <option value="1">Last 24 Hours</option>
                <option value="3">Last 3 days</option>
                <option value="7">Last 7 days</option>
                <option value="30">Last 30 days</option>
              </select>
            </div>
            <div class="mt-[10px]">
              <div class="h-[22px] flex items-center gap-2">
                <input
                  id="check"
                  type="checkbox"
                  v-model="remote"
                  class="w-[20px] h-[20px] border border-gray-400"
                />
                <label
                  for="check"
                  class="text-gray-700 font-bold text-start text-[14px]"
                >
                  {{ remote ? "Remote" : "100% Remote" }}
                </label>
              </div>
            </div>
            <div class="">
              <label
                class="block text-gray-700 font-bold mb-1 text-start text-[14px]"
                for="field2"
              >
                Employee Type
              </label>
              <select
                class="border text-sm rounded-lg bg-white py-2 px-4 outline-[#264dd9] focus:shadow-outline w-full"
                id="field2"
                v-model="employment_type"
              >
                <option value="0">Select</option>
                <option value="fulltime">Full-time</option>
                <option value="parttime">Part-time</option>
                <option value="third-party contract">Contract</option>
              </select>
            </div>
            <div class="">
              <label
                class="block text-gray-700 font-bold mb-1 text-start text-[14px]"
                for="field1"
              >
                Skill
              </label>
              <input
                class="border text-sm rounded-lg py-2 h-[36px] px-4 outline-[#264dd9] focus:shadow-outline w-full"
                type="text"
                id="field1"
                v-model="skill"
              />
            </div>
            <div class="">
              <label
                class="block text-gray-700 font-bold mb-1 text-start text-[14px]"
                for="field1"
              >
                Min Years of Exp
              </label>
              <input
                class="border text-sm rounded-lg h-[36px] py-2 px-4 outline-[#264dd9] focus:shadow-outline w-full"
                type="number"
                id="field1"
                v-model="year_of_experience"
              />
            </div>
            <div class="w-full flex justify-between gap-6"></div>
          </div>
        </div>

        <div
          class="rounded-lg m-auto w-full shadow-[rgba(100, 100, 111, 0.2) 0px 5px 30px 0px] mt-6"
        >
          <div class="text-start mt-[50px]">
            <h1 class="text-[#414552] text-[20px] font-semibold">
              Search More Result
            </h1>
            <div v-if="jobs.length">
              <div
                v-for="job in jobs"
                :key="job.id"
                class="rounded-[20px] bg-[#d3ddff4f] sm:p-[30px] p-[16px] mt-[20px] shadow-[rgba(100,_100,_111,_0.2)_0px_0px_10px_0px] hover:shadow-[rgba(100,_100,_111,_0.2)_0px_0px_20px_0px] transition-[.5s]"
              >
                <p
                  class="text-[#121224] font-bold hover:underline capitalize text-[18px]"
                >
                  {{ job.job_title }}
                </p>
                <p
                  class="text-[#121224] font-bold hover:underline capitalize text-[18px]"
                >
                  {{ job.short_description }}
                </p>
                <div class="flex items-center gap-1 mt-2">
                  <svg
                    stroke="currentColor"
                    fill="none"
                    stroke-width="2"
                    viewBox="0 0 24 24"
                    stroke-linecap="round"
                    stroke-linejoin="round"
                    height="1em"
                    width="1em"
                    xmlns="http://www.w3.org/2000/svg"
                  >
                    <path stroke="none" d="M0 0h24v24H0z" fill="none"></path>
                    <path
                      d="M21 3l-6.5 18a.55 .55 0 0 1 -1 0l-3.5 -7l-7 -3.5a.55 .55 0 0 1 0 -1l18 -6.5"
                    ></path>
                  </svg>
                  <div class="flex items-center">
                    <!-- <span class="text-gray-500 mr-2">State:</span> -->
                    <span class="text-[#474d6a] capitalize text-[16px]">{{
                      job.country
                    }}</span>
                  </div>
                  ,
                  <h3 class="text-[#474d6a] capitalize text-[16px]">
                    {{ job.state }}
                  </h3>
                </div>
                <div class="flex gap-2 w-full mt-2 flex-wrap">
                  <div
                    class="flex items-center bg-[#fff] py-1 px-2 w-auto whitespace-nowrap rounded"
                  >
                    <span
                      class="text-[#474d6a] font-bold mr-2 flex gap-2 items-center"
                    >
                      <svg
                        stroke="currentColor"
                        fill="currentColor"
                        stroke-width="0"
                        viewBox="0 0 448 512"
                        height="1em"
                        width="1em"
                        xmlns="http://www.w3.org/2000/svg"
                      >
                        <path
                          d="M224 256c70.7 0 128-57.3 128-128S294.7 0 224 0 96 57.3 96 128s57.3 128 128 128zm95.8 32.6L272 480l-32-136 32-56h-96l32 56-32 136-47.8-191.4C56.9 292 0 350.3 0 422.4V464c0 26.5 21.5 48 48 48h352c26.5 0 48-21.5 48-48v-41.6c0-72.1-56.9-130.4-128.2-133.8z"
                        ></path>
                      </svg>
                      Employment Type:
                    </span>
                    <span class="text-[#474d6a]">{{
                      job.employment_type
                    }}</span>
                  </div>
                  <div
                    class="flex items-center bg-[#fff] py-1 px-2 w-auto whitespace-nowrap rounded"
                  >
                    <span
                      class="text-[#474d6a] font-bold mr-2 flex gap-2 items-center"
                    >
                      <svg
                        stroke="currentColor"
                        fill="currentColor"
                        stroke-width="0"
                        viewBox="0 0 512 512"
                        height="1em"
                        width="1em"
                        xmlns="http://www.w3.org/2000/svg"
                      >
                        <path
                          fill="none"
                          stroke-linecap="round"
                          stroke-linejoin="round"
                          stroke-width="32"
                          d="M256 48c-79.5 0-144 61.39-144 137 0 87 96 224.87 131.25 272.49a15.77 15.77 0 0025.5 0C304 409.89 400 272.07 400 185c0-75.61-64.5-137-144-137z"
                        ></path>
                        <circle
                          cx="256"
                          cy="192"
                          r="48"
                          fill="none"
                          stroke-linecap="round"
                          stroke-linejoin="round"
                          stroke-width="32"
                        ></circle>
                      </svg>
                      Remote:
                    </span>
                    <span class="text-[#474d6a]">{{
                      job.remote ? "No" : "Yes"
                    }}</span>
                  </div>
                  <div
                    class="flex items-center bg-[#fff] py-1 px-2 w-auto whitespace-nowrap rounded"
                  >
                    <span
                      class="text-[#474d6a] font-bold mr-2 flex gap-2 items-center"
                    >
                      <svg
                        stroke="currentColor"
                        fill="currentColor"
                        stroke-width="0"
                        viewBox="0 0 16 16"
                        height="1em"
                        width="1em"
                        xmlns="http://www.w3.org/2000/svg"
                      >
                        <path
                          d="M6.5 1A1.5 1.5 0 0 0 5 2.5V3H1.5A1.5 1.5 0 0 0 0 4.5v8A1.5 1.5 0 0 0 1.5 14h13a1.5 1.5 0 0 0 1.5-1.5v-8A1.5 1.5 0 0 0 14.5 3H11v-.5A1.5 1.5 0 0 0 9.5 1h-3zm0 1h3a.5.5 0 0 1 .5.5V3H6v-.5a.5.5 0 0 1 .5-.5zm1.886 6.914L15 7.151V12.5a.5.5 0 0 1-.5.5h-13a.5.5 0 0 1-.5-.5V7.15l6.614 1.764a1.5 1.5 0 0 0 .772 0zM1.5 4h13a.5.5 0 0 1 .5.5v1.616L8.129 7.948a.5.5 0 0 1-.258 0L1 6.116V4.5a.5.5 0 0 1 .5-.5z"
                        ></path>
                      </svg>
                      Years of Experience:
                    </span>
                    <span class="text-[#474d6a]">{{
                      job.year_of_experience
                    }}</span>
                  </div>
                </div>
                <div class="flex items-center mt-2 bg-[#fff] py-1 px-2">
                  <span
                    class="text-[#474d6a] font-bold mr-2 flex gap-2 items-center"
                  >
                    <svg
                      stroke="currentColor"
                      fill="currentColor"
                      stroke-width="0"
                      viewBox="0 0 512 512"
                      height="1em"
                      width="1em"
                      xmlns="http://www.w3.org/2000/svg"
                    >
                      <path
                        d="M119.1 25v.1c-25 3.2-47.1 32-47.1 68.8 0 20.4 7.1 38.4 17.5 50.9L99.7 157 84 159.9c-13.7 2.6-23.8 9.9-32.2 21.5-8.5 11.5-14.9 27.5-19.4 45.8-8.2 33.6-9.9 74.7-10.1 110.5h44l11.9 158.4h96.3L185 337.7h41.9c0-36.2-.3-77.8-7.8-111.7-4-18.5-10.2-34.4-18.7-45.9-8.6-11.4-19.2-18.7-34.5-21l-16-2.5L160 144c10-12.5 16.7-30.2 16.7-50.1 0-39.2-24.8-68.8-52.4-68.8-2.9 0-4.7-.1-5.2-.1zM440 33c-17.2 0-31 13.77-31 31s13.8 31 31 31 31-13.77 31-31-13.8-31-31-31zM311 55v48H208v18h103v158h-55v18h55v110H208v18h103v32h80.8c-.5-2.9-.8-5.9-.8-9 0-3.1.3-6.1.8-9H329V297h62.8c-.5-2.9-.8-5.9-.8-9 0-3.1.3-6.1.8-9H329V73h62.8c-.5-2.92-.8-5.93-.8-9 0-3.07.3-6.08.8-9H311zm129 202c-17.2 0-31 13.8-31 31s13.8 31 31 31 31-13.8 31-31-13.8-31-31-31zm0 160c-17.2 0-31 13.8-31 31s13.8 31 31 31 31-13.8 31-31-13.8-31-31-31z"
                      ></path>
                    </svg>
                    Skill:
                  </span>
                  <span class="text-[#474d6a]">{{ job.skill }}</span>
                </div>
                <!-- <p
                  class="text-gray-700 font-bold bg-[#fff] py-1 px-2 mt-2 capitalize text-[18px]"
                >
                  {{ job.detailed_description }}
                </p> -->
                <p
                  v-if="!expandedJobs.includes(job.id)"
                  class="text-[#474d6a] bg-[#fff] py-1 px-2 mt-2 capitalize text-[14px]"
                >
                  {{ truncateDescription(job.detailed_description, 10) }}
                  <span class="show-more-link" @click="toggleExpand(job.id)"
                    >Show More</span
                  >
                </p>
                <!-- Display full description when job is expanded -->
                <p
                  v-else
                  class="text-[#474d6a] bg-[#fff] py-1 px-2 mt-2 capitalize text-[14px]"
                >
                  {{ job.detailed_description }}
                </p>
                <div class="flex gap-2 items-center px-2 mt-2">
                  <svg
                    stroke="currentColor"
                    fill="currentColor"
                    stroke-width="0"
                    viewBox="0 0 16 16"
                    height="1em"
                    width="1em"
                    xmlns="http://www.w3.org/2000/svg"
                  >
                    <path
                      d="M11 6.5a.5.5 0 0 1 .5-.5h1a.5.5 0 0 1 .5.5v1a.5.5 0 0 1-.5.5h-1a.5.5 0 0 1-.5-.5v-1zm-3 0a.5.5 0 0 1 .5-.5h1a.5.5 0 0 1 .5.5v1a.5.5 0 0 1-.5.5h-1a.5.5 0 0 1-.5-.5v-1zm-5 3a.5.5 0 0 1 .5-.5h1a.5.5 0 0 1 .5.5v1a.5.5 0 0 1-.5.5h-1a.5.5 0 0 1-.5-.5v-1zm3 0a.5.5 0 0 1 .5-.5h1a.5.5 0 0 1 .5.5v1a.5.5 0 0 1-.5.5h-1a.5.5 0 0 1-.5-.5v-1z"
                    ></path>
                    <path
                      d="M3.5 0a.5.5 0 0 1 .5.5V1h8V.5a.5.5 0 0 1 1 0V1h1a2 2 0 0 1 2 2v11a2 2 0 0 1-2 2H2a2 2 0 0 1-2-2V3a2 2 0 0 1 2-2h1V.5a.5.5 0 0 1 .5-.5zM1 4v10a1 1 0 0 0 1 1h12a1 1 0 0 0 1-1V4H1z"
                    ></path>
                  </svg>
                  <p class="text-[14px] text-[#717b9e]">
                    Posted Date {{ formateDate(job.created_at) }}
                    (Total :
                    {{ job.search_count }}

                    <!-- (Job Title Search Count:
                    {{
                      totalJobCountByDay[formateDate(job.created_at)]
                        .byJobTitleSearch || 0
                    }} -->
                    )
                  </p>
                </div>
              </div>
            </div>
            <div v-else>
              <p>No jobs found.</p>
            </div>
          </div>
        </div>
      </div>
    </div>
  </div>
</template>

<script>
import { reactive, ref, watch, onMounted, computed } from "vue";
import { useRouter } from "vue-router";
import apiUrl from "../api";
import { debounce } from "lodash";
import moment from "moment";
import { Country, State } from "country-state-city";

import axios from "axios";

export default {
  setup() {
    const data = reactive({});
    const searchInput = ref("");
    const jobs = ref([]);
    const country = ref("");
    const employment_type = ref("");
    const skill = ref("");
    const state = ref("");
    const year_of_experience = ref("");
    const datePosted = ref("");
    const countries = ref([]);
    const expanded = ref(false);
    const selectedCountry = ref("");
    const states = ref([]);
    const selectedState = ref("");
    const expandedJobs = ref([]);
    const totalJobCount = ref(0);
    const countries_state = ref([]);
    const remote = ref(false);
    const router = useRouter();

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
        // country.value = null;
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

    // const totalJobCount = computed(() => {
    //   const jobCounts = {};

    //   jobs.value.forEach((job) => {
    //     const createdAtDate = moment(job.created_at).format("DD-MM-YYYY");
    //     const jobTitleSearch = searchInput.value.trim().toLowerCase();
    //     const jobTitle = job.job_title.trim().toLowerCase();

    //     if (jobCounts[createdAtDate]) {
    //       jobCounts[createdAtDate].total++;

    //       if (jobTitle.includes(jobTitleSearch)) {
    //         jobCounts[createdAtDate].byJobTitleSearch++;
    //       }
    //     } else {
    //       jobCounts[createdAtDate] = {
    //         total: 1,
    //         byJobTitleSearch: jobTitle.includes(jobTitleSearch) ? 1 : 0,
    //       };
    //     }
    //   });

    //   return Object.values(jobCounts).reduce(
    //     (total, counts) => total + counts.total,
    //     0
    //   );
    // });

    // const jobTitleSearchCountsByDay = computed(() => {
    //   const jobTitleSearch = searchInput.value.trim().toLowerCase();
    //   const countsByDay = {};

    //   jobs.value.forEach((job) => {
    //     const createdAtDate = moment(job.created_at).format("DD-MM-YYYY");
    //     const jobTitle = job.job_title.trim().toLowerCase();

    //     if (!countsByDay[createdAtDate]) {
    //       countsByDay[createdAtDate] = {
    //         total: 0,
    //         byJobTitleSearch: 0,
    //       };
    //     }

    //     countsByDay[createdAtDate].total++;

    //     if (jobTitle.includes(jobTitleSearch)) {
    //       countsByDay[createdAtDate].byJobTitleSearch++;
    //     }
    //   });

    //   return countsByDay;
    // });

    // const totalJobCount = computed(() => jobs.value.length);

    const stringYearOfExperience = computed(() =>
      year_of_experience.value.toString()
    );

    const formateDate = (date) => {
      return moment(date).format("DD-MM-YYYY");
    };

    const truncateDescription = (description, limit) => {
      return description.length > limit
        ? description.slice(0, limit) + "..."
        : description;
    };

    const toggleExpand = (id) => {
      if (expandedJobs.value.includes(id)) {
        expandedJobs.value = expandedJobs.value.filter((jobId) => jobId !== id);
      } else {
        expandedJobs.value.push(id);
      }
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

    const handleButtonClick = () => {
      router.push("/admin-login");
      console.log("click admin");
    };

    const fetchJobs = debounce(async () => {
      try {
        const params = {};

        // if (country.value.trim() !== "") {
        //   params.country = country.value.trim();
        // }

        if (country.value.trim() !== "") {
          params.country = country.value.trim();
        }
        if (employment_type.value.trim() !== "") {
          params.employment_type = employment_type.value.trim();
        }

        if (skill.value.trim() !== "") {
          params.skill = skill.value.trim();
        }

        if (stringYearOfExperience.value.trim() !== "") {
          params.year_of_experience = stringYearOfExperience.value.trim();
        }

        // if (state.value.trim() !== "") {
        //   params.state = state.value.trim();
        // }

        if (state.value.trim() !== "") {
          params.state = state.value.trim();
        }
        if (remote.value) {
          params.remote = true;
        }

        if (searchInput.value.trim() !== "") {
          params.search = searchInput.value.trim();
        }

        if (datePosted.value.trim() !== "") {
          const days = parseInt(datePosted.value, 10);

          if (!isNaN(days) && [1, 3, 7, 30].includes(days)) {
            const startDate = moment()
              .subtract(days, "days")
              .format("YYYY-MM-DD hh:mm:ss");
            params.created_at = startDate;
          }
        }
        const response = await axios.get(`${apiUrl}/admin-jobs`, {
          params,
        });

        jobs.value = response.data;
      } catch (error) {
        console.error(error);
      }
    }, 500);
    watch(
      [
        searchInput,
        country,
        employment_type,
        skill,
        year_of_experience,
        state,
        remote,
        datePosted,
      ],
      () => {
        fetchJobs();
      }
    );

    onMounted(() => {
      countries_state.value = Country.getAllCountries();
      fetchCountries();
      fetchJobs();
    });
    return {
      data,
      countries_state,
      handleButtonClick,
      searchInput,
      fetchJobs,
      jobs,
      country,
      employment_type,
      year_of_experience,
      skill,
      state,
      remote,
      datePosted,
      countries,
      fetchCountries,
      formateDate,
      totalJobCount,
      // totalJobCountByDay,
      truncateDescription,
      // expandDescription,
      expanded,
      selectedCountry,
      states,
      selectedState,
      onCountryChange,
      expandedJobs,
      toggleExpand,
      setSelectedState,
      // jobTitleSearchCountsByDay,
    };
  },
};
</script>

<style>
.show-more-link {
  cursor: pointer;
  color: #625afa;
  font-size: 14px;
  font-weight: 500;
}
.flag-icon {
  width: 1em;
  height: 1em;
  vertical-align: middle;
  background-size: contain;
  background-position: 50%;
  background-repeat: no-repeat;
}
</style>
