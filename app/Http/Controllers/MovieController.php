<?php

namespace App\Http\Controllers;

use App\Models\Movie;
use Illuminate\Http\Request;
use App\Services\OMDbService;
use Illuminate\Support\Facades\Log;

class MovieController extends Controller
{
    protected $omdbService;

    public function __construct(OMDbService $omdbService)
    {
        $this->omdbService = $omdbService;
    }

    public function index(Request $request)
{
    $perPage = 10;
    $movies = Movie::paginate($perPage);

    // Check and update missing details
    $movies->getCollection()->transform(function ($movie) {
        if (
            is_null($movie->overview) || 
            is_null($movie->poster_path) || 
            is_null($movie->release_date) || 
            is_null($movie->genres)
        ) {
            $this->updateMovieDetails($movie);
        }
        return $movie;
    });

    return view('movies', compact('movies'));
}


    public function show($imdbId)
    {
        $movie = Movie::where('imdb_id', $imdbId)->first();

        if (!$movie) {
            return response()->json(['error' => 'Movie not found'], 404);
        }

        // Fetch and update missing details
        $this->updateMovieDetails($movie);

        return response()->json($movie);
    }
//To be fixed
    public function searchMovies(Request $request)
{
    $query = Movie::query();

    if ($request->has('title') && !empty($request->title)) {
        $query->where('title', 'LIKE', '%' . $request->title . '%');
    }

    if ($request->has('genre') && !empty($request->genre)) {
        $query->where('genre', $request->genre);
    }

    return response()->json($query->get());
}

    private function updateMovieDetails(Movie $movie)
    {
        try {
            $movieData = $this->omdbService->fetchMovieDetails($movie->imdb_id);

            if ($movieData && !isset($movieData['Error'])) {
                $movie->overview = $movieData['Plot'] ?? $movie->overview;
                $movie->poster_path = $movieData['Poster'] ?? $movie->poster_path;
                $movie->release_date = $movieData['Released'] ?? $movie->release_date;
                $movie->genres = $movieData['Genre'] ?? $movie->genres;
                $movie->save();
            }
        } catch (\Exception $e) {
            Log::error("Error fetching movie details: " . $e->getMessage());
        }
    }
}
