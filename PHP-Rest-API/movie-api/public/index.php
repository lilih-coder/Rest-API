<?php

require_once __DIR__ . '/../vendor/autoload.php';

use App\Core\Request;
use App\Core\Response;
use App\Core\Controllers\FilmController;

header('Content-Type: application/json; charset=utf-8');

// Request és Response példányok
$request = new Request();
$response = new Response();

// Alap üzenet, ha nincs route
$welcomeMessage = [
    'status' => 'success',
    'message' => 'Welcome to the Movie API!'
];

// Routing logika
$uri = $request->getUri();       // pl. /films vagy /films/1
$method = $request->getMethod(); // GET, POST, PUT, DELETE

$controller = new FilmController();

// GET /films
if ($uri === '/films' && $method === 'GET') {
    $data = $controller->index();
    $response->setStatusCode(200)->json($data);

// GET /films/{id}
} elseif (preg_match('#^/films/(\d+)$#', $uri, $matches) && $method === 'GET') {
    $data = $controller->show((int)$matches[1]);
    $response->setStatusCode(200)->json($data);

// POST /films
} elseif ($uri === '/films' && $method === 'POST') {
    $data = $request->getBody();
    $result = $controller->store($data);
    $response->setStatusCode(201)->json($result);

// PUT /films/{id}
} elseif (preg_match('#^/films/(\d+)$#', $uri, $matches) && $method === 'PUT') {
    $data = $request->getBody();
    $result = $controller->update((int)$matches[1], $data);
    $response->setStatusCode(200)->json($result);

// DELETE /films/{id}
} elseif (preg_match('#^/films/(\d+)$#', $uri, $matches) && $method === 'DELETE') {
    $result = $controller->destroy((int)$matches[1]);
    $response->setStatusCode(200)->json($result);

// Nincs találat
} else {
    $response->setStatusCode(404)->json(['error' => 'Route not found']);
}
