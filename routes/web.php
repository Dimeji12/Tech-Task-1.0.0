<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Models\Book;
use App\Http\Controllers\BookController;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here you can register web routes for your application. These routes
| typically return views and are assigned the "web" middleware group.
|
*/


Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});

     // Show all books on the homepage (Blade view)
Route::get('/', function () {
    return view('welcome', [
        'books' => Book::all(),
    ]);
});

// Show edit form for a single book
Route::get('/books/{book}/edit', function (Book $book) {
    return view('edit', [
        'book' => $book,
    ]);
});

//       Handle book update form submission (PUT request)
Route::put('/books/{book}', [BookController::class, 'update']);

// Handle deleting a book (DELETE request)
Route::delete('/books/{book}', [BookController::class, 'destroy']);
