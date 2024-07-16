<template>
  <div class="relative">
    <!-- Rest of the form content -->
    <div>
      <p class="py-2">
        <!-- Search More Result (Total: {{ totalJobCount }}) -->
      </p>
      <div class="bg-white">
        <div
          class="max-w-[1080px] mx-auto sm:px-[20px] px-[16px] flex flex-col sm:flex-row items-center"
        >
          <!-- Logo Section -->
          <div class="sm:w-full xs:w-auto w-full mb-4">
            <img
              class="md:w-[230px] w-[150px] mx-auto"
              src="../assets/logo-no-background.png"
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
            class="sm:w-full xs:w-auto w-full flex flex-col sm:flex-row justify-center sm:justify-end gap-[10px]"
          >
            <router-link to="/add-job">
              <button
                class="border-[#1890da] hover:bg-[#f7f7f9] border-[1px] w-max sm:ml-auto text-[#1890da] font-bold md:py-[5px] py-[7px] px-[18px] md:px-[15px] rounded-[26px] focus:outline-none focus:shadow-outline"
              >
                Post Job
              </button>
            </router-link>
            <router-link to="/employer-job-view">
              <button
                class="border-[#1890da] hover:bg-[#f7f7f9] border-[1px] w-max sm:ml-auto text-[#1890da] font-bold md:py-[5px] py-[7px] px-[18px] md:px-[15px] rounded-[26px] focus:outline-none focus:shadow-outline"
              >
                View/ Edit Jobs
              </button>
            </router-link>
            <router-link to="/employer-dashboard">
              <button
                class="border-[#1890da] hover:bg-[#f7f7f9] border-[1px] w-max sm:ml-auto text-[#1890da] font-bold md:py-[5px] py-[7px] px-[18px] md:px-[15px] rounded-[26px] focus:outline-none focus:shadow-outline"
              >
                Search Resume
              </button>
            </router-link>
            <router-link to="/job-search">
              <button
                class="border-[#1890da] hover:bg-[#f7f7f9] border-[1px] w-max sm:ml-auto text-[#1890da] font-bold md:py-[5px] py-[7px] px-[18px] md:px-[15px] rounded-[26px] focus:outline-none focus:shadow-outline"
              >
                Job Search
              </button>
            </router-link>
            <router-link to="/admin-task" v-if="employer_role == 1">
              <button
                class="border-[#1890da] hover:bg-[#f7f7f9] border-[1px] w-max sm:ml-auto text-[#1890da] font-bold md:py-[5px] py-[7px] px-[18px] md:px-[15px] rounded-[26px] focus:outline-none focus:shadow-outline"
              >
                Admin Task
              </button>
            </router-link>
            <router-link to="/employer-profile">
              <button
                class="border-[#1890da] hover:bg-[#f7f7f9] border-[1px] w-max sm:ml-auto text-[#1890da] font-bold md:py-[5px] py-[7px] px-[18px] md:px-[15px] rounded-[26px] focus:outline-none focus:shadow-outline"
              >
                Profile
              </button>
            </router-link>

            <button
              @click="employerLogout"
              class="border-[#1890da] hover:bg-[#f7f7f9] border-[1px] w-max sm:ml-auto text-[#1890da] font-bold md:py-[5px] py-[7px] px-[18px] md:px-[15px] rounded-[26px] focus:outline-none focus:shadow-outline m-auto"
            >
              Logout
            </button>
          </div>
          <div
            v-if="isSeekerLogged == true"
            class="sm:w-full xs:w-auto w-[50%] xs:order-3 order-2 flex justify-end gap-[10px]"
          >
            <router-link to="/job-search">
              <button
                class="border-[#1890da] hover:bg-[#f7f7f9] border-[1px] w-max sm:ml-auto text-[#1890da] font-bold md:py-[5px] py-[7px] px-[18px] md:px-[15px] rounded-[26px] focus:outline-none focus:shadow-outline"
              >
                Job Search
              </button>
            </router-link>

            <router-link to="/seeker-profile">
              <button
                class="border-[#1890da] hover:bg-[#f7f7f9] border-[1px] w-max sm:ml-auto text-[#1890da] font-bold md:py-[5px] py-[7px] px-[18px] md:px-[15px] rounded-[26px] focus:outline-none focus:shadow-outline"
              >
                Profile
              </button>
            </router-link>
            <button
              @click="seekerLogout"
              class="border-[#1890da] hover:bg-[#f7f7f9] border-[1px] w-max text-[#1890da] font-bold md:py-[5px] py-[7px] px-[18px] md:px-[26px] rounded-[26px] focus:outline-none focus:shadow-outline"
            >
              Logout
            </button>
          </div>
          <div
            v-if="isRecruiterLogged == true"
            class="sm:w-full xs:w-auto w-[50%] xs:order-3 order-2 flex justify-end gap-[10px]"
          >
            <router-link to="/job-search">
              <button
                class="border-[#1890da] hover:bg-[#f7f7f9] border-[1px] w-max sm:ml-auto text-[#1890da] font-bold md:py-[5px] py-[7px] px-[18px] md:px-[15px] rounded-[26px] focus:outline-none focus:shadow-outline"
              >
                Job Search
              </button>
            </router-link>
            <router-link to="/manage-consultant">
              <button
                class="border-[#1890da] hover:bg-[#f7f7f9] border-[1px] w-max sm:ml-auto text-[#1890da] font-bold md:py-[5px] py-[7px] px-[18px] md:px-[15px] rounded-[26px] focus:outline-none focus:shadow-outline"
              >
                Manage Consultants
              </button>
            </router-link>
            <router-link to="/edit-recruiter">
              <button
                class="border-[#1890da] hover:bg-[#f7f7f9] border-[1px] w-max sm:ml-auto text-[#1890da] font-bold md:py-[5px] py-[7px] px-[18px] md:px-[15px] rounded-[26px] focus:outline-none focus:shadow-outline"
              >
                Profile
              </button>
            </router-link>
            <button
              @click="consultantLogout"
              class="border-[#1890da] hover:bg-[#f7f7f9] border-[1px] w-max text-[#1890da] font-bold md:py-[5px] py-[7px] px-[18px] md:px-[26px] rounded-[26px] focus:outline-none focus:shadow-outline"
            >
              Logout
            </button>
          </div>
          <div
            v-if="
              isSeekerLogged == false &&
              isEmployerLogged == false &&
              isRecruiterLogged == false
            "
            class="sm:w-full xs:w-auto w-[50%] xs:order-3 order-2 flex justify-end gap-[10px]"
          >
            <router-link to="/job-search">
              <button
                class="border-gray-600 hover:bg-[#f7f7f9] border-r-[1px] w-max sm:ml-auto text-[#1890da] font-bold md:py-[10px] h-20 py-[7px] px-[18px] md:px-[26px] focus:outline-none focus:shadow-outline"
              >
                <span>Job </span><br />
                Search
              </button>
            </router-link>
            <router-link to="/employer-login">
              <button
                class="border-gray-600 hover:bg-[#f7f7f9] border-r-[1px] w-max sm:ml-auto text-[#1890da] font-bold md:py-[10px] h-20 py-[7px] px-[18px] md:px-[26px] focus:outline-none focus:shadow-outline"
              >
                <span>Free Job</span><br />
                Posting
              </button>
            </router-link>
            <router-link to="/employer-login">
              <button
                class="border-gray-600 hover:bg-[#f7f7f9] border-r-[1px] w-max sm:ml-auto text-[#1890da] font-bold md:py-[10px] h-20 py-[7px] px-[18px] md:px-[26px] focus:outline-none focus:shadow-outline"
              >
                <span>Employer</span> <br />
                Login
              </button>
            </router-link>
            <router-link to="/seeker-login">
              <button
                class="border-gray-600 hover:bg-[#f7f7f9] border-r-[1px] w-max sm:ml-auto text-[#1890da] font-bold md:py-[10px] h-20 py-[7px] px-[18px] md:px-[26px] focus:outline-none focus:shadow-outline"
              >
                <span>Jobs Seeker</span> <br />
                Login
              </button>
            </router-link>

            <router-link to="/recruiter-login">
              <button
                class="border-gray-600 hover:bg-[#f7f7f9] border-r-[1px] w-max sm:ml-auto text-[#1890da] font-bold md:py-[10px] h-20 py-[7px] px-[18px] md:px-[26px] focus:outline-none focus:shadow-outline"
              >
                <span>Bench Sales Recruiter</span> <br />
                Login
                <br />
                <span class="text-[12px] text-gray-600 font-light"
                  >(Manage multiple consultants)</span
                >
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
      <div class="text-red-600">
        This website can be viewed better on any latest browser on a laptop/
        desktop. If you must use a phone, please use the landscape mode
      </div>

      <div
        class="flex items-center max-w-[980px] py-3 gap-6 mx-auto justify-center sm:pb-1 pb-10 md:w-full"
      >
        <div class=" flex items-center justify-center gap-2">
          <p class="font-bold text-[20px] text-purple-900">*</p>
          <p class="text-[14px]">
            {{ total_seeker }} {{ seeker_display_profile_type }}
          </p>
          <span class="font-bold text-[20px] text-purple-900">*</span>
          <p class="text-[14px]">
            {{ total_employer }} {{ employer_display_profile_type }}
          </p>
          <span class="font-bold text-[20px] text-purple-900">*</span>
          <p class="text-[14px]">
            {{ total_bench_sales_recruiters }}
            {{ recruiters_display_profile_type }}
          </p>
          <span class="font-bold text-[20px] text-purple-900">*</span>
        </div>
      </div>
    </div>
    <div class="bg-[#fff] py-2">
      <div class="max-w-[980px] text-[12px] w-full m-auto pr-3">
        <div class="m-auto p-auto text-center">
          <span
            v-if="mailSentMessageStatus === 'true'"
            class="text-green-600 text-[16px]"
            >Your resume has been submitted to the employer</span
          >
        </div>
      </div>
    </div>
    <div class="bg-[linear-gradient(180deg,#f5f4fa,rgba(251,251,253,0))] py-5">
      <div class="flex gap-5 max-w-[980px] mx-auto">
        <div class="w-[70%]">
          <div class="bg-white px-5 py-3 rounded-md">
            <p
              class="underline font-bold text-sky-500 mb-4 text-xl cursor-pointer"
            >
              <router-link to="/seeker-login"> Job Seeker </router-link>
            </p>
            <div class="flex gap-5 mb-5">
              <div class="flex flex-col gap-2 w-[50%]">
                <div class="text-left flex gap-2 items-center">
                  <i class="fa fa-check"></i>
                  <p>Search Jobs with advanced filters</p>
                </div>
                <div class="text-left flex gap-2 items-center">
                  <i class="fa fa-check"></i>
                  <p>Apply for jobs with one click</p>
                </div>
              </div>
              <div class="flex flex-col gap-2 w-[50%]">
                <div class="text-left flex gap-2 items-center">
                  <i class="fa fa-check"></i>
                  <p>Receive New Job Notification in Email</p>
                </div>
                <div class="text-left flex gap-2">
                  <i class="fa fa-check"></i>
                  <p>Resume visible to all Registered Employers</p>
                </div>
              </div>
            </div>
            <p
              class="underline font-bold text-sky-500 mb-4 text-xl cursor-pointer"
            >
              <router-link to="/employer-login">
                Employer/ IT Recruiter
              </router-link>
            </p>
            <div class="flex gap-5 mb-5">
              <div class="flex flex-col gap-2 w-[50%]">
                <div class="text-left flex gap-2 items-center">
                  <i class="fa fa-check"></i>
                  <p>Post job for Free</p>
                </div>
                <div class="text-left flex gap-2 items-center">
                  <i class="fa fa-check"></i>
                  <p>Matching Resumes list for Premium job</p>
                </div>
                <div class="text-left flex gap-2 items-center">
                  <i class="fa fa-check"></i>
                  <p>$10 initial credit</p>
                </div>
              </div>
              <div class="flex flex-col gap-2 w-[50%]">
                <div class="text-left flex gap-2 items-center">
                  <i class="fa fa-check"></i>
                  <p>Search Resume with Advanced Filter</p>
                </div>
                <div class="text-left flex gap-2">
                  <i class="fa fa-check"></i>
                  <p>View Job Seeker’s Contact and resume (Fee applicable)</p>
                </div>
                <div class="text-left flex gap-2">
                  <i class="fa fa-check"></i>
                  <p>Premium Job notification to active Job Seekers</p>
                </div>
              </div>
            </div>
            <p
              class="underline font-bold text-sky-500 mb-4 text-xl cursor-pointer"
            >
              <router-link to="/recruiter-login">
                Bench Sales Recruiter</router-link
              >
            </p>
            <div class="flex gap-5 mb-5">
              <div class="flex flex-col gap-2 w-[50%]">
                <div class="text-left flex gap-2">
                  <i class="fa fa-check"></i>
                  <p>Manage multiple Consultants with a single login.</p>
                </div>
                <div class="text-left flex gap-2">
                  <i class="fa fa-check"></i>
                  <p>Search and apply Jobs for multiple Consultants</p>
                </div>
              </div>
              <div class="flex flex-col gap-2 w-[50%]">
                <div class="text-left flex gap-2">
                  <i class="fa fa-check"></i>
                  <p>Receive New Job Notification in Email</p>
                </div>
                <div class="text-left flex gap-2">
                  <i class="fa fa-check"></i>
                  <p>Resume visible to Employers/ IT Recruiters</p>
                </div>
              </div>
            </div>
          </div>
        </div>
        <div class="w-[30%]">
          <div
            class="text-left border border-red-500 py-2 px-3 bg-white rounded-md"
          >
            <p class="font-bold text-sky-500 text-xl mb-2">Free Job Posting</p>
            <div class="text-left flex gap-2">
              <i class="fa fa-check"></i>
              <p>Cost to post a job: Free</p>
            </div>
            <div class="text-left flex gap-2">
              <i class="fa fa-check"></i>
              <p>The job is listed for 2 days</p>
            </div>
            <div class="text-left flex gap-2">
              <i class="fa fa-check"></i>
              <p>Unlimited Job Posting</p>
            </div>
            <div class="">
              <img
                class="w-[100px] ml-[40px]"
                src="../../src/assets/vs-removebg-preview.png"
                alt=""
              />
            </div>
            <p class="font-bold text-sky-500 text-xl mb-2">
              Premium Job Posting
            </p>
            <div class="text-left flex gap-2">
              <i class="fa fa-check"></i>
              <p>Cost to post a job : $1</p>
            </div>
            <div class="text-left flex gap-2">
              <i class="fa fa-check"></i>
              <p>The job is listed for 7 days</p>
            </div>
            <div class="text-left flex gap-2">
              <i class="fa fa-check"></i>
              <p>Listed first on Job Search Result.</p>
            </div>
            <div class="text-left flex gap-2">
              <i class="fa fa-check"></i>
              <p>List of matching resumes for your job.</p>
            </div>
          </div>
        </div>
      </div>
    </div>
    <p class="max-w-[980px] text-left mx-auto py-2">
      For any issue in accessing shreyanjobs.com please email to
      support@shreyanjobs.com
    </p>
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

    <div v-if="isActive">
      <div class="fixed inset-0 bg-black bg-opacity-40 z-5">
        <div class="w-full h-full flex justify-center items-center">
          <div
            class="max-w-[700px] w-full rounded-lg bg-[#d3ddff] p-5 relative"
          >
            <div
              class="absolute top-3 right-5 cursor-pointer"
              @click="openModel()"
            >
              x
            </div>
            <div>
              <!-- <span v-if="mailSentMessageStatus === 'true'" class="text-green-600">Your resume has been submitted to the employer</span> -->
              <div class="text-xl font-semibold text-center mb-5">Resume</div>
              <div class="flex items-center mb-5">
                <div class="text-black font-semibold mr-3">
                  Resume :
                  <span
                    v-if="isEmployerLogged || isSeekerLogged"
                    class="text-[#474d6a]"
                    >{{ resume }}</span
                  >
                </div>
                <div class="">
                  <span
                    class="text-blue-500 underline cursor-pointer"
                    @click="downloadPDF"
                    >Download</span
                  >
                </div>
              </div>
              <div class="mb-5">
                <div class="flex items-center mb-2">
                  <div class="text-black font-semibold mr-3">
                    Replace Resume :
                  </div>
                  <div class="border border-gray-400 rounded-lg p-2 flex-grow">
                    <input
                      type="file"
                      id="file"
                      class="w-full"
                      @change="image_details"
                    />
                  </div>
                </div>
                <div class="text-xs">
                  ( Only Doc,docx & pdf file extantion are allowed,Files must be
                  less than 3 MB )
                </div>
              </div>
              <div class="mb-5">
                <div class="text-black font-semibold mr-3 mb-2">
                  Cover Letter or Additional Note to the Employer
                </div>
                <textarea
                  name="textfield"
                  id=""
                  cols="60"
                  rows="5"
                  maxlength="200"
                  class="border border-black rounded-lg"
                  v-model="cover_letter"
                ></textarea>
                <div class="text-end">
                  <span class="text-blue-700 text-[16px] mr-[45px]"
                    >Characters left: {{ remaining_cover_detail }}/200</span
                  >
                </div>
              </div>
              <div class="flex justify-end">
                <div>
                  <button
                    class="bg-blue-400 px-5 mr-3 py-3 rounded-xl text-white"
                    @click="jobmail(jobOriginalId, jobOriginalEmployerId)"
                  >
                    Apply</button
                  ><button
                    class="bg-red-400 px-5 py-3 rounded-xl text-white"
                    @click="openModel()"
                  >
                    Cancel
                  </button>
                </div>
              </div>
            </div>
          </div>
        </div>
      </div>
    </div>
    <div v-if="isActiveConsultant">
      <div class="fixed inset-0 bg-black bg-opacity-40 z-5">
        <div class="w-full h-full flex justify-center items-center">
          <div
            class="max-w-[800px] w-full rounded-lg bg-[#d3ddff] p-5 relative"
          >
            <div
              class="absolute top-3 right-5 cursor-pointer"
              @click="openConsultantModel()"
            >
              x
            </div>
            <div>
              <!-- <span v-if="mailSentMessageStatus === 'true'" class="text-green-600">Your resume has been submitted to the employer</span> -->
              <div class="text-xl font-semibold text-center mb-5">
                Select Consultant to Apply
              </div>
              <div class="py-5">
                <table class="bg-white mx-auto">
                  <thead>
                    <tr>
                      <th class="px-4 py-2 border border-gray-300"></th>
                      <th class="px-4 py-2 border border-gray-300">Name</th>
                      <th class="px-4 py-2 border border-gray-300">Location</th>
                      <th class="px-4 py-2 border border-gray-300">
                        Primary Skill
                      </th>
                    </tr>
                  </thead>
                  <tbody
                    v-for="consultants in consultants_data"
                    :key="consultants.id"
                  >
                    <tr>
                      <td>
                        <input
                          type="checkbox"
                          @change="handleCheckboxChange(consultants.id)"
                        />
                      </td>

                      <td class="px-4 py-2 border border-gray-300">
                        {{ consultants.fullname }}
                      </td>
                      <td class="px-4 py-2 border border-gray-300">
                        {{ consultants.city }} ,{{ consultants.state }},
                        {{ consultants.country }}
                      </td>
                      <td class="px-4 py-2 border border-gray-300">
                        {{ consultants.primary_skill }}
                      </td>
                    </tr>
                  </tbody>
                </table>
              </div>
              <div class="mb-5">
                <div class="text-black font-semibold mr-3 mb-2">
                  Cover Letter or Additional Note to the Employer
                </div>
                <textarea
                  name="textfield"
                  id=""
                  cols="60"
                  rows="5"
                  maxlength="200"
                  class="border border-black rounded-lg"
                  v-model="consultants_cover_letter"
                ></textarea>
                <div class="text-end">
                  <span class="text-blue-700 text-[16px] mr-[45px]"
                    >Characters left: {{ remaining_cover_detail }}/200</span
                  >
                </div>
              </div>
              <div class="flex justify-end">
                <div>
                  <button
                    class="bg-blue-400 px-5 mr-3 py-3 rounded-xl text-white"
                    @click="consultantJobmail(jobOriginalId)"
                  >
                    Apply</button
                  ><button
                    class="bg-red-400 px-5 py-3 rounded-xl text-white"
                    @click="openConsultantModel()"
                  >
                    Cancel
                  </button>
                </div>
              </div>
            </div>
          </div>
        </div>
      </div>
    </div>

    <!-- <div
      v-if="skillModelStatus"
      class="modal fixed inset-0 bg-gray-800 bg-opacity-50 flex items-center justify-center"
    >
      <div class="bg-white p-8 rounded shadow-lg w-100">
        <p class="text-[22px]"><b>Email Subscription for New Job Posting</b></p>
        <p class="mb-4 text-sm">
          Email will be sent to you for any new job posting with this skill.
        </p>
        <p class="mb-4 text-sm">
          <b>
            Please specify only one skill. More skills can be added from profile
            page (Manage Subscription).</b
          >
        </p>
        <p class="text-red-600" v-if="err_skill">{{ err_skill }}</p>
        <div class="flex items-center mb-4">
          <label for="" class="mr-2 text-gray-700 font-semibold">Skill:</label>
          <input
            id=""
            v-model="skillInput"
            placeholder="Enter only one skill (Example : Oracle, java,.net etc.). Do not enter your Email ID here."
            type="text"
            class="border-2 border-gray-400 px-4 py-2 rounded-md w-full focus:outline-none focus:border-blue-500"
          />
        </div>

        <div class="flex justify-center">

          <button
            class="px-4 py-2 bg-green-500 text-white rounded hover:bg-green-600 transition duration-300"
            @click="addSeeekerSkillDetail"
          >
            Submit
          </button>
        </div>
      </div>
    </div> -->
    <div
      class="fixed inset-0 flex items-center justify-center z-10"
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
import { reactive, ref, watch, onMounted, computed } from "vue";
import { useRouter } from "vue-router";
import apiUrl from "../api";
import { debounce } from "lodash";
import moment from "moment";
import { State } from "country-state-city";
import axios from "axios";

export default {
  setup() {
    const cover_letter = ref("");
    const consultants_cover_letter = ref("");

    const resume = ref("");
    const isActive = ref(false);
    const isActiveConsultant = ref(false);

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
    const isRecruiterLogged = ref(false);
    const jobStatus = ref(false);
    const employer_id = ref("");
    const someCountry = ref([]);
    const file = ref("");
    const seekerLoggedId = ref("");
    const jobOriginalId = ref("");
    const jobOriginalEmployerId = ref("");
    const remaining_cover_detail = ref(200);
    const mailSentMessage = ref(false);
    const mailSentMessageStatus = ref(false);
    const skillModelStatus = ref(false);

    const skillInput = ref("");
    const skillInput1s = ref("");
    const err_skill = ref("");

    const deletePostConfirmation = ref(false);
    const deletePostId = ref("");
    const total = ref("");
    const total_seeker = ref(0);
    const total_bench_sales_recruiters = ref(0);

    const fullname = ref("");
    const seeker_display_profile_type = ref("");
    const recruiters_display_profile_type = ref("");
    const employer_display_profile_type = ref("");
    const total_employer = ref(0);
    const employer_role = ref("");
    const consultants_data = ref({});
    const selectedConsultants = ref([]); // Array to store selected consultant IDs

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

    if (localStorage.getItem("employer_role") != null) {
      employer_role.value = localStorage.getItem("employer_role");
    }

    if (localStorage.getItem("seeker_tocken") != null) {
      isSeekerLogged.value = true;
    }
    if (localStorage.getItem("recruiter_tocken") != null) {
      isRecruiterLogged.value = true;
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
    const image_details = async (event) => {
      file.value = event.target.files[0]; // Get the first selected file
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

    const closeSeeekerSkillDetail = () => {
      skillModelStatus.value = false;
    };

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
    const downloadPDF = async () => {
      const seeker_id = localStorage.getItem("seeker_id");
      const response = await axios.post(`${apiUrl}/seeker-profile`, {
        seeker_id,
      });
      console.log("response", response);
      resume.value = response.data.seeker_details.resume;
      const fileName = resume.value;
      const fileUrl = `https://shreyanjobs.com/backend/public/pdf/${fileName}`;
      // const fileUrl = `http://127.0.0.1:8000/pdf/${fileName}`;

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
    const closeOtpModel = () => {
      showOtpModel.value = false;
    };

    const handleButtonClick = () => {
      router.push("/admin-login");
    };

    const seekerLogin = () => {
      router.push("/seeker-login");
    };
    const openModel = (job_id, employer_id) => {
      isActive.value = !isActive.value;
      jobOriginalId.value = job_id;
      jobOriginalEmployerId.value = employer_id;
    };

    const openConsultantModel = (job_id) => {
      jobOriginalId.value = job_id;

      isActiveConsultant.value = !isActiveConsultant.value;
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
    const getSeekerDeatails = async () => {
      const seeker_id = localStorage.getItem("seeker_id");
      const response = await axios.post(`${apiUrl}/seeker-profile`, {
        seeker_id,
      });
      resume.value = response.data.seeker_details.resume;

      const skill_data = await axios.post(`${apiUrl}/seeker-skill`, {
        seeker_id: seeker_id,
      });

      if (
        skill_data.data.skill_details == null ||
        skill_data.data.skill_details == ""
      ) {
        skillModelStatus.value = true;
      }
    };

    const jobmail = async (job_id, employer_id) => {
      console.log("resume", job_id);
      // if(resume.value )
      try {
        //const job_id = router.params.id;
        console.log("jobsjobs-==>>", jobs.value);
        const seeker_id = localStorage.getItem("seeker_id");
        const formData = new FormData();
        formData.append("pdf", file.value ? file.value : resume.value);
        formData.append("employer_id", employer_id);
        formData.append("seeker_id", seeker_id);
        formData.append("id", job_id);
        formData.append("cover_letter", cover_letter.value);
        isLoading.value = true;
        await axios
          .post(`${apiUrl}/apply-job-email`, formData, {
            headers: {
              "Content-Type": "multipart/form-data",
            },
          })
          .then((response) => {
            console.log(response);
            localStorage.setItem("mailSentMessage", true);
            localStorage.setItem("mailSentMessageStatus", true);
            isLoading.value = false;

            window.location.reload();
          })
          .catch((error) => {
            console.error(error);
          });
      } catch (error) {
        console.error(error);
      }
      // console.log("hffhff", employer_id);
    };

    function handleCheckboxChange(consultantId) {
      const index = selectedConsultants.value.indexOf(consultantId);

      if (index === -1) {
        selectedConsultants.value.push(consultantId);
      } else {
        selectedConsultants.value.splice(index, 1);
      }
    }

    const consultantJobmail = async (job_id) => {
      if (selectedConsultants.value.length > 0) {
        console.log(
          selectedConsultants.value,
          "selectedConsultantsselectedConsultants"
        );
      } else {
        alert("Please select atleast one Consultant");
        return false;
      }

      isLoading.value = true;

      const recruiter_id = localStorage.getItem("recruiter_id");

      const response = await axios.post(`${apiUrl}/consultants-job-appply`, {
        consultant_ids: selectedConsultants.value,
        job_id: job_id,
        recruiter_id: recruiter_id,
        consultants_cover_letter: consultants_cover_letter.value,
      });
      consultants_cover_letter.value = "";
      isLoading.value = false;
      isActiveConsultant.value = !isActiveConsultant.value;

      console.log(response, "responseresponseresponse");
    };

    const employerLogout = async () => {
      try {
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
        isLoading.value = true;
        const response = await axios.post(
          `${apiUrl}/employer-logout`,
          null,
          config
        );
        localStorage.removeItem("employer_tocken");
        localStorage.removeItem("employer_id");
        isLoading.value = false;

        console.log(response.data, "responseresponse");
        window.location.reload();
        console.log(response);
      } catch (error) {
        console.log(error);
      }
    };
    const fetchConsultants = async () => {
      const recruiter_id = localStorage.getItem("recruiter_id");
      const response = await axios.post(`${apiUrl}/active-consultants-data`, {
        recruiter_id: recruiter_id,
      });
      consultants_data.value = response.data.consultantas_details;
      console.log(response);
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
        console.log(response.data.message.length,'response.data.message');

        window.location.reload();

        console.log(response);
      } catch (error) {
        console.log(error);
      }
    };
    const consultantLogout = async () => {
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
          setTimeout(() => {
            router.push("/recruiter-login");
          }, 1000);
        }

        console.log(response);
      } catch (error) {
        console.log(error);
      }
    };

    const addSeeekerSkillDetail = debounce(async () => {
      const seeker_id = localStorage.getItem("seeker_id");

      if (skillInput.value == null || skillInput.value == "") {
        err_skill.value = "The skill field is required";
        return false;
      } else {
        err_skill.value = "";
      }

      var skillRegex = /^[^\s@]+@[^\s@]+\.[^\s@]+$/;
      if (skillRegex.test(skillInput.value) == true) {
        err_skill.value =
          "Do not enter your email here. Please specify only one skill to get email notification";
        return false;
      } else {
        err_skill.value = "";
      }

      var commaPattern = /,/;
      if (commaPattern.test(skillInput.value) == true) {
        err_skill.value =
          "Comma (,) is not allowed. Please specify ONLY one skill to get email notification";
        return false;
      } else {
        err_skill.value = "";
      }

      const formData = new FormData();
      formData.append("skill", skillInput.value);
      formData.append("seeker_id", seeker_id);
      const response = await axios.post(`${apiUrl}/seeker-skill-add`, formData);
      skillModelStatus.value = false;

      console.log("response", response);
      console.log(skillInput.value, "skillInput1sskillInput1s");
    });

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
        const total = await axios.get(`${apiUrl}/total-data`);
        total_seeker.value = total.data.total_seeker;
        total_employer.value = total.data.total_employer;
        total_bench_sales_recruiters.value =
          total.data.total_bench_sales_recruiters;
        seeker_display_profile_type.value =
          total.data.seeker_display_profile_type;
        employer_display_profile_type.value =
          total.data.employer_display_profile_type;
        recruiters_display_profile_type.value =
          total.data.recruiters_display_profile_type;

        console.log("total", total.data.total_seeker);
        jobStatus.value = true;
        jobs.value = response.data;
        jobs.value.forEach((job) => {
          job.applied = false;

          job.seekerdata.forEach((job_apply) => {
            if (job_apply.seeker_id == seekerLoggedId.value) {
              job.applied = true;
            }
          });
        });

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

    watch(cover_letter, (newValue) => {
      if (cover_letter.value.length > 200) {
        // Trim the excess characters
        cover_letter.value = cover_letter.value.substring(0, 200);
      }

      if (newValue != null) {
        remaining_cover_detail.value = 200 - newValue.length;
      }
    });

    watch(consultants_cover_letter, (newValue) => {
      if (consultants_cover_letter.value.length > 200) {
        // Trim the excess characters
        consultants_cover_letter.value =
          consultants_cover_letter.value.substring(0, 200);
      }

      if (newValue != null) {
        remaining_cover_detail.value = 200 - newValue.length;
      }
    });

    onMounted(() => {
      // countries_state.value = Country.getAllCountries();
      countries_state.value = someCountry.value;

      const recruiter_id = localStorage.getItem("recruiter_id");

      if (recruiter_id != null) {
        fetchConsultants();
      }

      console.log(countries_state.value, "countries_state");
      const seeker_id = localStorage.getItem("seeker_id");
      if (seeker_id != null) {
        getSeekerDeatails();
      }
      seekerLoggedId.value = localStorage.getItem("seeker_id");
      fetchCountries();
      fetchJobs();

      employer_id.value = localStorage.getItem("employer_id");

      mailSentMessage.value = localStorage.getItem("mailSentMessage");
      mailSentMessageStatus.value = localStorage.getItem(
        "mailSentMessageStatus"
      );

      if (mailSentMessage.value && !mailSentMessageStatus.value) {
        localStorage.setItem("mailSentMessageStatus", true);
      }

      if (mailSentMessage.value && mailSentMessageStatus) {
        localStorage.setItem("mailSentMessageStatus", false);
      }
    });
    return {
      seeker_display_profile_type,
      employer_display_profile_type,
      recruiters_display_profile_type,
      consultantJobmail,
      handleCheckboxChange,
      consultants_data,
      fetchConsultants,
      isActiveConsultant,
      openConsultantModel,
      consultantLogout,
      total_seeker,
      total_bench_sales_recruiters,
      total_employer,
      total,
      err_skill,
      deletePostId,
      deletePost,
      closeDeletePostModel,
      openDeletePostModel,
      deletePostConfirmation,
      closeSeeekerSkillDetail,
      skillModelStatus,
      skillInput1s,
      skillInput,
      addSeeekerSkillDetail,
      employerLogout,
      mailSentMessageStatus,
      mailSentMessage,
      remaining_cover_detail,
      downloadPDF,
      jobOriginalId,
      jobOriginalEmployerId,
      seekerLoggedId,
      file,
      image_details,
      cover_letter,
      consultants_cover_letter,
      jobmail,
      getSeekerDeatails,
      resume,
      openModel,
      isActive,
      employer_id,
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
      employer_role,
      isSeekerLogged,
      isRecruiterLogged,
      fullname,
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
.menu-button {
  border: 1px solid #1890da;
  background-color: #fff;
  color: #1890da;
  padding: 7px 15px;
  margin-bottom: 5px; /* Adjust the spacing between buttons */
  border-radius: 26px;
  font-weight: bold;
  cursor: pointer;
  outline: none;
  transition: background-color 0.3s, color 0.3s;
}

.menu-button:hover {
  background-color: #f7f7f9;
  color: #1890da;
}

/* Media query for mobile devices */
@media screen and (max-width: 767px) {
  .menu-button {
    width: 100%; /* Make buttons full width on small screens */
  }

  /* Style for the vertical logo */
  .flex img {
    max-width: 100%;
    height: auto;
  }

  .sm\:order-2 {
    order: 1;
  }

  .sm\:order-1 {
    order: 2;
  }
}
.flex {
  display: flex;
}
@media (max-width: 767px) {
  .flex {
    flex-direction: column; /* Change flex direction to column */
  }
}
</style>
