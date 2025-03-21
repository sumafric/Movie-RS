<?php

namespace App\Services;

use Illuminate\Support\Facades\Http;

class OMDbService
{
    protected string $apiKey;
    protected string $baseUrl;

    public function __construct()
    {
        $this->apiKey = config('services.omdb.api_key');
        $this->baseUrl = config('services.omdb.base_url');
    }

    public function searchMovies(string $title)
    {
        $response = Http::get($this->baseUrl, [
            'apikey' => $this->apiKey,
            's' => $title
        ]);

        return $response->json()['Search'] ?? [];
    }

    public function fetchMovieDetails(string $imdbId)
    {
        $response = Http::get($this->baseUrl, [
            'apikey' => $this->apiKey,
            'i' => $imdbId
        ]);

        return $response->json();
    }
}
