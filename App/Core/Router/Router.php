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
        // Keresünk paramétereket {name} formában
        $paramNames = [];
        if (preg_match_all('/\{([a-zA-Z_][a-zA-Z0-9_]*)\}/', $path, $matches)) {
            $paramNames = $matches[1];
            // Alakítsuk regex-re: minden {param} egy "([^/]+)" csoport lesz
            $pattern = preg_replace_callback('/\{([a-zA-Z_][a-zA-Z0-9_]*)\}/', function ($m) {
                return '([^/]+)';
            }, $path);
            $regex = '#^' . $pattern . '$#';
        } else {
            $regex = null;
        }

        $this->routes[] = [
            'method' => strtoupper($method),
            'path' => $path,
            'handler' => $handler,
            'regex' => $regex,
            'params' => $paramNames,
        ];
    }

    /**
     * Route feldolgozása
     */
    public function dispatch(): void
    {
        $requestMethod = $_SERVER['REQUEST_METHOD'];
        $base_uri = "/Rest-API"; // Az alkalmazás alap URI-je
        $requestUri = parse_url($_SERVER['REQUEST_URI'], PHP_URL_PATH);
        $requestUri = str_replace($base_uri, '', $requestUri);

        foreach ($this->routes as $route) {
            if ($route['method'] !== $requestMethod) {
                continue;
            }

            // Ha van regex (paraméteres útvonal)
            if (!empty($route['regex'])) {
                if (preg_match($route['regex'], $requestUri, $matches)) {
                    array_shift($matches); // az 0. elem a teljes egyezés
                    // Meghívjuk a handler-t a paraméterekkel (sorrendben)
                    call_user_func_array($route['handler'], $matches);
                    return;
                }
            } else {
                // Egyszerű, statikus útvonal
                if ($route['path'] === $requestUri) {
                    call_user_func($route['handler']);
                    return;
                }
            }
        }

        // Ha nincs találat
        http_response_code(404);
        echo json_encode(['error' => 'Route not found1 (Router.php)']);
    }
}


