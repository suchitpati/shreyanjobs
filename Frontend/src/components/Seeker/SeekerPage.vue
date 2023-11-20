<template>
  <div>
    <!-- Rest of the form content -->
    <div>
      <p class="py-2">
        <!-- Search More Result (Total: {{ totalJobCount }}) -->
      </p>
      <div class="bg-white">
        <div
          class="justify-between flex-wrap max-w-[1080px] w-full sm:px-[20px] px-[16px] sm:grid flex sm:grid-cols-2 mx-auto items-center"
        >
          <div class="sm:w-full xs:w-auto w-[50%] order-1">
            <img
              class="md:w-[230px] w-[150px]"
              src="../../assets/logo-no-background.png"
              alt=""
            />
          </div>
          <!-- <h1
                        class="md:text-[28px] sm:w-full xs:w-auto w-[100%] text-[22px] py-3 font-bold text-[#1890da] xs:order-2 order-3"
                    >
                        IT jobs Portal
                    </h1> -->
          <div
            v-if="isEmployerLogged == true"
            class="sm:w-full xs:w-auto w-[50%] xs:order-3 order-2 flex justify-end gap-[10px]"
          >
            <router-link to="/employer-dashboard">
              <button
                class="border-[#1890da] hover:bg-[#f7f7f9] border-[1px] w-max sm:ml-auto text-[#1890da] font-bold md:py-[10px] py-[7px] px-[18px] md:px-[26px] rounded-[26px] focus:outline-none focus:shadow-outline"
              >
                Dashboard
              </button>
            </router-link>
          </div>
          <div
            v-if="isSeekerLogged == true"
            class="sm:w-full xs:w-auto w-[50%] xs:order-3 order-2 flex justify-end gap-[10px]"
          >
            <router-link to="/seeker-profile">
              <button
                class="border-[#1890da] hover:bg-[#f7f7f9] border-[1px] w-max sm:ml-auto text-[#1890da] font-bold md:py-[10px] py-[7px] px-[18px] md:px-[26px] rounded-[26px] focus:outline-none focus:shadow-outline"
              >
                Profile
              </button>
            </router-link>
            <button
              @click="seekerLogout"
              class="border-[#1890da] hover:bg-[#f7f7f9] border-[1px] w-max text-[#1890da] font-bold md:py-[10px] py-[7px] px-[18px] md:px-[26px] rounded-[26px] focus:outline-none focus:shadow-outline"
            >
              Logout
            </button>
          </div>
          <div
            v-if="isSeekerLogged == false && isEmployerLogged == false"
            class="sm:w-full xs:w-auto w-[50%] xs:order-3 order-2 flex justify-end gap-[10px]"
          >
            <router-link to="/employer-login">
              <button
                class="border-[#1890da] hover:bg-[#f7f7f9] border-[1px] w-max sm:ml-auto text-[#1890da] font-bold md:py-[10px] py-[7px] px-[18px] md:px-[26px] rounded-[26px] focus:outline-none focus:shadow-outline"
              >
                <span>Post</span>
                Job
              </button>
            </router-link>
            <router-link to="/employer-login">
              <button
                class="border-[#1890da] hover:bg-[#f7f7f9] border-[1px] w-max sm:ml-auto text-[#1890da] font-bold md:py-[10px] py-[7px] px-[18px] md:px-[26px] rounded-[26px] focus:outline-none focus:shadow-outline"
              >
                <span>Employer</span>
                Login
              </button>
            </router-link>
            <router-link to="/seeker-login">
              <button
                class="border-[#1890da] hover:bg-[#f7f7f9] border-[1px] w-max sm:ml-auto text-[#1890da] font-bold md:py-[10px] py-[7px] px-[18px] md:px-[26px] rounded-[26px] focus:outline-none focus:shadow-outline"
              >
                Job Seeker Login
              </button>
            </router-link>
          </div>
        </div>
      </div>
    </div>

    <div
      class="bg-[linear-gradient(180deg,#f5f4fa,rgba(251,251,253,0))] h-[10px]"
    ></div>

    <div class="bg-white">
      <div
        class="flex items-center max-w-[1080px] px-[20px] gap-6 w-[65%] mx-auto p-5 justify-center sm:mb-1 mb-10 md:w-full"
      >
        <div class="flex items-center justify-center w-[29%] relative">
          <input
            class="rounded-[40px] md:py-[16px] sm:py-[15px] py-[12px] px-4 sm:pl-[60px] pl-[40px] focus:shadow-outline w-full shadow-[0_25px_60px_rgba(113,106,147,.2)]"
            type="text"
            v-model="searchInput"
            @keyup.enter="fetchJobs"
            placeholder="Search jobs by skill of job Role"
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
          @click="fetchJobs"
        >
          Search
        </button>
      </div>
    </div>
<div class="max-w-[1080px] text-[12px] w-full m-auto text-right pr-3">
    <div>For any issue in accessing shreyanjobs.com </div>
    <div>please email to support@shreyanjobs.com</div>
</div>
    <div class="bg-[linear-gradient(180deg,#f5f4fa,rgba(251,251,253,0))]">
      <div>
        <!-- <h1
                    class="text-black md:text-[36px] sm:text-[28px] text-[22px] font-bold pt-[40px]"
                >
                    Find your dream job now
                </h1> -->
        <!-- <p class="mt-3 text-[18px]">5 lakh+ jobs for you to explore</p> -->
      </div>

      <div
        class="rounded-2xl p-4 sm:p-7 top-[10px] m-auto max-w-[1080px] w-full bg-[#d3ddff4f] shadow-[0px_0px_14px_0px_rgba(255,255,255,1);] transition-[.5s]"
      >
        <div
          class="grid grid-cols-7 md:gap-4 gap-3 max-w-[1200px] m-auto items-center"
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
                <!-- <div class="mr-2">{{ country.flag }}</div> -->
                <div>{{ country.name }}</div>
              </option>
            </select>
          </div>
          <div class="">
            <div class="flex justify-between">
              <div>
                <label
                  class="block text-gray-700 font-bold mb-1 text-start text-[14px]"
                  for="field2"
                >
                  State
                </label>
              </div>
            </div>
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
          </div>
          <div class="h-[22px] flex items-center gap-2 mt-[30px]">
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
              100% Remote
              <!-- {{ remote ? "Remote" : "100% Remote" }} -->
            </label>
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
              <option value="">Select</option>
              <option value="fulltime">Full-time</option>
              <option value="parttime">Part-time</option>
              <option value="contract">Contract</option>
              <option value="contract">Contract Hire</option>
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
              <option value="">Date Posted</option>

              <option value="1">Last 24 Hours</option>
              <option value="3">Last 3 days</option>
              <option value="7">Last 7 days</option>
              <option value="30">Last 30 days</option>
            </select>
          </div>

          <!-- <div>
                        <label
                            class="block text-blue-500 font-bold mb-1 text-start text-[14px] cursor-pointer"
                            for="field1"
                            @click="handleButtonClick"
                        >
                            Admin? login
                        </label>
                    </div> -->
          <div class="w-full flex justify-between gap-6"></div>
        </div>
      </div>
      <div class="max-w-[1080px] gap-6 w-full px-[20px] mx-auto">
        <!-- Form with two parts -->

        <div
          class="rounded-lg m-auto w-full shadow-[rgba(100, 100, 111, 0.2) 0px 5px 30px 0px] mt-6"
        >
          <div class="text-start">
            <h1 class="text-[#414552] text-[20px] font-semibold">
              Job Search Result
            </h1>
            <div v-if="jobStatus == false">
              <p>Waiting for job listing</p>
            </div>
            <div v-if="jobs.length">
              <div
                v-for="job in jobs"
                :key="job.id"
                class="rounded-[20px] bg-[#d3ddff4f] sm:p-[30px] sm:pt-[12px] p-[16px] mt-[20px] shadow-[rgba(100,_100,_111,_0.2)_0px_0px_10px_0px] hover:shadow-[rgba(100,_100,_111,_0.2)_0px_0px_20px_0px] transition-[.5s]"
              >
                <!-- <p
                  class="text-[#121224] font-bold hover:underline capitalize text-[14px]"
                >
                  {{ job.job_title }}
                </p> -->
                <div class="flex gap-[10px]">
                  <div class="grow">
                    <p
                      class="text-[#121224] font-bold hover:underline capitalize text-[17px]"
                    >
                      {{ job.short_description }}
                    </p>
                    <div class="flex items-center gap-4 mt-2">
                      <div class="flex gap-1 items-center">
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
                          <path
                            stroke="none"
                            d="M0 0h24v24H0z"
                            fill="none"
                          ></path>
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
                        <!-- <div v-if="job.state">,</div> -->
                        <h3 class="text-[#474d6a] capitalize text-[16px]">
                          <div v-if="job.remote == 1">(Remote)</div>
                          <div v-else-if="job.remote == 0 && job.state">
                            ,{{ job.state }}
                          </div>
                          <div v-else></div>

                          <!-- {{ job.remote == 1 ? ",Remote" : ","+job.state }} -->
                        </h3>
                      </div>
                      <div class="flex gap-1 items-center">
                       <span class="text-[#474d6a] font-bold flex gap-2 items-center text-[14px]">Job Title :</span>
                       <span class="text-[#474d6a]">Network Architect</span>
                      </div>
                    </div>
                    <div class="flex items-center">
                      <span
                        class="text-[#474d6a] font-bold mr-2 flex gap-2 items-center text-[14px]"
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
                    <div class="flex gap-2 w-full flex-wrap">
                      <div
                        class="flex items-center w-auto whitespace-nowrap rounded"
                      >
                        <span
                          class="text-[#474d6a] font-bold mr-2 flex gap-2 items-center text-[14px]"
                        >
                          <svg
                            version="1.0"
                            xmlns="http://www.w3.org/2000/svg"
                            width="1.7em"
                            height="1.7em"
                            viewBox="0 0 1920.000000 1597.000000"
                            preserveAspectRatio="xMidYMid meet"
                          >
                            <g
                              transform="translate(0.000000,1597.000000) scale(0.100000,-0.100000)"
                              fill="#000000"
                              stroke="none"
                            >
                              <path
                                d="M4120 12000 c-254 -30 -476 -143 -660 -336 -142 -149 -226 -310 -278
                                             -529 -15 -64 -16 -332 -19 -3080 -3 -2053 0 -3041 7 -3109 29 -271 136 -494
                                             328 -678 161 -155 335 -245 557 -289 101 -20 10985 -21 11085 -1 218 44 402
                                             138 556 284 160 152 259 327 317 558 l21 85 4 2990 c2 2147 0 3025 -8 3113
                                             -25 279 -133 506 -328 694 -102 97 -169 144 -295 203 -106 50 -216 81 -337 95
                                             -102 12 -10851 11 -10950 0z m10993 -484 c37 -10 66 -22 65 -27 -2 -4 -181
                                             -163 -398 -351 -217 -189 -739 -642 -1160 -1008 -421 -365 -1037 -901 -1370
                                             -1190 -333 -289 -832 -723 -1110 -964 -278 -242 -736 -640 -1018 -885 -283
                                             -245 -517 -446 -522 -446 -4 0 -221 187 -481 416 -261 229 -888 780 -1394
                                             1224 -506 445 -1046 919 -1200 1055 -154 135 -559 491 -900 791 -341 299 -833
                                             731 -1092 959 -319 280 -468 417 -459 422 7 4 42 11 77 16 38 6 2231 9 5479 8
                                             5268 -1 5417 -2 5483 -20z m-10853 -814 c1724 -1514 2589 -2273 3030 -2661
                                             272 -238 499 -437 503 -441 4 -4 -124 -93 -285 -198 -161 -105 -1092 -715
                                             -2068 -1355 -976 -640 -1778 -1161 -1783 -1157 -4 3 -11 40 -17 81 -13 103
                                             -13 5930 0 6024 11 74 47 195 58 195 4 0 257 -219 562 -488z m11284 373 c14
                                             -53 16 -383 16 -3086 0 -1665 -3 -3041 -6 -3058 -4 -17 -10 -31 -14 -31 -4 0
                                             -157 99 -341 219 -184 121 -505 332 -714 469 -2047 1341 -3055 2006 -3053
                                             2012 2 5 285 253 629 552 841 730 1683 1462 2139 1858 206 179 586 510 844
                                             734 258 224 472 404 477 399 4 -4 15 -35 23 -68z m-6658 -4436 c388 -341 708
                                             -619 713 -619 4 0 329 279 722 621 393 341 719 623 725 626 12 4 162 -93 1639
                                             -1062 920 -604 1017 -668 1899 -1245 366 -239 665 -439 666 -443 0 -11 -94
                                             -51 -160 -68 -78 -20 -10895 -21 -10978 -1 -59 13 -152 51 -152 61 1 11 4204
                                             2760 4213 2754 5 -3 326 -284 713 -624z"
                              />
                            </g>
                          </svg>
                          Employer Email & Contact :
                        </span>

                        <span
                          v-if="isEmployerLogged || isSeekerLogged"
                          class="text-[#474d6a]"
                          >{{ job.email ? job.email : "-" }}</span
                        >
                        <span v-else class="text-[#474d6a] underline">
                          <router-link to="/seeker-login">
                            Login as Job seeker to View
                          </router-link>
                        </span>
                      </div>

                      <!-- <div
                                              class="flex items-center bg-[#fff] py-1 px-2 w-auto whitespace-nowrap rounded"
                                          >
                                              <span
                                                  class="text-[#474d6a] font-bold mr-2 flex gap-2 items-center text-[14px]"
                                              >
                                                  <svg
                                                      version="1.0"
                                                      xmlns="http://www.w3.org/2000/svg"
                                                      width="1.4em"
                                                      height="1.4em"
                                                      viewBox="0 0 512.000000 512.000000"
                                                      preserveAspectRatio="xMidYMid meet"
                                                  >
                                                      <g
                                                          transform="translate(0.000000,512.000000) scale(0.100000,-0.100000)"
                                                          fill="#000000"
                                                          stroke="none"
                                                      >
                                                          <path
                                                              d="M1265 4327 c-173 -58 -321 -188 -400 -352 -72 -148 -80 -191 -80
                         -415 1 -164 4 -211 23 -299 228 -1046 1400 -2216 2459 -2453 133 -30 451 -33
                         553 -5 221 61 383 195 478 395 35 74 37 82 37 182 0 93 -3 112 -26 161 -15 31
                         -44 75 -65 99 -21 23 -173 136 -337 251 -321 224 -369 249 -482 249 -102 0
                         -230 -56 -293 -128 -13 -15 -53 -69 -88 -119 -36 -51 -67 -93 -70 -93 -7 0
                         -144 100 -224 164 -271 217 -601 549 -811 816 -46 59 -139 189 -139 194 0 2
                         50 39 111 82 127 89 178 151 209 252 25 82 25 153 0 235 -17 53 -59 121 -229
                         364 -115 164 -228 316 -251 337 -70 63 -140 90 -245 93 -56 2 -105 -2 -130
                         -10z"
                                                          />
                                                      </g>
                                                  </svg>
                                                  Employer Contact
                                              </span>
                                              <span class="text-[#474d6a]">{{
                                                  job.contact_number
                                                      ? job.contact_number
                                                      : "-"
                                              }}</span>
                                          </div> -->
                    </div>
                  </div>
                  <div class="flex-wrap">
                    <div class="flex items-center justify-end">
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
                      <p class="text-[14px] text-[#717b9e] ml-[5px]">
                        Posted Date :
                        {{ formateDate(job.created_at) }}
                      </p>
                    </div>
                    <div class="flex gap-[10px] mt-[10px]">
                      <div
                        class="flex items-center py-1 px-2 w-auto whitespace-nowrap rounded "
                      >
                        <span
                          class="text-[#474d6a] font-bold mr-2 flex gap-2 items-center text-[14px]"
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
                        <span
                          class="text-[#474d6a]"
                          v-if="job.employment_type == 'contracttohire'"
                          >Contract To Hire</span
                        >
                        <span
                          class="text-[#474d6a]"
                          v-if="job.employment_type == 'parttime'"
                          >Part Time</span
                        >
                        <span
                          class="text-[#474d6a]"
                          v-if="job.employment_type == 'fulltime'"
                          >Full Time</span
                        >
                        <span
                          class="text-[#474d6a]"
                          v-if="job.employment_type == 'contract'"
                          >Contract</span
                        >
                      </div>
                      <!-- <div
                                        class="flex items-center bg-[#fff] py-1 px-2 w-auto whitespace-nowrap rounded"
                                    >
                                        <span
                                            class="text-[#474d6a] font-bold mr-2 flex gap-2 items-center text-[14px]"
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
                                            job.remote ? "Yes" : "No"
                                        }}</span>
                                    </div> -->
                    </div>
                    <div
                      class="flex items-center py-1 px-2 w-auto whitespace-nowrap rounded  mt-2"
                    >
                      <span
                        class="text-[#474d6a] font-bold mr-2 flex gap-2 items-center text-[14px]"
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
                        Yrs of Exp:
                      </span>
                      <span class="text-[#474d6a]">{{
                        job.year_of_experience
                      }}</span>
                    </div>
                  </div>
                </div>

                <div
                  v-if="!expandedJobs.includes(job.id)"
                  class="text-[#474d6a] bg-[#fff] py-1 px-2 mt-2 capitalize text-[14px]"
                >
                  <div
                    v-for="(point, index) in getTruncatedPoints(
                      job.detailed_description.slice(0, 100),
                      50
                    )"
                    :key="index"
                  >
                    {{ point }}
                  </div>
                  <span class="show-more-link" @click="toggleExpand(job.id)"
                    >Show More</span
                  >
                </div>
                <!-- Display full description when job is expanded -->
                <div
                  v-else
                  class="text-[#474d6a] bg-[#fff] py-1 px-2 mt-2 capitalize text-[14px]"
                >
                  <div style="white-space: pre-wrap">
                    {{ job.detailed_description }}
                  </div>
                </div>
                <!-- Display full description when job is expanded -->
                <!-- <div
                                    v-else
                                    class="text-[#474d6a] bg-[#fff] py-1 px-2 mt-2 capitalize text-[14px]"
                                >
                                    {{ job.detailed_description }}
                                </div> -->
                <div class="flex gap-2 items-center px-2 mt-2">
                  <p class="text-[14px] text-[#717b9e]">
                    <!-- Posted Date
                                        {{ formateDate(job.created_at) }} -->

                    (Searched for
                    {{ job.search_count }} times )
                  </p>
                </div>
              </div>
            </div>
            <div v-if="jobs.length == 0 && jobStatus == true">
              <p>No job Found</p>
            </div>
          </div>
        </div>
      </div>
    </div>
    <div
      v-if="showSuccessSubscrber"
      class="fixed inset-0 flex items-center justify-center bg-gray-900 bg-opacity-75"
    >
      <div class="bg-white p-8 rounded-lg shadow-lg">
        <h2 class="text-2xl font-bold mb-4">Thank you for your subscription</h2>
        <button
          @click="closeSuccessSubscrber"
          class="bg-blue-500 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded"
        >
          Ok
        </button>
      </div>
    </div>

    <div
      v-if="showOtpModel"
      class="fixed inset-0 flex items-center justify-center bg-gray-900 bg-opacity-75"
    >
      <div class="absolute right-[41%] top-[34.5%]" @click="closeOtpModel">
        <svg
          version="1.0"
          xmlns="http://www.w3.org/2000/svg"
          width="1em"
          height="1em"
          viewBox="0 0 512.000000 512.000000"
          preserveAspectRatio="xMidYMid meet"
        >
          <g
            transform="translate(0.000000,512.000000) scale(0.100000,-0.100000)"
            fill="#000000"
            stroke="none"
          >
            <path
              d="M213 5090 c-163 -65 -246 -249 -189 -420 17 -53 63 -100 1044 -1082
                    l1027 -1028 -1011 -1012 c-556 -557 -1021 -1029 -1032 -1049 -12 -20 -29 -64
                    -38 -98 -37 -148 38 -301 185 -373 36 -18 63 -23 126 -23 154 0 58 -85 1207
                    1064 l1028 1026 1028 -1026 c1149 -1149 1053 -1064 1207 -1064 67 0 89 4 137
                    28 97 48 168 150 182 262 8 58 -13 149 -46 204 -11 20 -476 492 -1032 1049
                    l-1011 1012 1026 1028 c982 982 1028 1029 1045 1082 58 173 -28 358 -194 420
                    -79 30 -185 24 -262 -14 -45 -23 -232 -205 -1067 -1039 l-1013 -1012 -1012
                    1012 c-835 833 -1023 1016 -1068 1039 -75 38 -191 44 -267 14z"
            />
          </g>
        </svg>
      </div>

      <div class="bg-white p-8 rounded-lg shadow-lg">
        <h2 class="text-2xl font-bold mb-4">Enter OTP</h2>
        <div class="text-[14px]">OTP has been sent to your email ID</div>
        <div class="text-[11px]">Please check your spam/ junk folder</div>

        <div v-if="otpError" class="text-red-500">OTP invalid</div>

        <div class="flex space-x-2">
          <input
            type="text"
            class="border border-gray-400 rounded-lg py-2 px-4 mb-1 outline-[#264dd9] focus:shadow-outline w-full"
            placeholder="Enter OTP"
            v-model="enter_otp"
          />
        </div>
        <button
          @click="addSubscriber"
          class="bg-blue-500 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded mt-4"
        >
          Submit
        </button>
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
import { reactive, ref, watch, onMounted, computed } from "vue";
import { useRouter } from "vue-router";
import apiUrl from "../../api";
import { debounce } from "lodash";
import moment from "moment";
import { State } from "country-state-city";

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
    const selectedState_main = ref("");
    const expandedJobs = ref([]);
    const totalJobCount = ref(0);
    const countries_state = ref([]);
    const remote = ref(false);
    const router = useRouter();
    const subscribe_skill = ref("");
    const subscribe_email = ref("");
    const showSuccessSubscrber = ref(false);
    const showOtpModel = ref(false);
    const final_otp = ref("");
    const subscription_id = ref("");
    const otpError = ref(false);
    const subscribe_skillError = ref(false);
    const subscribe_emailError = ref(false);
    const enter_otp = ref("");
    const isLoading = ref(false);
    const isEmployerLogged = ref(false);
    const isSeekerLogged = ref(false);
    const jobStatus = ref(false);

    const someCountry = ref([]);

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

    if (localStorage.getItem("employer_tocken") != null) {
      isEmployerLogged.value = true;
    }
    if (localStorage.getItem("seeker_tocken") != null) {
      isSeekerLogged.value = true;
    }
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

      console.log("state.value", state.value);
      selectedState_main.value = selectedStateObj
        ? JSON.parse(JSON.stringify(selectedStateObj)).name
        : "";
    };

    const stringYearOfExperience = computed(() =>
      year_of_experience.value.toString()
    );

    const formateDate = (date) => {
      return moment(date).format("DD-MMM-YYYY");
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

    const getDetailedDescriptionPoints = (description) => {
      return description.split("\n").filter((point) => point.trim() !== "");
    };

    const getTruncatedPoints = (description, limit) => {
      console.log(description, "-------------------------------------");
      const points = getDetailedDescriptionPoints(description);
      // console.log(points,"sfsfsfsfsfsfsfsfs");
      return points.map((point) => truncateDescription(point, limit));
    };

    const closeSuccessSubscrber = () => {
      showSuccessSubscrber.value = false;
    };
    const openOtpModel = debounce(async () => {
      if (subscribe_skill.value == null || subscribe_skill.value == "") {
        subscribe_skillError.value = "Insert skill";
        return false;
      } else {
        subscribe_skillError.value = "";
      }

      if (subscribe_email.value == null || subscribe_email.value == "") {
        subscribe_emailError.value = "Insert Email";
        return false;
      } else {
        subscribe_emailError.value = "";
      }
      isLoading.value = true;

      await axios
        .post(`${apiUrl}/sendOtp`, {
          email: subscribe_email.value,
          skill: subscribe_skill.value,
        })
        .then((response) => {
          isLoading.value = false;
          subscription_id.value = response.data.subscription_data.id;
          showOtpModel.value = true;
          console.log("subscription_id", subscription_id.value);
        })
        .catch((error) => {
          console.error(error);
        });
    });

    const closeOtpModel = () => {
      showOtpModel.value = false;
    };

    const handleButtonClick = () => {
      router.push("/admin-login");
    };

    const seekerLogin = () => {
      router.push("/seeker-login");
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

    const addSubscriber = debounce(async () => {
      final_otp.value = enter_otp.value;
      // final_otp.value = final_otp.value.trim();
      console.log("final_otp", final_otp.value);
      isLoading.value = true;

      await axios
        .post(`${apiUrl}/addSubscriber`, {
          otp: final_otp.value,
          subscription_id: subscription_id.value,
        })
        .then((response) => {
          isLoading.value = false;
          if (response.data.success) {
            console.log("response", response);
            subscribe_skill.value = "";
            subscribe_email.value = "";
            showOtpModel.value = false;

            showSuccessSubscrber.value = true;
          } else {
            otpError.value = true;
          }
        })
        .catch((error) => {
          console.error(error);
        });
    });

    const seekerLogout = async () => {
      try {
        const authToken = localStorage.getItem("seeker_tocken");

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
          `${apiUrl}/seeker-logout`,
          null,
          config
        );
        localStorage.removeItem("seeker_tocken");
        localStorage.removeItem("seeker_id");

        if (response.data.message) {
          setTimeout(() => {
            router.push("/seeker-login");
          }, 1000);
        }

        console.log(response);
      } catch (error) {
        console.log(error);
      }
    };

    const fetchJobs = debounce(async () => {
      try {
        const params = {};

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

        if (selectedState_main.value.trim() !== "") {
          params.state = selectedState_main.value.trim();
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

        jobStatus.value = true;
        jobs.value = response.data;
      } catch (error) {
        console.error(error);
      }
    }, 500);
    watch(
      [
        country,
        employment_type,
        skill,
        year_of_experience,
        selectedState_main,
        remote,
        datePosted,
      ],
      () => {
        fetchJobs();
      }
    );

    onMounted(() => {
      // countries_state.value = Country.getAllCountries();
      countries_state.value = someCountry.value;

      console.log(countries_state.value, "countries_state");
      fetchCountries();
      fetchJobs();
    });
    return {
      jobStatus,
      seekerLogout,
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
      truncateDescription,
      expanded,
      selectedCountry,
      states,
      selectedState,
      onCountryChange,
      expandedJobs,
      toggleExpand,
      setSelectedState,
      getDetailedDescriptionPoints,
      getTruncatedPoints,
      subscribe_skill,
      subscribe_email,
      addSubscriber,
      showSuccessSubscrber,
      closeSuccessSubscrber,
      openOtpModel,
      showOtpModel,
      closeOtpModel,
      subscription_id,
      otpError,
      seekerLogin,
      subscribe_skillError,
      subscribe_emailError,
      enter_otp,
      isLoading,
      isEmployerLogged,
      isSeekerLogged,
      // handleSearch
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
