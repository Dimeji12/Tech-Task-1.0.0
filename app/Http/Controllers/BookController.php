<?php

namespace App\Http\Controllers;

use App\Models\Book;
use Illuminate\Http\Request;
use App\Http\Requests\Book\DestroyRequest;
use App\Http\Requests\Book\IndexRequest;
use App\Http\Requests\Book\StoreRequest;
use App\Http\Requests\Book\UpdateRequest;
use App\Http\Services\Book\Destroy;
use App\Http\Services\Book\Index;
use App\Http\Services\Book\Store;
use App\Http\Services\Book\Update;

class BookController extends Controller
{
    // List all books
    public function index(IndexRequest $request, Index $index)
    {
        return response()->json([
            'message' => 'Successfully fetched the books.',
            'data' => $index()
        ]);
    }

    // Create a new book and associate genres (if provided)
    public function store(StoreRequest $request, Store $store)
    {
        $validated = $request->validated();
        $book = $store($validated);

        // Attach genres to the newly created book
        if (isset($validated['genre_ids'])) {
            $book->genres()->sync($validated['genre_ids']);
        }

        return response()->json([
            'message' => 'Successfully stored the book.',
            'data' => $book->load('genres')
        ]);
    }

                     // Update an existing book and sync associated genres
    public function update(UpdateRequest $request, Update $update, Book $book)
    {
                 // Validate incoming request data
        $validated = $request->validated();

// Use the Update service to update the book's core fields
        $updatedBook = $update($validated, $book);

    //If genres are provided sync them with the book
        if (isset($validated['genre_ids'])) {
            $updatedBook->genres()->sync($validated['genre_ids']);
        }

        // Return the updated book with its genres
        return response()->json([
            'message' => 'Successfully updated the book.',
            'data' => $updatedBook->load('genres')
        ]);
    }

    // Delete a book record
    public function destroy(DestroyRequest $request, Destroy $destroy, Book $book)
    {
        $destroy($book);

        return response()->json([
            'message' => 'Successfully deleted the book.',
        ]);
    }
}
