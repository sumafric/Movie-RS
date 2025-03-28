<?php

namespace App\Http\Controllers;

use App\Models\Movie;
use Illuminate\Http\Request;
use App\Services\OMDbService;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Artisan;

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
            return abort(404, "Movie not found");
        }

        return view('show', compact('movie'));
    }


    public function searchMovies(Request $request)
    {
        $query = $request->input('title');

        if (!$query) {
            return response()->json(['error' => 'Search query required'], 400);
        }

        // Fetch new movies dynamically before searching
        Artisan::call("movies:fetch", ['query' => $query]);

        // Retrieve updated movies
        $movies = Movie::where('title', 'LIKE', "%$query%")->get();

        return response()->json(['movies' => $movies]);
    }


    /**
     * Get movie recommendations based on search.
     */
    public function getRecommendations(Request $request)
    {
        $query = Movie::query();

        if ($request->has('title') && !empty($request->title)) {
            $query->where('title', 'like', '%' . $request->title . '%');
        }

        if ($request->has('genre') && !empty($request->genre)) {
            $query->where('genres', 'LIKE', '%' . $request->genre . '%');
        }

        // Modify this logic for better recommendations (e.g., based on user preferences)
        $recommendations = $query->limit(5)->get();

        return response()->json([
            'recommendations' => $recommendations,
        ]);
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
