<?php

namespace App\Http\Controllers;

use App\Models\Genre;
use App\Models\Book;
use Illuminate\Http\Request;

class GenreController extends Controller
{
    // This Store a new genre
    public function store(Request $request)
    {
      //This  Validates the incoming request data
        $validated = $request->validate([
            'name' => 'required|string|max:255|unique:genres'
        ]);
        
     // Create the genre with the validated data
        $genre = Genre::create($validated);
        
 // Return success response with the newly created genre
        return response()->json([
            'message' => 'Genre created successfully',
            'data' => $genre
        ], 201);
    }

// Attach genres to a specific book
    public function attachToBook(Request $request, Book $book)
    {
 // Validate the genre IDs from the request
        $validated = $request->validate([
            'genre_ids' => 'required|array', 
            'genre_ids.*' => 'exists:genres,id' 
        ]);
        
     // Attach the genres to the book (sync replaces existing associations)
        $book->genres()->sync($validated['genre_ids']);
        

        return response()->json([
            'message' => 'Genres attached successfully',
            'data' => $book->load('genres') 
            

        ]);
    }
}
