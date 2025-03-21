<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\Services\OMDbService;
use App\Models\Movie;

class FetchMovies extends Command
{
    protected $signature = 'movies:fetch'; // No need for a movie parameter
    protected $description = 'Fetches trending movies from OMDb API and updates the database.';
    protected OMDbService $omdbService;

    public function __construct(OMDbService $omdbService)
    {
        parent::__construct();
        $this->omdbService = $omdbService;
    }

    public function handle()
    {
        // Instead of a hardcoded movie, fetch trending/popular ones
        $popularMovies = ['Avengers', 'Batman', 'Spiderman', 'Interstellar', 'Joker'];

        foreach ($popularMovies as $title) {
            $this->info("Fetching movies for: $title");
            $movies = $this->omdbService->searchMovies($title);

            foreach ($movies as $movie) {
                if (!isset($movie['imdbID'], $movie['Title'])) {
                    continue;
                }

                Movie::updateOrCreate(
                    ['imdb_id' => $movie['imdbID']],
                    [
                        'title' => $movie['Title'],
                        'year' => $movie['Year'] ?? null,
                        'poster' => $movie['Poster'] ?? null,
                        'type' => $movie['Type'] ?? 'movie',
                    ]
                );
            }
        }

        $this->info("Movies updated successfully!");
    }
}
