<?php

namespace App\Http\Requests\Book;

use Illuminate\Foundation\Http\FormRequest;

class UpdateRequest extends FormRequest
{
    // Allow all users to make this request
    public function authorize(): bool
    {
        return true;
    }

    // Validation rules for updating a book
    public function rules(): array
    {
        return [
            'title' => 'required|string|max:255',            // Book title is required
            'author' => 'required|string|max:255',           // Author name is required
            'rating' => 'required|integer|min:1|max:10',     // Rating must be between 1 and 10
            'genre_ids' => 'nullable|array',                 // Optional array of genre IDs
            'genre_ids.*' => 'exists:genres,id'              // Each ID must exist in genres table
        ];
    }
}
