<?php

use App\Http\Controllers\MovieController;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('welcome');
});


Route::prefix('api')->group(function () {
    Route::get('/movies', [MovieController::class, 'index']);
    Route::get('/movies/search', [MovieController::class, 'searchMovies']);
    //Route::get('/movies/{title?}', [MovieController::class, 'searchMovies']);
    Route::get('/movies/{imdb_id}', [MovieController::class, 'show']);
    //Route::get('/movies/{imdb_id}', [MovieController::class, 'show'])->name('movies.show');
    Route::get('/recommendations', [MovieController::class, 'getRecommendations']);
});
