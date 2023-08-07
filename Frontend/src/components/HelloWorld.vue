<template>
  <div class="bg-gray-200 p-4 border border-gray-300 rounded-lg items-center justify-center h-screen">
    <div class="bg-white rounded-lg shadow p-4 mb-4">
      <!-- Button on the right side -->
      <div class="flex items-center justify-end">
        <button
          class="bg-blue-500 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded focus:outline-none focus:shadow-outline"
          @click="handleButtonClick"
        >
          Admin Login
        </button>
      </div>

      <!-- Search input in the middle -->
      <div class="flex items-center justify-center mt-4">
        <input
          class="border border-gray-400 rounded-lg py-2 px-4 focus:outline-none focus:shadow-outline"
          type="text"
          v-model="searchInput"
          placeholder="Job Search"
        />
      </div>

      <!-- Form with two parts -->
      <div class="mt-4 flex flex-col">
        <!-- First part of the form -->
        <div class="flex">
          <div class="flex w-[50%]">
              <label class="block text-gray-700 font-bold mb-2 w-24" for="field1">
             Country
          </label>
          <input
            class="border border-gray-400 rounded-lg py-2 px-4 mb-4 focus:outline-none focus:shadow-outline w-[45%]"
            type="text"
            id="field1"
            v-model="field1Value"
          />
          </div>

          <div class="flex w-[50%]">
              <label class="block text-gray-700 font-bold mb-2 w-52" for="field2">
            Field 2
          </label>
          <select
            class="border border-gray-400 rounded-lg py-2 px-4 mb-4 focus:outline-none focus:shadow-outline"
            id="field2"
            v-model="field2Value"
          >
            <option value="">Select an option</option>
            <option value="option1">Option 1</option>
            <option value="option2">Option 2</option>
            <option value="option3">Option 3</option>
          </select>
          </div>
        </div>

        <!-- Second part of the form -->
        <div class="sm:w-1/2">
          <label class="block text-gray-700 font-bold mb-2" for="field3">
            Field 3
          </label>
          <select
            class="border border-gray-400 rounded-lg py-2 px-4 mb-4 focus:outline-none focus:shadow-outline"
            id="field3"
            v-model="field3Value"
          >
            <option value="">Select an option</option>
            <option value="optionA">Option A</option>
            <option value="optionB">Option B</option>
            <option value="optionC">Option C</option>
          </select>

          <label class="block text-gray-700 font-bold mb-2" for="field4">
            Field 4
          </label>
          <input
            class="border border-gray-400 rounded-lg py-2 px-4 mb-4 focus:outline-none focus:shadow-outline"
            type="text"
            id="field4"
            v-model="field4Value"
          />
        </div>
      </div>

      <!-- Two text areas -->
      <div class="mt-4">
        <label class="block text-gray-700 font-bold mb-2" for="textArea1">
          Text Area 1
        </label>
        <textarea
          class="border border-gray-400 rounded-lg py-2 px-4 mb-4 focus:outline-none focus:shadow-outline"
          id="textArea1"
          v-model="textArea1Value"
          rows="4"
        ></textarea>

        <label class="block text-gray-700 font-bold mb-2" for="textArea2">
          Text Area 2
        </label>
        <textarea
          class="border border-gray-400 rounded-lg py-2 px-4 mb-4 focus:outline-none focus:shadow-outline"
          id="textArea2"
          v-model="textArea2Value"
          rows="4"
        ></textarea>
      </div>
    </div>
  </div>
</template>

<script>
export default {
  data() {
    return {
      field1Value: "",
      field2Value: "",
      field3Value: "",
      field4Value: "",
      searchInput: "",
      textArea1Value: "",
      textArea2Value: "",
    };
  },
  methods: {
    handleButtonClick() {
      // Your button click logic here
    },
  },
};
</script>

<style>
/* Add any custom styles here if needed */
</style>
