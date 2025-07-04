<?php

namespace Tests\Feature;

use Tests\TestCase;
use App\Models\Book;
use App\Models\Genre;
use Illuminate\Foundation\Testing\RefreshDatabase;

class BookControllerTest extends TestCase
{
    use RefreshDatabase;

    /** @test */
    public function it_can_create_a_book_with_genres()
    {
        // Create some genres in the database
        $genres = Genre::factory()->count(2)->create();

        $payload = [
            'title' => 'Test Book',
            'author' => 'John Doe',
            'rating' => 8,
            'genre_ids' => $genres->pluck('id')->toArray(),
        ];

        $response = $this->postJson('/api/books', $payload);

        $response->assertStatus(200)
                 ->assertJsonStructure(['message', 'data' => ['id', 'title', 'author', 'rating', 'genres']]);

        // Assert book exists in database
        $this->assertDatabaseHas('books', ['title' => 'Test Book']);

        // Assert pivot table contains the book-genre relationships
        $bookId = $response->json('data.id');
        foreach ($payload['genre_ids'] as $genreId) {
            $this->assertDatabaseHas('book_genre', [
                'book_id' => $bookId,
                'genre_id' => $genreId,
            ]);
        }
    }

    /** @test */
    public function it_can_update_a_book_and_sync_genres()
    {
        // Setup: create book and genres
        $book = Book::factory()->create();

        $oldGenres = Genre::factory()->count(2)->create();
        $newGenres = Genre::factory()->count(2)->create();

        // Attach old genres
        $book->genres()->attach($oldGenres->pluck('id'));

        $payload = [
            'title' => 'Updated Title',
            'author' => 'Jane Doe',
            'rating' => 7,
            'genre_ids' => $newGenres->pluck('id')->toArray(),
        ];

        $response = $this->putJson("/api/books/{$book->id}", $payload);

        $response->assertStatus(200)
                 ->assertJsonFragment(['title' => 'Updated Title']);

        // Check book updated in database
        $this->assertDatabaseHas('books', [
            'id' => $book->id,
            'title' => 'Updated Title',
            'author' => 'Jane Doe',
            'rating' => 7,
        ]);

        // Check old genres removed and new genres attached in pivot table
        foreach ($oldGenres as $oldGenre) {
            $this->assertDatabaseMissing('book_genre', [
                'book_id' => $book->id,
                'genre_id' => $oldGenre->id,
            ]);
        }

        foreach ($newGenres as $newGenre) {
            $this->assertDatabaseHas('book_genre', [
                'book_id' => $book->id,
                'genre_id' => $newGenre->id,
            ]);
        }
    }
}
