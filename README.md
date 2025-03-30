# Movie-RS

Movie-RS is a **movie recommendation system** built with **Laravel 12** that suggests movies based on user preferences and allows users to view movie details, trailers, and streaming availability. The system integrates the **OMDb API** for metadata and the **JustWatch API** for streaming options.

## Features

-   🔍 **Search Functionality** – Users can search for movies by title.
-   🎭 **Genre-Based Filtering** – Movies can be filtered by genre.
-   📊 **Content-Based Recommendation System** – Recommends movies based on user preferences.
-   🎬 **Movie Details and Trailers** – Displays movie metadata using **OMDb API**.
-   🔐 **User Authentication** – Uses **Laravel Sanctum** for authentication.
-   📌 **Admin Panel** – Manage movies, users, and recommendations.

## Tech Stack

-   **Backend:** Laravel 12, MySQL
-   **Frontend:** Blade Templates, JavaScript
-   **APIs:** OMDb API
-   **Deployment:** Nginx (Live Server), Fly.io (Testing)

## Installation

### Prerequisites

-   PHP 8.2+
-   Composer
-   MySQL
-   Laravel 12

### Steps

1. Clone the repository:
    ```bash
    git clone https://github.com/yourusername/Movie-RS.git
    cd Movie-RS
    ```
2. Install dependencies:
    ```bash
    composer install
    ```
3. Set up environment variables:

    ```bash
    cp .env.example .env
    ```

    Update database credentials and API keys in `.env`:

    ```env
    DB_CONNECTION=mysql
    DB_HOST=127.0.0.1
    DB_PORT=3306
    DB_DATABASE=movie_rs
    DB_USERNAME=root
    DB_PASSWORD=yourpassword

    OMDB_API_KEY=your_omdb_api_key
    ```

4. Run migrations and seed database:
    ```bash
    php artisan migrate --seed
    ```
5. Generate the application key:
    ```bash
    php artisan key:generate
    ```
6. Start the development server:
    ```bash
    php artisan serve
    ```

## API Integration

### OMDb API

Used to fetch movie metadata like title, genre, plot, and ratings.

Example API request:

```bash
https://www.omdbapi.com/?apikey=YOUR_OMDB_API_KEY&t=Inception
```

## Usage

1. **User Flow:**

    - Users register/login.
    - Search for movies or browse recommended movies.
    - Click on a movie to view details, trailers, and streaming options.
    - Navigate to official streaming providers via JustWatch links.

2. **Admin Panel:**
    - Add/edit movie metadata.
    - Manage user accounts.
    - Monitor recommendation accuracy.

## Deployment

### Fly.io (Testing Server)

```bash
fly deploy
```

### Live Server (Nginx)

-   Configure **Nginx** to serve the Laravel app.
-   Set up **MySQL database**.
-   Use **Supervisor** for queue management (if needed).

## Future Enhancements

-   **Collaborative Filtering** for better recommendations.
-   **User Watch History** to refine suggestions.
-   **Social Features** (e.g., reviews, watchlists).

## License

This project is licensed under the **MIT License**.

## Author

Developed by :
[Sumafric](https://github.com/sumafric) 🚀
[Betty](https://github.com/BettyNyambura) 🚀
