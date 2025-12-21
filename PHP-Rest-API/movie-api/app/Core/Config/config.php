<?php



return [
    // Alkalmazás beállítások
    'app' => [
        'env' => 'development', // development | production
        'base_url' => 'http://localhost/PHP-Rest-API/movie-api/',
        'debug' => true, // Hibák kiírása fejlesztéshez
    ],

    // Adatbázis beállítások
    'db' => [
        'host' => 'localhost',
        'name' => 'movie_api', // adatbázis neve
        'user' => 'root',
        'pass' => '', // jelszó
        'charset' => 'utf8mb4',
    ],

    // CORS beállítások (API hozzáférés más domainről)
    'cors' => [
        'allow_origin' => '*',
        'allow_methods' => 'GET, POST, PUT, DELETE, OPTIONS',
        'allow_headers' => 'Content-Type, Authorization',
    ],

    // Logolás
    'log' => [
        'enabled' => true,
        'file' => __DIR__ . '/../logs/app.log', // logs mappa a projekt gyökérben
    ],
];
