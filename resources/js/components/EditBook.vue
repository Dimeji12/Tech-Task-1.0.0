<template>
  <div>
    <div class="bg-gray-800 pt-8 pb-20">
      <div class="w-9/12 text-center mr-auto ml-auto -mt-0 mb-0">
        <h1 class="text-orange text-5xl p-10">Book Shop</h1>
        <p class="w-9/12 mr-auto ml-auto -mt-0 mb-0 text-white">
          Cupcake ipsum dolor sit amet croissant. I love topping candy canes sweet roll croissant caramels. 
          Soufflé macaroon liquorice chocolate tart I love.
        </p>
      </div>
    </div>
    <div class="bg-white py-12">
      <div class="w-1/3 text-left mr-auto ml-auto -mt-0 mb-0">
        <form @submit.prevent="submitForm">
          <div class="pt-10">
            <h2 class="text-center text-3xl pb-10">Edit Book</h2>
            <div class="pb-10">
              <label class="w-20 inline-block font-semibold">Title: </label>
              <input
                v-model="form.title"
                type="text"
                class="rounded-md border-gray-400 border-solid border-[1px] p-3 w-96 text-lg"
              />
            </div>
            <div class="pb-10">
              <label class="w-20 inline-block font-semibold">Author: </label>
              <input
                v-model="form.author"
                type="text"
                class="rounded-md border-gray-400 border-solid border-[1px] p-3 w-96 text-lg"
              />
            </div>
            <div class="pb-10">
              <label class="w-20 inline-block font-semibold">Rating: </label>
              <input
                v-model="form.rating"
                type="number"
                min="1"
                max="10"
                class="rounded-md border-gray-400 border-solid border-[1px] p-3 w-96 text-lg"
              />
            </div>
          </div>
          <div class="text-center">
            <button
              class="text-white bg-orange hover:bg-orange-600 py-3 px-8 rounded text-lg font-semibold transition"
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
export default {
  name: 'EditBook',
  props: {
    book: {
      type: Object,
      required: true
    }
  },
  data() {
    return {
      form: {
        title: this.book.title,
        author: this.book.author,
        rating: this.book.rating
      }
    }
  },
  methods: {
    async submitForm() {
      try {
        const response = await fetch(`/books/${this.book.id}`, {
          method: 'PUT',
          headers: {
            'Content-Type': 'application/json',
            'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content,
            'Accept': 'application/json'
          },
          body: JSON.stringify(this.form)
        });
        
        if (response.ok) {
          window.location.href = '/';
        } else {
          const errorData = await response.json();
          alert(`Error: ${errorData.message || 'Failed to update book'}`);
        }
      } catch (error) {
        console.error('Error updating book:', error);
        alert('An error occurred while updating the book');
      }
    }
  }
}
</script>