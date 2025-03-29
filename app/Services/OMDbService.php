<?php

namespace App\Services;

use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Cache;
use Illuminate\Http\Client\RequestException;

class OMDbService
{
    protected string $apiKey;
    protected string $baseUrl;

    public function __construct()
    {
        $this->apiKey = config('services.omdb.api_key');
        $this->baseUrl = config('services.omdb.base_url');
    }

    /**
     * Search movies by title
     */
    public function searchMovies(string $title): array
    {
        return Cache::remember("omdb_search_{$title}", now()->addHours(1), function () use ($title) {
            return $this->makeRequest(['s' => $title])['Search'] ?? [];
        });
    }

    /**
     * Fetch movie details by IMDb ID
     */
    public function fetchMovieDetails(string $imdbId): array
    {
        return Cache::remember("omdb_movie_{$imdbId}", now()->addHours(24), function () use ($imdbId) {
            return $this->makeRequest(['i' => $imdbId]);
        });
    }

    /**
     * Make an API request to OMDb
     */
    private function makeRequest(array $params): array
    {
        $params['apikey'] = $this->apiKey;

        try {
            $response = Http::get($this->baseUrl, $params);
            
            if ($response->failed()) {
                throw new RequestException($response);
            }

            return $response->json();
        } catch (\Exception $e) {
            return ['error' => 'Failed to retrieve data from OMDb'];
        }
    }
}
