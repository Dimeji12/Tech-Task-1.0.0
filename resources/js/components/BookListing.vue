<template>
  <div>
    <!-- Header (matching Edit Book page style) -->
    <div class="bg-gray-800 pt-8 pb-20">
      <div class="w-9/12 text-center mr-auto ml-auto">
        <h1 class="text-orange text-5xl p-10">Book Shop</h1>
        <p class="w-9/12 mr-auto ml-auto text-white">
          Cupcake ipsum dolor sit amet croissant. I love topping candy canes sweet roll croissant caramels. 
          Soufflé macaroon liquorice chocolate tart I love.
        </p>
      </div>
    </div>

    <!-- Content -->
    <div class="bg-white py-12">
      <!-- Search -->
      <div class="w-9/12 mr-auto ml-auto mb-6 text-right">
        <input
          v-model="searchQuery"
          placeholder="Search by book title ..."
          class="w-full max-w-sm p-3 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-indigo-500"
        />
      </div>

      <!-- Table (compact with white grid lines) -->
      <div class="w-9/12 mr-auto ml-auto overflow-x-auto">
        <table class="min-w-full text-sm text-left border-collapse divide-y divide-white">
          <thead>
            <tr class="bg-gray-800 text-white divide-x divide-white">
              <th class="py-2 px-2 font-semibold border border-white">Title</th>
              <th class="py-2 px-2 font-semibold border border-white">Author</th>
              <th class="py-2 px-2 font-semibold border border-white">Rating</th>
              <th class="py-2 px-2 font-semibold border border-white">Actions</th>
            </tr>
          </thead>
          <tbody>
            <tr
              v-for="(book, index) in filteredBooks"
              :key="book.id"
              :class="index % 2 === 0 ? 'bg-gray-100' : 'bg-gray-200'"
              class="hover:bg-gray-300 divide-x divide-white"
            >
              <td class="py-2 px-2 text-gray-900 border border-white">{{ book.title }}</td>
              <td class="py-2 px-2 text-gray-700 border border-white">{{ book.author }}</td>
              <td class="py-2 px-2 text-gray-800 border border-white">{{ book.rating }}</td>
              <td class="py-2 px-2 border border-white">
                <div class="flex flex-col space-y-1">
                  <a
                    :href="`/books/${book.id}/edit`"
                    class="text-blue-800 underline font-medium hover:text-blue-600"
                  >
                    Edit
                  </a>
                  <button
                    @click="deleteBook(book.id)"
                    class="text-blue-800 underline font-medium hover:text-blue-600 text-left"
                  >
                    Delete
                  </button>
                </div>
              </td>
            </tr>
          </tbody>
        </table>

        <!-- No results -->
        <div
          v-if="filteredBooks.length === 0"
          class="py-12 text-center text-gray-500"
        >
          No books found matching your search
        </div>
      </div>
    </div>
  </div>
</template>

<script>
// Import the composition logic from separate JS file
import useBookListing from '../useBookListing'

export default {
  name: 'BookListing',
  props: {
    books: {
      type: Array,
      default: () => []
    }
  },
  setup(props, { emit }) {
    // Pass props and emit to composable to get reactive state and methods
    return useBookListing(props, emit)
  }
}
</script>
