<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Genre extends Model
{
    use HasFactory;

    // Allow mass assignment for 'name' field
    protected $fillable = ['name'];

    
     // The books that belong to the genre.
     
    public function books()
    {
        return $this->belongsToMany(Book::class);
    }
}
