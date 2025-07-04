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

    // Create a new book with optional genres
    public function store(StoreRequest $request, Store $store)
    {
        $validated = $request->validated();
        $book = $store($validated);

        // Sync genres if provided
        if (isset($validated['genre_ids'])) {
            $book->genres()->sync($validated['genre_ids']);
        }

        return response()->json([
            'message' => 'Successfully stored the book.',
            'data' => $book->load('genres')
        ]);
    }

    // Update existing book + genres
    public function update(UpdateRequest $request, Update $update, Book $book)
    {
        $validated = $request->validated();
        $updatedBook = $update($validated, $book);

        // Sync genres if provided
        if (isset($validated['genre_ids'])) {
            $updatedBook->genres()->sync($validated['genre_ids']);
        }

        return response()->json([
            'message' => 'Successfully updated the book.',
            'data' => $updatedBook->load('genres')
        ]);
    }

    // Delete book
    public function destroy(DestroyRequest $request, Destroy $destroy, Book $book)
    {
        $destroy($book);

        return response()->json([
            'message' => 'Successfully deleted the book.',
        ]);
    }
}
