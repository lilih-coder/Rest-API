<?php

require_once __DIR__ . '/../vendor/autoload.php';

use App\Core\Test;
use App\Core\Request;

//echo Test::run();

header('Content-Type: application/json; charset=utf-8');

echo json_encode([
    'status' => 'success',
    'message' => 'Welcome to the Movie API!'
]);

$reqest = new Request();
var_dump($reqest->getMethod());
var_dump($reqest->getUri());
var_dump($reqest->getBody());

$response = new \App\Core\Response();
$response->setStatusCode(200)
            ->json(['status' => 'success', 'message' => 'This is a JSON response from Response class.']);