📚 API Documentation
This file outlines the endpoints available in the Book & Genre API, including expected requests, successful responses, and common errors.

✅ Available Endpoints
Method	Endpoint	Description
POST	/api/genres	Create a new genre
POST	/api/books/{book}/genres	Attach existing genres to a book

📘 Genre API Details
🔹 Create Genre
Endpoint:
POST /api/genres

Description:
Creates a new genre.

🔸 Request
json
Copy
Edit
{
  "name": "Science Fiction"
}
🔸 Successful Response (201 Created)
json
Copy
Edit
{
  "message": "Genre created successfully",
  "data": {
    "id": 1,
    "name": "Science Fiction",
    "created_at": "2023-07-15T10:00:00.000000Z",
    "updated_at": "2023-07-15T10:00:00.000000Z"
  }
}
🔹 Attach Genres to a Book
Endpoint:
POST /api/books/{book}/genres

Description:
Attaches one or more genres to a specific book by ID.

🔸 Request
json
Copy
Edit
{
  "genre_ids": [1, 2, 3]
}
🔸 Successful Response (200 OK)
json
Copy
Edit
{
  "message": "Genres attached successfully",
  "data": {
    "id": 1,
    "title": "Book Title",
    "author": "Book Author",
    "rating": 8,
    "created_at": "2023-07-15T10:00:00.000000Z",
    "updated_at": "2023-07-15T10:00:00.000000Z",
    "genres": [
      {
        "id": 1,
        "name": "Science Fiction",
        "pivot": {
          "book_id": 1,
          "genre_id": 1
        }
      },
      {
        "id": 2,
        "name": "Fantasy",
        "pivot": {
          "book_id": 1,
          "genre_id": 2
        }
      }
    ]
  }
}
⚠️ Error Response Examples
❌ 422 Unprocessable Entity (Validation Error)
json
Copy
Edit
{
  "message": "The given data was invalid.",
  "errors": {
    "name": [
      "The name field is required."
    ]
  }
}
❌ 404 Not Found (Invalid Book ID or Genre ID)
json
Copy
Edit
{
  "message": "Resource not found."
}
📝 Additional Notes
Ensure Accept: application/json is set in all API requests.

The many-to-many relationship between books and genres is handled via a pivot table (book_genre).

Use Laravel's route model binding to resolve {book} in the route.

Soft-deleted books will not be returned unless explicitly queried using withTrashed().