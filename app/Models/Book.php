<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Book extends Model
{
    use HasFactory, SoftDeletes;

    // Allow mass assignment for all fields
    protected $guarded = [];

    
     // The genres that belong to the book.
     
    public function genres()
    {
        return $this->belongsToMany(Genre::class);
    }
}
