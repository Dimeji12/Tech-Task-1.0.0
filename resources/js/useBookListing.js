import { ref, computed } from 'vue'

/**
 * Composable logic for BookListing component.
 * Handles search filtering and book deletion.
 *
 * @param {Object} props - Component props including books array
 * @param {Function} emit - Vue emit function to notify parent components
 * @returns {Object} reactive state and methods for the component
 */
export default function useBookListing(props, emit) {
  // Reactive variable to store user's search query input
  const searchQuery = ref('')

  // Computed property: filters books by title based on searchQuery (case-insensitive)
  const filteredBooks = computed(() => {
    if (!searchQuery.value) return props.books
    const query = searchQuery.value.toLowerCase()
    return props.books.filter(book =>
      book.title.toLowerCase().includes(query)
    )
  })

  // Deletes a book by id after confirmation; emits event to parent to update list
  async function deleteBook(id) {
    if (!confirm('Are you sure you want to delete this book?')) return

    try {
      await fetch(`/books/${id}`, {
        method: 'DELETE',
        headers: {
          'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content,
          'Content-Type': 'application/json'
        }
      })
      // Notify parent component that a book has been deleted
      emit('book-deleted', id)
    } catch (error) {
      console.error('Error deleting book:', error)
      // In production, consider a better user-friendly error notification here
    }
  }

  return {
    searchQuery,
    filteredBooks,
    deleteBook
  }
}
