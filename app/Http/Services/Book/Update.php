<?php

namespace App\Http\Services\Book;

use App\Models\Book;

class Update
{
    public function __invoke(array $data, Book $book): Book
    {
        $book->update($data);

        return $book;
    }
}
