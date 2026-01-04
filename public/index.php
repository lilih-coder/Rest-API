<?php

require_once __DIR__ . '/../vendor/autoload.php';

//use App\Core\Request;
//use App\Core\Response;
use App\Core\Controllers\FilmController;
use App\Core\Controllers\StudioController;
use App\Core\Controllers\DirectorController;
use App\Core\Controllers\CategoryController;
use App\Core\Router\Router;

header('Content-Type: application/json; charset=utf-8');


// Film útvonalak
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

// Stúdió útvonalak

$router->add('GET', '/studios', function () {
    $controller = new StudioController();
    $controller->index();
});
$router->add('GET', '/studios/{id}', function ($id) {
    $controller = new StudioController();
    $controller->show($id);
});
$router->add('POST', '/studios', function () {
    $controller = new StudioController();
    $data = json_decode(file_get_contents('php://input'), true);
    $controller->store($data);
});
$router->add('PUT', '/studios/{id}', function ($id) {
    $controller = new StudioController();
    $data = json_decode(file_get_contents('php://input'), true);
    $controller->update($id, $data);
});
$router->add('DELETE', '/studios/{id}', function ($id) {
    $controller = new StudioController();
    $controller->destroy($id);
});

// Rendező útvonalak
$router->add('GET', '/directors', function () {
    $controller = new DirectorController();
    $controller->index();
});
$router->add('GET', '/directors/{id}', function ($id) {
    $controller = new DirectorController();
    $controller->show($id);
});
$router->add('POST', '/directors', function () {
    $controller = new DirectorController();
    $data = json_decode(file_get_contents('php://input'), true);
    $controller->store($data);
});
$router->add('PUT', '/directors/{id}', function ($id) {
    $controller = new DirectorController();
    $data = json_decode(file_get_contents('php://input'), true);
    $controller->update($id, $data);
});
$router->add('DELETE', '/directors/{id}', function ($id) {
    $controller = new DirectorController();
    $controller->destroy($id);
});

// Kategória útvonalak
$router->add('GET', '/categories', function () {
    $controller = new CategoryController();
    $controller->index();
});
$router->add('GET', '/categories/{id}', function ($id) {
    $controller = new CategoryController();
    $controller->show($id);
});
$router->add('POST', '/categories', function () {
    $controller = new CategoryController();
    $data = json_decode(file_get_contents('php://input'), true);
    $controller->store($data);
});
$router->add('PUT', '/categories/{id}', function ($id) {
    $controller = new CategoryController();
    $data = json_decode(file_get_contents('php://input'), true);
    $controller->update($id, $data);
});
$router->add('DELETE', '/categories/{id}', function ($id) {
    $controller = new CategoryController();
    $controller->destroy($id);
});

/*
$router->add('GET', '/studios', function () {
    $controller = new SturioController();
    $controller->index();
});
*/
$router->dispatch();
