<template>
  <div>
    <!-- Header -->
    <div class="bg-gray-800 pt-8 pb-20">
      <div class="w-9/12 text-center mx-auto">
        <h1 class="text-orange text-5xl p-10">Book Shop</h1>
        <p class="w-9/12 mx-auto text-white">
          Cupcake ipsum dolor sit amet croissant. I love topping candy canes sweet roll croissant caramels. 
          Soufflé macaroon liquorice chocolate tart I love.
        </p>
      </div>
    </div>

    <!-- Form Section -->
    <div class="bg-white py-12">
      <div class="w-full max-w-lg mx-auto">
        <form @submit.prevent="submitForm" class="px-4">
          <!-- Form Title -->
          <h2 class="text-center text-3xl mb-10">Edit Book</h2>

          <!-- Form Fields Wrapper -->
          <div class="-ml-12">
            <!-- Title Field -->
            <div class="flex items-start gap-6 mb-6">
              <label class="w-28 text-right font-semibold text-gray-700 pt-2">Title:</label>
              <input
                v-model="form.title"
                type="text"
                class="flex-1 rounded border border-gray-300 p-2 text-base focus:outline-none focus:ring-2 focus:ring-orange-500"
              />
            </div>

            <!-- Author Field -->
            <div class="flex items-start gap-6 mb-6">
              <label class="w-28 text-right font-semibold text-gray-700 pt-2">Author:</label>
              <input
                v-model="form.author"
                type="text"
                class="flex-1 rounded border border-gray-300 p-2 text-base focus:outline-none focus:ring-2 focus:ring-orange-500"
              />
            </div>

            <!-- Rating Field -->
            <div class="flex items-start gap-6 mb-10">
              <label class="w-28 text-right font-semibold text-gray-700 pt-2">Rating:</label>
              <input
                v-model="form.rating"
                type="number"
                min="1"
                max="10"
                class="flex-1 rounded border border-gray-300 p-2 text-base focus:outline-none focus:ring-2 focus:ring-orange-500"
              />
            </div>
          </div>

          <!-- Submit Button -->
          <div class="text-center mt-6">
            <button
              class="bg-orange text-white hover:bg-orange-600 py-2 px-6 rounded text-lg font-semibold transition"
              type="submit"
            >
              Submit
            </button>
          </div>
        </form>
      </div>
    </div>
  </div>
</template>

<script>
import { useEditBook } from '../useEditBook.js';

export default {
  name: 'EditBook',
  props: {
    book: {
      type: Object,
      required: true
    }
  },
  data() {
    // Initialize form data and method from external logic file
    return useEditBook(this.book);
  }
};
</script>
