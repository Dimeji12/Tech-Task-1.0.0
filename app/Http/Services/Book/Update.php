<?php

namespace App\Http\Services\Book;

use App\Models\Book;

class Update
{
    public function __invoke(array $data, Book $book)
    {
        $genres = $data['genre_ids'] ?? null;

        unset($data['genre_ids']);

        $book->update($data);

        if ($genres !== null) {
            $book->genres()->sync($genres);
        }

        return $book;
    }
}
