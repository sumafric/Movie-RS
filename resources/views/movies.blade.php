@extends('layouts.app')

@section('content')
<div>
    <input type="text" id="search" placeholder="Search movies...">
    <select id="genre-filter">
        <option value="">All Genres</option>
        <option value="Action">Action</option>
        <option value="Comedy">Comedy</option>
        <option value="Drama">Drama</option>
    </select>
</div>

<div class="movie-grid">
    @foreach ($movies as $movie)
        <div class="movie-card">
            <h3 class="movie-title">{{ $movie->title }}</h3>
            <img class="movie-image" src="{{ $movie->poster_path }}" alt="{{ $movie->title }}" />
            <p class="movie-info">{{ $movie->overview }}</p>
        </div>
    @endforeach
</div>


<div id="pagination">
    {{ $movies->links() }}
</div>

<script src="{{ asset('js/movies.js') }}"></script>
@endsection