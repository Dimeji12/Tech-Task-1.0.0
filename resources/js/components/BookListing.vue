<template>
  <div class="container mx-auto p-6 max-w-6xl">
    <h1 class="text-3xl font-bold mb-4">Book Shop</h1>
    <p class="text-gray-700 mb-6">
      Cupcake ipsum dolor sit amet croissant. I love topping candy canes sweet roll croissant caramels. 
      Soufflé macaroon liquorice chocolate tart i love.
    </p>
    
    <div class="mb-6">
      <input
        v-model="searchQuery"
        placeholder="Search by book title ..."
        class="w-full p-3 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-indigo-500"
      />
    </div>

    <div class="overflow-x-auto">
      <table class="min-w-full bg-white rounded-lg overflow-hidden">
        <thead class="bg-gray-100">
          <tr>
            <th class="py-3 px-4 text-left font-semibold text-gray-700">Title</th>
            <th class="py-3 px-4 text-left font-semibold text-gray-700">Author</th>
            <th class="py-3 px-4 text-left font-semibold text-gray-700">Rating</th>
      
          </tr>
        </thead>
        <tbody class="divide-y divide-gray-200">
          <tr v-for="book in filteredBooks" :key="book.id" class="hover:bg-gray-50">
            <td class="py-4 px-4 text-gray-800 max-w-md">{{ book.title }}</td>
            <td class="py-4 px-4 text-gray-600">{{ book.author }}</td>
            <td class="py-4 px-4 text-gray-700">{{ book.rating }}</td>
            <td class="py-4 px-4">
              <div class="flex space-x-2">
                <a 
                  :href="`/books/${book.id}/edit`"
                  class="px-3 py-1 bg-blue-100 text-blue-700 rounded-md hover:bg-blue-200 transition"
                >
                  Edit
                </a>
                <button 
                  @click="deleteBook(book.id)"
                  class="px-3 py-1 bg-red-100 text-red-700 rounded-md hover:bg-red-200 transition"
                >
                  Delete
                </button>
              </div>
            </td>
          </tr>
        </tbody>
      </table>
      
      <div 
        v-if="filteredBooks.length === 0" 
        class="py-12 text-center text-gray-500"
      >
        No books found matching your search
      </div>
    </div>
  </div>
</template>

<script>
export default {
  props: {
    books: {
      type: Array,
      default: () => []
    }
  },
  data() {
    return {
      searchQuery: ""
    };
  },
  computed: {
    filteredBooks() {
      if (!this.searchQuery) return this.books;
      const query = this.searchQuery.toLowerCase();
      return this.books.filter(book => 
        book.title.toLowerCase().includes(query)
      );
    }
  },
  methods: {
    async deleteBook(id) {
      if (confirm('Are you sure you want to delete this book?')) {
        try {
          await fetch(`/books/${id}`, {
            method: 'DELETE',
            headers: {
              'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content,
              'Content-Type': 'application/json'
            }
          });
          this.$emit('book-deleted', id);
        } catch (error) {
          console.error('Error deleting book:', error);
        }
      }
    }
  }
};
</script>