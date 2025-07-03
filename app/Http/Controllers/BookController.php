<?php

namespace App\Http\Controllers;

use App\Models\Genre;
use Illuminate\Http\Request;
use App\Http\Requests\Book\DestroyRequest;
use App\Http\Requests\Book\IndexRequest;
use App\Http\Requests\Book\StoreRequest;
use App\Http\Requests\Book\UpdateRequest;
use App\Http\Services\Book\Destroy;
use App\Http\Services\Book\Index;
use App\Http\Services\Book\Store;
use App\Http\Services\Book\Update;
use App\Models\Book;

class BookController extends Controller
{
    // Fetch a list of all books
    public function index(IndexRequest $request, Index $index)
    {
        return response()->json([
            'message' => 'Successfully fetched the books.',
            'data' => $index()
        ]);
    }

    // Store a new book
    public function store(StoreRequest $request, Store $store)
    {
        $book = $store($request->validated());

        return response()->json([
            'message' => 'Successfully stored the book.',
            'data' => $book
        ]);
    }





   // Handle the update of an existing book record. This method receives validated input from the UpdateRequest,
   // uses the Update service class to apply changes to the given Book model,
   // and then returns a JSON response with a success message and the updated book data.
   public function update(UpdateRequest $request, Update $update, Book $book)
{
 //This will  Call the update service to update the book
    $updatedBook = $update($request->validated(), $book);

// This will return success response with updated book data
    return response()->json([
        'message' => 'Successfully updated the book.',
        'data' => $updatedBook
    ]);
}





    // Delete a book
    public function destroy(DestroyRequest $request, Destroy $destroy, Book $book)
    {
        $destroy($book);

        return response()->json([
            'message' => 'Successfully deleted the book.',
        ]);
    }
}