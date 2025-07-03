<?php

namespace Tests\Feature;

use Tests\TestCase;
use App\Models\Book;
use Illuminate\Foundation\Testing\RefreshDatabase;

class BookUpdateTest extends TestCase
{
    use RefreshDatabase; // Refreshes the database before each test

            // Test for successfully updating a book
    public function test_book_update()
    {
    // Create a sample book with a rating of 5
        $book = Book::factory()->create(['rating' => 5]);

    // Send PUT request to update the book's details
        $response = $this->putJson("/api/books/{$book->id}", [
            'title' => 'Updated Title',
            'author' => 'Updated Author',
            'rating' => 8,
        ]);

// Assert response is successful and contains updated data
        $response->assertStatus(200)
            ->assertJson([
                'message' => 'Successfully updated the book.',
                'data' => [
                    'title' => 'Updated Title',
                    'author' => 'Updated Author',
                    'rating' => 8,
                ],
            ]);

// Check that the updated data exists in the database
        $this->assertDatabaseHas('books', [
            'id' => $book->id,
            'title' => 'Updated Title',
            'rating' => 8,
        ]);
    }

    // Test for validation errors when updating a book
    public function test_book_update_validation()
    {
    // Create a sample book
        $book = Book::factory()->create();

    // Test submitting no data — should fail required field validation
        $response = $this->putJson("/api/books/{$book->id}", []);
        $response->assertStatus(422) // Unprocessable Entity
            ->assertJsonValidationErrors(['title', 'author', 'rating']);

    // Test submitting an invalid rating — should fail rating validation
        $response = $this->putJson("/api/books/{$book->id}", [
            'title' => 'Title',
            'author' => 'Author',
            'rating' => 11, // Rating exceeds the allowed range
        ]);
        $response->assertStatus(422)
            ->assertJsonValidationErrors(['rating']);
    }
}
