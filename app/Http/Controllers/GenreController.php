<?php

namespace App\Http\Controllers;

use App\Models\Genre;
use Illuminate\Http\Request;

class GenreController extends Controller
{
    public function store(Request $request)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255|unique:genres'
        ]);
        
        $genre = Genre::create($validated);
        
        return response()->json([
            'message' => 'Genre created successfully',
            'data' => $genre
        ], 201);
    }
    
    public function attachToBook(Request $request, Book $book)
    {
        $validated = $request->validate([
            'genre_ids' => 'required|array',
            'genre_ids.*' => 'exists:genres,id'
        ]);
        
        $book->genres()->sync($validated['genre_ids']);
        
        return response()->json([
            'message' => 'Genres attached successfully',
            'data' => $book->load('genres')
        ]);
    }
}