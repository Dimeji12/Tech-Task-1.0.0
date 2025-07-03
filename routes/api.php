<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\BookController;
use App\Http\Controllers\GenreController;
use App\Models\Book;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/

// RESTful API resource routes for Book and Genre Controller
Route::apiResource('/books', BookController::class);
Route::post('/genres', [GenreController::class, 'store']);
Route::post('/books/{book}/genres', [GenreController::class, 'attachToBook']);
