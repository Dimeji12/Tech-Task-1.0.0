<?php

namespace Tests\Feature;

use Tests\TestCase;
use App\Models\Book;
use App\Models\Genre;
use Illuminate\Foundation\Testing\RefreshDatabase;

class BookUpdateTest extends TestCase
{
    use RefreshDatabase;

    /** @test */
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

    /** @test */
    public function test_book_update_validation()
    {
        $book = Book::factory()->create();

        // Missing required fields
        $response = $this->putJson("/api/books/{$book->id}", []);
        $response->assertStatus(422)
                 ->assertJsonValidationErrors(['title', 'author', 'rating']);

        // Invalid rating
        $response = $this->putJson("/api/books/{$book->id}", [
            'title' => 'Title',
            'author' => 'Author',
            'rating' => 11, // Exceeds max limit
        ]);
        $response->assertStatus(422)
                 ->assertJsonValidationErrors(['rating']);
    }

    /** @test */
    public function test_book_update_with_genres()
    {
        $book = Book::factory()->create();
        $genres = Genre::factory()->count(2)->create();

        $response = $this->putJson("/api/books/{$book->id}", [
            'title' => 'Updated Title with Genres',
            'author' => 'Updated Author',
            'rating' => 9,
            'genre_ids' => $genres->pluck('id')->toArray(),
        ]);

        $response->assertStatus(200)
                 ->assertJson([
                     'message' => 'Successfully updated the book.',
                     'data' => [
                         'title' => 'Updated Title with Genres',
                         'genres' => [
                             ['id' => $genres[0]->id],
                             ['id' => $genres[1]->id],
                         ],
                     ],
                 ]);

        foreach ($genres as $genre) {
            $this->assertDatabaseHas('book_genre', [
                'book_id' => $book->id,
                'genre_id' => $genre->id,
            ]);
        }
    }
}
