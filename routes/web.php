<?php
use App\Http\Controllers\MovieController;
use Illuminate\Support\Facades\Route;


Route::get('/', function () {
    return view('welcome');
});

Route::prefix('api')->group(function () {
    Route::get('/movies', [MovieController::class, 'index']);
    //Route::get('/movies', [MovieController::class, 'searchMovies']);
    Route::get('/movies/{imdbId}', [MovieController::class, 'show']);
    
});