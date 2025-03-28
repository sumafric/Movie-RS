@extends('layouts.app')

@section('content')
<div class="container">
    <h1>{{ $movie->title }} ({{ $movie->release_date }})</h1>

    <div class="row">
        <div class="col-md-4">
            <img src="{{ $movie->poster_path }}" alt="{{ $movie->title }}" class="img-fluid">
        </div>
        <div class="col-md-8">
            <p><strong>Plot:</strong> {{ $movie->overview ?? 'No plot available' }}</p>
            <p><strong>Genre:</strong> {{ $movie->genres }}</p>
            <p><strong>Rating:</strong> {{ $movie->rating }}</p>
        </div>
    </div>

    <a href="{{ url('/api/movies') }}" class="btn btn-primary mt-3">Back to Movies</a>
</div>
@endsection
