<?php

return [
    // Alkalmazás beállítások
    'appxxxx' => [
        'env' => 'development', // development | production
        'base_url' => 'http://localhost/Rest-API/PHP-Rest-API/movie-api/',
        'debug' => true, // Hibák kiírása fejlesztéshez
    ],

    // Adatbázis beállítások
    'db' => [
        'host' => 'localhost',
        'name' => 'movies_db', // adatbázis neve
        'user' => 'root',
        'pass' => '', // jelszó
        'charset' => 'utf8mb4',
    ],

    // CORS beállítások (API hozzáférés más domainről)
    'corsxxxx' => [
        'allow_origin' => '*',
        'allow_methods' => 'GET, POST, PUT, DELETE, OPTIONS',
        'allow_headers' => 'Content-Type, Authorization',
    ],

    // Logolás
    'logxxx' => [
        'enabled' => true,
        'file' => __DIR__ . '/logs/app.log', // logs mappa a projekt gyökérben
    ],
];
