<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Movie-RS</title>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/tailwindcss@2.2.19/dist/tailwind.min.css">
</head>
<body class="bg-gray-900 text-white flex items-center justify-center min-h-screen">
    <div class="text-center">
        <img src="/images/movie-logo.png"alt="Movie Logo" class="mx-auto w-32 h-32 animate-bounce">
        <h1 class="text-4xl font-bold mt-6">Someone Get the Popcorns!</h1>
        <p class="text-lg mt-3 text-gray-400">Discover movies you’ll love with our recommendation system.</p>
        <a href="{{ url('/api/movies') }}" class="mt-6 inline-block bg-red-600 px-6 py-3 rounded-full text-lg font-semibold hover:bg-red-700 transition">
            Let's Go
        </a>
    </div>
</body>
</html>
