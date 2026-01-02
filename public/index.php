<?php

require_once __DIR__ . '/../vendor/autoload.php';

use App\Core\Request;
use App\Core\Response;
use App\Core\Controllers\FilmController;
use App\Core\Router\Router;

header('Content-Type: application/json; charset=utf-8');

$router = new Router();
$router->add('GET', '/films', function () {
    $controller = new FilmController();
    $controller->index();
});

$router->add('GET', '/films/{id}', function ($id) {     
    $controller = new FilmController();                     // handle függvény
    $controller->show($id);
});

$router->add('POST', '/films', function () {
    $controller = new FilmController();
    $data = json_decode(file_get_contents('php://input'), true);
    $controller->store($data);
});

$router->add('PUT', '/films/{id}', function ($id) {
    $controller = new FilmController();
    $data = json_decode(file_get_contents('php://input'), true);
    $controller->update($id, $data);
});

$router->add('DELETE', '/films/{id}', function ($id) {
    $controller = new FilmController();
    $controller->destroy($id);
});
/*
$router->add('GET', '/studios', function () {
    $controller = new SturioController();
    $controller->index();
});
*/
$router->dispatch();
