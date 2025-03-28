document.addEventListener("DOMContentLoaded", function () {
    let searchInput = document.getElementById("search");
    let genreFilter = document.getElementById("genre-filter");
    let searchButton = document.getElementById("search-button");
    let movieResults = document.getElementById("movie-results");
    let recommendationsContainer = document.getElementById("recommendations");

    // Debounce function to limit rapid API calls
    let debounceTimer;
    function debounce(func, delay = 500) {
        clearTimeout(debounceTimer);
        debounceTimer = setTimeout(func, delay);
    }

    function handleSearch() {
        debounce(() => {
            let query = searchInput.value.trim();
            let genre = genreFilter.value;
            fetchMovies(query, genre);
            fetchRecommendations(query, genre);
        }, 500);
    }

    function handleGenreChange() {
        let query = searchInput.value.trim();
        let genre = genreFilter.value;
        fetchMovies(query, genre);
        fetchRecommendations(query, genre);
    }

    searchButton.addEventListener("click", handleSearch);
    searchInput.addEventListener("input", handleSearch);
    genreFilter.addEventListener("change", handleGenreChange);

    // Initial Fetch
    fetchMovies();
});

// Fetch movies based on search and genre
function fetchMovies(query = "", genre = "", page = 1) {
    let url = new URL("/api/movies/search", window.location.origin);
    if (query) url.searchParams.append("title", query);
    if (genre) url.searchParams.append("genre", genre);
    url.searchParams.append("page", page);

    fetch(url)
        .then(response => response.json())
        .then(data => {
            renderMovies(data.movies);
            setupPagination(data.total_pages, page);
        })
        .catch(error => console.error("Error fetching movies:", error));
}

// Fetch recommendations based on search and genre
function fetchRecommendations(query, genre) {
    let url = new URL("/api/recommendations", window.location.origin);
    if (query) url.searchParams.append("title", query);
    if (genre) url.searchParams.append("genre", genre);

    fetch(url)
        .then(response => response.json())
        .then(data => {
            renderRecommendations(data.recommendations);
        })
        .catch(error => console.error("Error fetching recommendations:", error));
}

// Render movie search results
function renderMovies(movies) {
    let movieContainer = document.getElementById("movie-results");
    movieContainer.innerHTML = movies.length
        ? movies.map(movie => `
            <div class="movie-card">
                <h3>${movie.title}</h3>
                <img src="${movie.poster_path}" alt="${movie.title}" />
                <p>${movie.overview}</p>
            </div>
        `).join("")
        : "<p>No movies found.</p>";
}

// Render recommended movies
function renderRecommendations(recommendations) {
    let recommendationsContainer = document.getElementById("recommendations");
    recommendationsContainer.innerHTML = recommendations.length
        ? recommendations.map(movie => `
            <div class="movie-card">
                <h3>${movie.title}</h3>
                <img src="${movie.poster_path}" alt="${movie.title}" />
                <p>${movie.overview}</p>
            </div>
        `).join("")
        : "<p>No recommendations available.</p>";
}

// Pagination setup
function setupPagination(totalPages, currentPage) {
    let paginationContainer = document.getElementById("pagination");
    paginationContainer.innerHTML = "";

    for (let i = 1; i <= totalPages; i++) {
        let button = document.createElement("button");
        button.innerText = i;
        button.classList.add("page-button");
        if (i === currentPage) button.classList.add("active");

        button.addEventListener("click", function () {
            fetchMovies(document.getElementById("search").value.trim(),
                        document.getElementById("genre-filter").value, i);
        });
        paginationContainer.appendChild(button);
    }
}
