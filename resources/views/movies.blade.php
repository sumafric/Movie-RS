@extends('layouts.app')

@section('content')
<div class="search-box">
    <input type="text" id="search" placeholder="Search movies...">
    <select id="genre-filter">
        <option value="">All Genres</option>
        <option value="Action">Action</option>
        <option value="Comedy">Comedy</option>
        <option value="Drama">Drama</option>
    </select>
    <button id="search-button">Search</button>
</div>

<!-- Search Results -->
<h2>Search Results</h2>
<div class="movie-grid" id="movie-results">
    @foreach ($movies as $movie)
        <div class="movie-card">
            <a href="{{ url('/api/movies/{imdb_id}/', $movie->imdb_id) }}" class="movie-link">
                <h3 class="movie-title">{{ $movie->title }}</h3>
                <img class="movie-image" src="{{ $movie->poster_path }}" alt="{{ $movie->title }}" />
            </a>
            <p class="movie-info">{{ $movie->overview }}</p>
        </div>
    @endforeach
</div>

<!-- Recommendations -->
<h2>Recommended Movies</h2>
<div class="movie-grid" id="recommendations">
    <!-- Recommendations will be added dynamically -->
</div>

<script src="{{ asset('js/movies.js') }}"></script>
@endsection
