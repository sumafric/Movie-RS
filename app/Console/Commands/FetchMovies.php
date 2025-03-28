<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\Services\OMDbService;
use App\Models\Movie;

class FetchMovies extends Command
{
    protected $signature = 'movies:fetch {query}'; // No need for a movie parameter
    protected $description = 'Fetches trending movies from OMDb API and updates the database.';
    protected OMDbService $omdbService;

    public function __construct(OMDbService $omdbService)
    {
        parent::__construct();
        $this->omdbService = $omdbService;
    }

    public function handle()
    {
        $query = $this->argument('query'); // Get user search input

        if (!$query) {
            $this->error("Please provide a search query.");
            return;
        }

        $this->info("Fetching movies for: $query");
        $movies = $this->omdbService->searchMovies($query);

        if (!$movies) {
            $this->error("No movies found for query: $query");
            return;
        }

        foreach ($movies as $movie) {
            if (!isset($movie['imdbID'], $movie['Title'])) {
                continue;
            }

            Movie::updateOrCreate(
                ['imdb_id' => $movie['imdbID']],
                [
                    'title' => $movie['Title'],
                    'overview' => $movie['Plot'] ?? null, // Full movie plot
                    'poster_path' => $movie['Poster'] ?? null,
                    'rating' => $movie['imdbRating'] ?? '0.0',
                    'release_date' => $movie['Released'] ?? null,
                    'genres' => $movie['Genre'] ?? null, // Store genre
                ]
            );
        }

        $this->info("Movies updated successfully!");
    }
}
