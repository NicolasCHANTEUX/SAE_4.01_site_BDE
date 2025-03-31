<?php

namespace app\core;

class Router {
    private array $routes = [];

    public function add(string $method, string $path, string $handler): void {
        $this->routes[] = [
            'method' => $method,
            'path' => $path,
            'handler' => $handler
        ];
    }

    public function dispatch(): void {
        $requestMethod = $_SERVER['REQUEST_METHOD'];
        $requestUri = parse_url($_SERVER['REQUEST_URI'], PHP_URL_PATH);

        foreach ($this->routes as $route) {
            if ($route['method'] === $requestMethod && $route['path'] === $requestUri) {
                [$controller, $method] = explode('@', $route['handler']);
                $controllerClass = "App\\Controllers\\$controller";
                
                if (class_exists($controllerClass)) {
                    $controllerInstance = new $controllerClass();
                    if (method_exists($controllerInstance, $method)) {
                        $controllerInstance->$method();
                        return;
                    }
                }
            }
        }

        // Route not found
        http_response_code(404);
        echo "404 Not Found";
    }
}
