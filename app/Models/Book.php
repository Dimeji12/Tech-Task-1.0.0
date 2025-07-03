<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory; // For using model factories (useful in testing/seeding)
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes; // Allows soft deleting (records are not permanently removed)

class Book extends Model
{
    use HasFactory, SoftDeletes;

    protected $guarded = []; 
}
