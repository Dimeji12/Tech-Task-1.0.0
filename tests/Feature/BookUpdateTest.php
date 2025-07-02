<?php

namespace Tests\Feature;

use Tests\TestCase;
use App\Models\Book;
use Illuminate\Foundation\Testing\RefreshDatabase;

class BookUpdateTest extends TestCase
{
    use RefreshDatabase;

    public function test_book_update()
    {
        $book = Book::factory()->create(['rating' => 5]);

        $response = $this->putJson("/api/books/{$book->id}", [
            'title' => 'Updated Title',
            'author' => 'Updated Author',
            'rating' => 8,
        ]);

        $response->assertStatus(200)
            ->assertJson([
                'message' => 'Successfully updated the book.',
                'data' => [
                    'title' => 'Updated Title',
                    'author' => 'Updated Author',
                    'rating' => 8,
                ],
            ]);

        $this->assertDatabaseHas('books', [
            'id' => $book->id,
            'title' => 'Updated Title',
            'rating' => 8,
        ]);
    }

    public function test_book_update_validation()
    {
        $book = Book::factory()->create();

        // Test required fields validation fails
        $response = $this->putJson("/api/books/{$book->id}", []);
        $response->assertStatus(422)
            ->assertJsonValidationErrors(['title', 'author', 'rating']);

        // Test rating boundary validation fails
        $response = $this->putJson("/api/books/{$book->id}", [
            'title' => 'Title',
            'author' => 'Author',
            'rating' => 11,
        ]);
        $response->assertStatus(422)
            ->assertJsonValidationErrors(['rating']);
    }
}
