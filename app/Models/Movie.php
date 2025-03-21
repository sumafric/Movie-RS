<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;


class Movie extends Model
{
    use HasFactory;

    protected $fillable = [
        'imdb_id', 'title', 'overview', 'poster_path', 
        'rating', 'release_date', 'genres'
    ];

    protected $casts = [
        'genres' => 'array', // Automatically converts JSON to an array
        'release_date' => 'date', // Treats it as a date field
    ];
}
