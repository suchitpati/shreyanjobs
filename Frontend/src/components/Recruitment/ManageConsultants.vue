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
              v-if="isRecruiterLogged == true"
              class="sm:w-full xs:w-auto w-[50%] xs:order-3 order-2 flex justify-end gap-[10px]"
            >
              <router-link to="/">
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
          class="flex items-center max-w-[980px] py-3 gap-6 w-[65%] mx-auto justify-between sm:pb-1 pb-10 md:w-full"
        >
          <div class="flex gap-10">
            <div class="flex items-center justify-center relative">
              <input
                class="rounded-[40px] md:py-[16px] sm:py-[15px] py-[12px] px-4 sm:pl-[60px] pl-[40px] focus:shadow-outline shadow-[0_25px_60px_rgba(113,106,147,.2)] w-[500px]"
                type="text"
                v-model="searchInput"
                @keyup.enter="fetchJobs"
                placeholder="Search jobs by skill or job Role"
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
          <div class="text-red-600 text-[16px]">
            welcome
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
          <div class="text-right">For any issue in accessing shreyanjobs.com</div>
          <div class="text-right">please email to support@shreyanjobs.com</div>
        </div>
      </div>


      <div
        class="fixed inset-0 flex items-center justify-center z-10"
        v-if="isLoading"
      >
        <div
          class="animate-spin rounded-full h-16 w-16 border-t-4 border-blue-500"
        ></div>
      </div>

      <div>
        <h2>Consultants List</h2>
        <button
                            class="bg-blue-500 hover:bg-blue-700 text-white font-bold py-2 px-8 mb-4 mt-4 rounded-full focus:outline-none focus:shadow-outline"
                            @click="updateProfile"
                        >
                            Add Consultants
                        </button>
      </div>

    </div>
  </template>

  <script>


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
