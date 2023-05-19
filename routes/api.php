<?php

use App\Http\Controllers\BookController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthenticationController;
use Illuminate\Routing\RouteGroup;
use App\Http\Controllers\ReviewController;
/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "api" middleware group. Make something great!
|
*/

// Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
//     return $request->user();
// });

Route::get('/books', 'App\Http\Controllers\BookController@index');
Route::get('/books/{id}', 'App\Http\Controllers\BookController@show');
Route::post('/login', 'App\Http\Controllers\AuthenticationController@login');

Route::middleware(['auth:sanctum'])->group(function() {

    //auth route
    Route::get('/logout', 'App\Http\Controllers\AuthenticationController@logout');
    Route::get('/me', 'App\Http\Controllers\AuthenticationController@me');

    //book route
    Route::post('/books', 'App\Http\Controllers\BookController@store');
    Route::patch('/books/{id}', 'App\Http\Controllers\BookController@update')->middleware('book-owner');
    Route::delete('/books/{id}', 'App\Http\Controllers\BookController@destroy')->middleware('book-owner');

    //review route
    Route::post('/review', 'App\Http\Controllers\ReviewController@store');
    Route::patch('/review/{id}', 'App\Http\Controllers\ReviewController@update')->middleware('review-owner');
    Route::delete('/review/{id}', 'App\Http\Controllers\ReviewController@destroy')->middleware('review-owner');
});