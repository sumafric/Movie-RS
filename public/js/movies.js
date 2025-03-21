document.addEventListener("DOMContentLoaded", function () {
    let searchInput = document.getElementById("search");
    let genreFilter = document.getElementById("genre-filter");

    // Debounce function to limit rapid API calls
    let debounceTimer;
    function debounce(func, delay = 500) {
        clearTimeout(debounceTimer);
        debounceTimer = setTimeout(func, delay);
    }

    function handleSearch() {
        debounce(() => fetchMovies(searchInput.value.trim(), genreFilter.value), 500);
    }

    function handleGenreChange() {
        fetchMovies(searchInput.value.trim(), genreFilter.value);
    }

    searchInput.addEventListener("input", handleSearch);
    genreFilter.addEventListener("change", handleGenreChange);

    // Initial Fetch
    fetchMovies();
});

function fetchMovies(query = "", genre = "", page = 1) {
    let url = new URL("/api/movies", window.location.origin);
    if (query) url.searchParams.append("query", query);
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

function renderMovies(movies) {
    let movieContainer = document.getElementById("movies");
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
