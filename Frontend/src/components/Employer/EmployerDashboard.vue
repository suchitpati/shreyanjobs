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
                            <div class="text-left pl-[180px]">
                                Search Resume
                            </div>
                            <div
                                class="flex items-center justify-center px-[20px] gap-6 w-[65%] mx-auto md:pt-[28px] pt-5 sm:mb-1 mb-10 md:w-full"
                            >
                                <div
                                    class="flex items-center justify-center w-[40%] relative"
                                >
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
                            <span class="text-[14px] pr-[135px] "
                                >Please email to support@shreyanjobs.com to get
                                the contact detail &amp; Resume.</span
                            >
                        </div>
                        <div class="bg-[linear-gradient(180deg,#f5f4fa,rgba(251,251,253,0))] mt-9">
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
                            Search Jobs by skill or Job Role
                        </h1>
                        <div v-if="jobStatus == false">
                            <p>Waiting for job listing</p>
                        </div>
                        <div v-if="person">
                            <div
                                v-for="person in allSeeker"
                                :key="person.email"
                                class="rounded-[20px] bg-[#d3ddff4f] sm:p-[30px] sm:pt-[12px] p-[16px] mt-[20px] shadow-[rgba(100,_100,_111,_0.2)_0px_0px_10px_0px] hover:shadow-[rgba(100,_100,_111,_0.2)_0px_0px_20px_0px] transition-[.5s]"
                            >

                                <div class="flex gap-[10px]">
                                    <div class="grow">
                                        <p
                                            class="text-[#121224] font-bold hover:underline capitalize text-[17px]"
                                        >
                                            {{ person.short_description }}
                                        </p>
                                        <div
                                            class="flex items-center gap-4 mt-2"
                                        >
                                            <div
                                                class="flex gap-1 items-center"
                                            >
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

                                                <!-- <div v-if="person.state">,</div> -->
                                                <h3
                                                    class="text-[#474d6a] capitalize text-[16px]"
                                                >
                                                    <div
                                                        v-if="
                                                            person.remote == 0 &&
                                                            person.state &&
                                                            person.city
                                                        "
                                                    >
                                                        {{ person.city }},{{
                                                            person.state
                                                        }},
                                                    </div>
                                                    <div
                                                        v-else-if="
                                                            person.remote == 0 &&
                                                            person.state
                                                        "
                                                    >
                                                        {{ person.state }},
                                                    </div>
                                                    <div
                                                        v-else-if="
                                                            person.remote == 0 &&
                                                            person.city
                                                        "
                                                    >
                                                        {{ person.city }},
                                                    </div>
                                                    <div v-else></div>

                                                    <!-- {{ person.remote == 1 ? ",Remote" : ","+person.state }} -->
                                                </h3>
                                                <div class="flex items-center">
                                                    <!-- <span class="text-gray-500 mr-2">State:</span> -->
                                                    <span
                                                        class="text-[#474d6a] capitalize text-[16px]"
                                                        >{{ person.country }}</span
                                                    >
                                                    <div v-if="person.remote == 1">
                                                        (Remote)
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="flex items-center mt-2">
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
                                            <span class="text-[#474d6a]">{{
                                                 person.primary_skill
                                            }}</span>
                                        </div>
                                        <div
                                            class="flex items-center mt-2 gap-10"
                                        >
                                            <div
                                                class="flex items-center w-auto whitespace-nowrap rounded"
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
                                                    v-if="
                                                        person.employment_type ==
                                                        'contracttohire'
                                                    "
                                                    >Contract To Hire</span
                                                >
                                                <span
                                                    class="text-[#474d6a]"
                                                    v-if="
                                                        person.employment_type ==
                                                        'parttime'
                                                    "
                                                    >Part Time</span
                                                >
                                                <span
                                                    class="text-[#474d6a]"
                                                    v-if="
                                                        person.employment_type ==
                                                        'fulltime'
                                                    "
                                                    >Full Time</span
                                                >
                                                <span
                                                    class="text-[#474d6a]"
                                                    v-if="
                                                        person.employment_type ==
                                                        'contract'
                                                    "
                                                    >Contract</span
                                                >
                                            </div>
                                            <div
                                                class="flex items-center w-auto whitespace-nowrap rounded"
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
                                                    person.year_of_experience
                                                }}</span>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="flex-wrap">
                                        <div
                                            class="flex items-center justify-end"
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
                                                    d="M11 6.5a.5.5 0 0 1 .5-.5h1a.5.5 0 0 1 .5.5v1a.5.5 0 0 1-.5.5h-1a.5.5 0 0 1-.5-.5v-1zm-3 0a.5.5 0 0 1 .5-.5h1a.5.5 0 0 1 .5.5v1a.5.5 0 0 1-.5.5h-1a.5.5 0 0 1-.5-.5v-1zm-5 3a.5.5 0 0 1 .5-.5h1a.5.5 0 0 1 .5.5v1a.5.5 0 0 1-.5.5h-1a.5.5 0 0 1-.5-.5v-1zm3 0a.5.5 0 0 1 .5-.5h1a.5.5 0 0 1 .5.5v1a.5.5 0 0 1-.5.5h-1a.5.5 0 0 1-.5-.5v-1z"
                                                ></path>
                                                <path
                                                    d="M3.5 0a.5.5 0 0 1 .5.5V1h8V.5a.5.5 0 0 1 1 0V1h1a2 2 0 0 1 2 2v11a2 2 0 0 1-2 2H2a2 2 0 0 1-2-2V3a2 2 0 0 1 2-2h1V.5a.5.5 0 0 1 .5-.5zM1 4v10a1 1 0 0 0 1 1h12a1 1 0 0 0 1-1V4H1z"
                                                ></path>
                                            </svg>
                                            <p
                                                class="text-[14px] text-[#717b9e] ml-[5px]"
                                            >
                                                Posted Date :
                                                {{
                                                    formateDate(person.created_at)
                                                }}
                                            </p>
                                        </div>
                                        <div class="flex gap-[10px] mt-[10px]">
                                            <div
                                                class="flex gap-1 items-center"
                                            >
                                                <span
                                                    class="text-[#474d6a] font-bold flex gap-2 items-center text-[14px]"
                                                    >Job Title :</span
                                                >
                                                <span class="text-[#474d6a]">{{
                                                    person.job_title
                                                }}</span>
                                            </div>

                                        </div>

                                        <div
                                            v-if="
                                                isSeekerLogged == false &&
                                                isEmployerLogged == false
                                            "
                                        >
                                            <button
                                                class="py-2 px-4 rounded-lg text-white bg-blue-600"
                                            >
                                                <router-link to="/seeker-login">
                                                    Login To apply</router-link
                                                >
                                            </button>
                                        </div>

                                        <div
                                            v-if="
                                                isSeekerLogged == true &&
                                                person.applied == false
                                            "
                                        >
                                            <button
                                                class="py-2 px-4 rounded-lg text-white bg-blue-600"
                                                @click="
                                                    openModel(
                                                        person.id,
                                                        person.job_owner_id
                                                    )
                                                "
                                            >
                                                Apply to this person
                                            </button>
                                        </div>

                                        <div
                                            class="text-right mt-2"
                                            v-if="
                                                isSeekerLogged == true &&
                                                person.applied == true
                                            "
                                        >
                                            <button
                                                class="py-2 px-4 rounded-lg text-white bg-blue-600"
                                            >
                                                Applied
                                            </button>
                                        </div>
                                        <div
                                            v-if="
                                                isEmployerLogged == true &&
                                                employer_id == person.job_owner_id
                                            "
                                        >
                                            <button
                                                class="bg-blue-500 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded-md focus:outline-none focus:shadow-outline"
                                            >
                                                <router-link
                                                    :to="
                                                        '/employer-person-edit/' +
                                                        person.id
                                                    "
                                                    >Edit</router-link
                                                >
                                            </button>
                                        </div>
                                    </div>
                                </div>

                                <div
                                    v-if="!expandedJobs.includes(person.id)"
                                    class="text-[#474d6a] bg-[#fff] py-1 px-2 mt-2 capitalize text-[14px]"
                                >
                                    <b>Additional Job Detail</b>

                                    <div
                                        v-for="(
                                            point, index
                                        ) in getTruncatedPoints(
                                            person.additional_detail
                                                ? person.additional_detail.slice(
                                                      0,
                                                      200
                                                  )
                                                : '-',
                                            50
                                        )"
                                        :key="index"
                                    >
                                        {{ point }}
                                    </div>
                                    <span
                                        class="show-more-link"
                                        @click="toggleExpand(person.id)"
                                        >Show Job Description &amp; Technical
                                        skill Required</span
                                    >
                                </div>
                                <!-- Display full description when person is expanded -->
                                <div
                                    v-else
                                    class="text-[#474d6a] bg-[#fff] py-1 px-2 mt-2 capitalize text-[14px]"
                                >
                                    <div style="white-space: pre-wrap">
                                        <b>Additional Job Detail</b>
                                        <br />
                                        {{
                                            person.additional_detail
                                                ? person.additional_detail
                                                : "-"
                                        }}
                                        <br />
                                        <br />
                                        <b>Job Description</b>
                                        <br />
                                        {{ person.detailed_description }}
                                        <br />
                                        <br />
                                        <b>Technical Skill Required</b>
                                        <br />
                                        {{
                                            person.technical_skill
                                                ? person.technical_skill
                                                : "-"
                                        }}
                                    </div>
                                    <span
                                        class="show-more-link"
                                        @click="toggleExpand(person.id)"
                                        >Hide Job Description &amp; Technical
                                        skill Required</span
                                    >
                                </div>
                                <!-- Display full description when person is expanded -->
                                <!-- <div
                                      v-else
                                      class="text-[#474d6a] bg-[#fff] py-1 px-2 mt-2 capitalize text-[14px]"
                                  >
                                      {{ person.detailed_description }}
                                  </div> -->
                                <div class="flex gap-2 items-center px-2 mt-2">
                                    <p class="text-[14px] text-[#717b9e]">
                                        <!-- Posted Date
                                          {{ formateDate(person.created_at) }} -->

                                        (Searched for
                                        {{ person.search_count }} times )
                                    </p>
                                </div>
                            </div>
                        </div>
                        <div v-if="jobs == 0 && jobStatus == true">
                            <p>No job Found</p>
                        </div>
                    </div>
                </div>
            </div>
        </div>
                        <div class="mt-8 flow-root">
                            <div
                                class="-mx-4 -my-2 overflow-x-auto sm:-mx-6 lg:-mx-8"
                            >
                                <div
                                    class="inline-block min-w-full py-2 align-middle sm:px-6 lg:px-8"
                                >
                                    <table
                                        class="min-w-full divide-y divide-gray-300"
                                    >
                                        <thead>
                                            <tr
                                                class="divide-x divide-gray-200"
                                            >
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
                                        <tbody
                                            class="divide-y divide-gray-200 bg-white"
                                        >
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
                                                <td
                                                    class="whitespace-nowrap p-4 text-sm text-gray-500"
                                                >
                                                    {{ person.primary_skill }}
                                                </td>
                                                <td
                                                    class="whitespace-nowrap p-4 text-sm text-gray-500"
                                                >
                                                    {{
                                                        person.primary_skill_experience
                                                    }}
                                                </td>
                                                <td
                                                    class="whitespace-nowrap py-4 pl-4 pr-4 text-sm text-gray-500 sm:pr-0"
                                                >
                                                    {{ person.secondary_skill }}
                                                </td>
                                                <td
                                                    class="whitespace-nowrap py-4 pl-4 pr-4 text-sm text-gray-500 sm:pr-0"
                                                >
                                                    {{
                                                        person.secondary_skill_experience
                                                    }}
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
                                                    {{
                                                        person.relocate
                                                            ? "Yes"
                                                            : "No"
                                                    }}
                                                </td>
                                                <td
                                                    class="whitespace-nowrap py-4 pl-4 pr-4 text-sm text-gray-500 sm:pr-0"
                                                >
                                                    {{
                                                        person.work_authorization
                                                    }}
                                                </td>
                                                <td
                                                    class="whitespace-nowrap py-4 pl-4 pr-4 text-sm text-gray-500 sm:pr-0"
                                                >
                                                    <div>
                                                        <div
                                                            v-if="
                                                                !viewContactStatus &&
                                                                contact_id !=
                                                                    person.id
                                                            "
                                                            class="cursor-pointer underline"
                                                            @click="
                                                                openConfirmationmodel(
                                                                    person.id
                                                                )
                                                            "
                                                        >
                                                            View Contact Detail
                                                        </div>
                                                        <div
                                                            v-else-if="
                                                                contact_id ==
                                                                person.id
                                                            "
                                                        >
                                                            <div>
                                                                {{ email }}
                                                            </div>
                                                            <div>
                                                                {{
                                                                    contact_number
                                                                }}
                                                            </div>
                                                        </div>
                                                        <div
                                                            v-else
                                                            class="cursor-pointer underline"
                                                            @click="
                                                                openConfirmationmodel(
                                                                    person.id
                                                                )
                                                            "
                                                        >
                                                            View Contact Detail
                                                        </div>
                                                    </div>
                                                    <br />
                                                    <div
                                                        v-if="
                                                            !viewContactStatus &&
                                                            resume_contact_id !=
                                                                person.id
                                                        "
                                                        class="cursor-pointer"
                                                        @click="
                                                            openResumeConfirmationmodel(
                                                                person.id
                                                            )
                                                        "
                                                    >
                                                        <a
                                                            ><u
                                                                >View Resume</u
                                                            ></a
                                                        >{{ resume }}
                                                    </div>
                                                    <div
                                                        v-else-if="
                                                        resume_contact_id ==
                                                            person.id
                                                        "
                                                        class="cursor-pointer underline"
                                                    >
                                                        <div @click="downloadResume">
                                                            Download Resume

                                                        </div>
                                                    </div>
                                                    <div
                                                        v-else
                                                        class="cursor-pointer underline"
                                                    >
                                                        <div
                                                            class="cursor-pointer"
                                                            @click="
                                                                openResumeConfirmationmodel(
                                                                    person.id
                                                                )
                                                            "
                                                        >
                                                            <a
                                                                ><u
                                                                    >View
                                                                    Resume</u
                                                                ></a
                                                            >
                                                        </div>
                                                    </div>
                                                </td>
                                                <!-- <td
                          class="whitespace-nowrap py-4 pl-4 pr-4 text-sm text-gray-500 sm:pr-0"
                        >
                          {{ person.contact_number }}
                        </td> -->
                                            </tr>
                                            <tr
                                                v-if="
                                                    allSeeker == null ||
                                                    allSeeker == ''
                                                "
                                            >
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
                <p class="mb-1">
                    $0.5 will be deducted from your account balance.
                </p>
                <p class="mb-3">Do you want to continue ?</p>

                <div class="flex justify-end">
                    <button
                        class="mr-2 px-4 py-2 bg-gray-500 text-white rounded"
                        @click="closeconfirmModel"
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
        const resume = ref("");
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
        const confirmModelResume = ref(false);
        const viewContactStatus = ref(false);
        const contact_id = ref("");
        const resume_contact_id = ref("");

        const target_id = ref("");
        const target_resume_id = ref("");

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
        const download_resume = ref("");

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

        const closeconfirmModel = () => {
            confirmModel.value = false;
        };



        const openResumeConfirmationmodel = async (id) => {
            target_resume_id.value = id;
            confirmModelResume.value = !confirmModelResume.value;
            console.log(
                target_resume_id,
                "target_idtarget_idtarget_idtarget_id"
            );
        };

        const closeResumeconfirmModel = () => {
            confirmModelResume.value = false;
        };
        const fetchSeeker = debounce(async () => {
            try {
                const authToken = localStorage.getItem("employer_tocken");

                const formData = new FormData();
                formData.append("searchInput", searchInput.value);
                formData.append("selectedCountry", selectedCountry.value);

                const response = await axios.post(
                    `${apiUrl}/seeker-all`,
                    formData,
                    {
                        headers: {
                            Authorization: `Bearer ${authToken}`,
                        },
                    }
                );

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

                const response = await axios.get(
                    `${apiUrl}/seeker-contact-detail/${target_id.value}/${employer_id}`,
                    {
                        headers: {
                            Authorization: `Bearer ${authToken}`,
                        },
                    }
                );
                viewContactStatus.value = !viewContactStatus.value;
                email.value = response.data.seeker_details[0].email;
                contact_number.value =
                    response.data.seeker_details[0].contact_number;
                confirmModel.value = !confirmModel.value;
                contact_id.value = target_id.value;
                console.log(email.value, "response");
            } catch (error) {
                console.error(error);
            }
        });

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
                viewContactStatus.value = !viewContactStatus.value;
                console.log(response, "response");
                download_resume.value =
                    response.data.seeker_details[0].resume;
                confirmModelResume.value = !confirmModelResume.value;
                resume_contact_id.value = target_resume_id.value;
                console.log(
                    resume_contact_id.value,
                    "resume_contact_idresume_contact_id"
                );
            } catch (error) {
                console.error(error);
            }
        });
        const downloadResume = async () => {

           const  fileName =  download_resume.value;

            // const fileUrl = `https://shreyanjobs.com/backend/public/pdf/${fileName}`;
            const fileUrl = `http://127.0.0.1:8000/pdf/${fileName}`;


            // Create a temporary anchor element
            const link = document.createElement("a");
            link.href = fileUrl;
            link.download = fileName;

            // Append the link to the DOM (optional, but required for some browsers)
            document.body.appendChild(link);

            // Simulate a click on the link to trigger the download
            link.click();

            // Remove the link from the DOM after triggering the download
            document.body.removeChild(link);
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
            download_resume,
            resume,
            downloadResume,
            resume_contact_id,
            fetchSeeekerResumeDetail,
            closeResumeconfirmModel,
            target_resume_id,
            openResumeConfirmationmodel,
            confirmModelResume,
            target_id,
            contact_id,
            viewContactStatus,
            fetchSeeekerContactDetail,
            closeconfirmModel,
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
