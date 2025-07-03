

export function useEditBook(book) {
  // Form state based on the passed book prop
  const form = {
    title: book.title,
    author: book.author,
    rating: book.rating
  };

  // Handles form submission and sends a PUT request to update the book
  async function submitForm() {
    try {
      const response = await fetch(`/books/${book.id}`, {
        method: 'PUT',
        headers: {
          'Content-Type': 'application/json',
          'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content,
          'Accept': 'application/json'
        },
        body: JSON.stringify(form)
      });

      if (response.ok) {
        // Redirect to homepage on success
        window.location.href = '/';
      } else {
        // Show specific error message if available
        const errorData = await response.json();
        alert(`Error: ${errorData.message || 'Failed to update book'}`);
      }
    } catch (error) {
      // Log unexpected errors for debugging
      console.error('Error updating book:', error);
      alert('An error occurred while updating the book');
    }
  }

  return { form, submitForm };
}
