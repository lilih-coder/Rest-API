<?php

namespace App\Core\Router;

class Router
{
    private array $routes = [];

    /**
     * Route hozzáadása
     * @param string $method HTTP metódus: GET, POST, PUT, DELETE
     * @param string $path Az útvonal, pl.: /movies
     * @param callable $handler Callback vagy controller metódus
     */
    public function add(string $method, string $path, callable $handler): void
    {
        $this->routes[] = [
            'method' => strtoupper($method),
            'path' => $path,
            'handler' => $handler,
        ];
    }

    /**
     * Route feldolgozása
     */
    public function dispatch(): void
    {
        $requestMethod = $_SERVER['REQUEST_METHOD'];
        $requestUri = parse_url($_SERVER['REQUEST_URI'], PHP_URL_PATH);

        foreach ($this->routes as $route) {
            if ($route['method'] === $requestMethod && $route['path'] === $requestUri) {
                call_user_func($route['handler']);
                return;
            }
        }

        // Ha nincs találat
        http_response_code(404);
        echo json_encode(['error' => 'Route not found']);
    }
}
