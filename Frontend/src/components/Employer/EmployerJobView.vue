<template>
  <div>
    <!-- Rest of the form content -->

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

    <div class="bg-[#ebf4ff]">
      <div
        class="text-[#1890da] sm:text-[26px] text-[22px] font-semibold mt-[0px] sm:mb-[0px] mb-[25px] cursor-pointer"
      >
        View Past Jobs
      </div>
      <span v-if="addJobMessageStatus === 'true'" class="text-green-600"
        >Your job is posted successfully.</span
      >
      <div class="max-w-[1080px] gap-6 w-full px mx-auto">
        <!-- Form with two parts -->

        <div
          class="rounded-lg m-auto w-full shadow-[rgba(100, 100, 111, 0.2) 0px 5px 30px 0px] mt-6"
        >
          <div class="text-start">
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

                        <!-- <div v-if="job.state">,</div> -->
                        <h3 class="text-[#474d6a] capitalize text-[16px]">
                          <div v-if="job.remote == 0 && job.state && job.city">
                            {{ job.city }},{{ job.state }},
                          </div>
                          <div v-else-if="job.remote == 0 && job.state">
                            {{ job.state }},
                          </div>
                          <div v-else-if="job.remote == 0 && job.city">
                            {{ job.city }},
                          </div>
                          <div v-else></div>

                          <!-- {{ job.remote == 1 ? ",Remote" : ","+job.state }} -->
                        </h3>
                        <div class="flex items-center">
                          <!-- <span class="text-gray-500 mr-2">State:</span> -->
                          <span class="text-[#474d6a] capitalize text-[16px]">{{
                            job.country
                          }}</span>
                          <div v-if="job.remote == 1">(Remote)</div>
                        </div>
                      </div>
                      <div class="flex gap-1 items-center">
                        <span
                          class="text-[#474d6a] font-bold flex gap-2 items-center text-[14px]"
                          >Job Title :</span
                        >
                        <span class="text-[#474d6a]">{{ job.job_title }}</span>
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
                        class="flex items-center py-1 px-2 w-auto whitespace-nowrap rounded"
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
                          v-if="job.employment_type == 'contract-c2c'"
                          >Contract-C2C</span
                        >
                        <span
                          class="text-[#474d6a]"
                          v-if="job.employment_type == 'contract-w2'"
                          >Contract-W2</span
                        >
                        <span
                          class="text-[#474d6a]"
                          v-if="job.employment_type == 'contract-others'"
                          >Contract-Others</span
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
                      class="flex items-center py-1 px-2 w-auto whitespace-nowrap rounded mt-2"
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
                    <div>
                      <button
                        class="bg-blue-500 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded-md focus:outline-none focus:shadow-outline"
                      >
                        <router-link :to="'/employer-job-edit/' + job.id"
                          >Edit</router-link
                        >
                      </button>
                      <button
                        class="bg-red-500 hover:bg-blue-700 text-white font-bold py-2 px-4 ml-2 rounded-md focus:outline-none focus:shadow-outline"
                        @click="openDeletePostModel(job.id)"
                      >
                        Delete
                      </button>

                      <button
                        v-if="job.paid == 1"
                        class="bg-green-500 hover:bg-green-700 text-white font-bold py-2 px-4 ml-2 rounded-md focus:outline-none focus:shadow-outline"
                      >
                        <router-link :to="'/list-matching-resumes/' + job.id">
                          List Matching Resumes
                        </router-link>
                      </button>
                    </div>
                  </div>
                </div>

                <div
                  v-if="!expandedJobs.includes(job.id)"
                  class="text-[#474d6a] bg-[#fff] py-1 px-2 mt-2 capitalize text-[14px]"
                >
                  <b>Additional Job Detail</b>

                  <div
                    v-for="(point, index) in getTruncatedPoints(
                      job.additional_detail
                        ? job.additional_detail.slice(0, 100)
                        : '-',
                      50
                    )"
                    :key="index"
                  >
                    {{ point }}
                  </div>
                  <span class="show-more-link" @click="toggleExpand(job.id)"
                    >Show Job Description &amp; Technical skill Required</span
                  >
                </div>
                <!-- Display full description when job is expanded -->
                <div
                  v-else
                  class="text-[#474d6a] bg-[#fff] py-1 px-2 mt-2 capitalize text-[14px]"
                >
                  <div style="white-space: pre-wrap">
                    <b>Additional Job Detail</b>
                    <br />
                    {{ job.additional_detail ? job.additional_detail : "-" }}
                    <br />
                    <br />
                    <b>Job Description</b>
                    <br />
                    {{ job.detailed_description }}
                    <br />
                    <br />
                    <b>Technical Skill Required</b>
                    <br />
                    {{ job.technical_skill ? job.technical_skill : "-" }}
                  </div>
                  <span class="show-more-link" @click="toggleExpand(job.id)"
                    >Hide Job Description &amp; Technical skill Required</span
                  >
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

                    {{ job.apply_count }} Job Seeker(s) have applied for this
                  </p>
                </div>
                <div class="flex justify-end">
                  <p class="text-yellow-700 font-bold text-xl">
                    {{ job.paid == 1 ? "Premium" : "" }}
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

    <div
      class="modal fixed inset-0 bg-gray-800 bg-opacity-50 flex items-center justify-center"
      v-if="deletePostConfirmation"
    >
      <div class="bg-white p-8 rounded shadow-lg w-100">
        <p class="mb-3">Are you sure to delete post?</p>

        <div class="flex justify-end">
          <button
            class="mr-2 px-4 py-2 bg-gray-500 text-white rounded"
            @click="closeDeletePostModel"
          >
            No
          </button>
          <button
            class="px-4 py-2 bg-green-500 text-white rounded"
            @click="deletePost"
          >
            Yes
          </button>
        </div>
      </div>
    </div>
  </div>
</template>

  <script>
import { reactive, ref, watch, onMounted } from "vue";
import { useRouter } from "vue-router";
import apiUrl from "../../api";
import { debounce } from "lodash";
import moment from "moment";
import { State } from "country-state-city";
import EmployerNev from "../Employer/EmployerNavbar.vue";

import axios from "axios";

export default {
  components: {
    EmployerNev,
  },
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
    const deletePostConfirmation = ref(false);
    const deletePostId = ref("");
    const employername = ref("");

    const acct_balance = ref("");
    const employer_role = ref("");

    const someCountry = ref([]);
    const addJobMessageStatus = ref(false);
    const addJobMessage = ref(false);

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

    const listMatchingResumes = async (id) => {
      console.log("listMatchingResumes", id);
      router.push("/list-matching-resumes");
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

    const openDeletePostModel = (deleteId) => {
      deletePostId.value = deleteId;
      deletePostConfirmation.value = true;
    };

    const closeDeletePostModel = () => {
      deletePostConfirmation.value = false;
    };

    const deletePost = debounce(async () => {
      try {
        console.log(deletePostId.value, "deletePostIddeletePostId");
        const deleteId = deletePostId.value;
        deletePostConfirmation.value = false;
        isLoading.value = true;

        const response = await axios.delete(
          `${apiUrl}/employer-job/${deleteId}`
        );
        isLoading.value = false;

        window.location.reload();

        console.log(response.value, "asdasdas");
      } catch (error) {
        console.error(error);
      }
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

      employername.value = response.data.employer_details.employername;
      acct_balance.value = response.data.employer_details.acct_balance;

      employer_role.value = response.data.employer_details.role;
      console.log("employer_role", employer_role.value);
    };

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
        const employer_id = localStorage.getItem("employer_id");

        const response = await axios.get(
          `${apiUrl}/employer-job/${employer_id}`
        );

        jobStatus.value = true;
        jobs.value = response.data;
        console.log(jobs.value, "asdasdas");
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

      addJobMessage.value = localStorage.getItem("addJobMessage");
      addJobMessageStatus.value = localStorage.getItem("addJobMessageStatus");

      if (addJobMessage.value && !addJobMessageStatus.value) {
        localStorage.setItem("addJobMessageStatus", true);
      }

      if (addJobMessage.value && addJobMessageStatus) {
        localStorage.setItem("addJobMessageStatus", false);
      }

      countries_state.value = someCountry.value;

      console.log(countries_state.value, "countries_state");
      fetchCountries();
      fetchJobs();
      getEmployerDeatails();
    });
    return {
      addJobMessageStatus,
      addJobMessage,
      listMatchingResumes,
      employer_role,
      acct_balance,
      employername,
      getEmployerDeatails,
      deletePostId,
      deletePost,
      closeDeletePostModel,
      openDeletePostModel,
      deletePostConfirmation,
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
