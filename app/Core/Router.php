<?php

namespace Comida\Domicilio\Core;

use Doctrine\ORM\EntityManager;

class Router
{
    private array $routes = [];
    private EntityManager $entityManager;
    private array $middlewares = [];
    private string $prefix = '';

    public function __construct(EntityManager $entityManager)
    {
        $this->entityManager = $entityManager;
    }

    /**
     * Añadir una ruta para método GET
     */
    public function get(string $route, array $handler, array $middlewares = []): self
    {
        $this->addRoute('GET', $route, $handler, $middlewares);
        return $this;
    }

    /**
     * Añadir una ruta para método POST
     */
    public function post(string $route, array $handler, array $middlewares = []): self
    {
        $this->addRoute('POST', $route, $handler, $middlewares);
        return $this;
    }

    /**
     * Añadir una ruta para método PUT
     */
    public function put(string $route, array $handler, array $middlewares = []): self
    {
        $this->addRoute('PUT', $route, $handler, $middlewares);
        return $this;
    }

    /**
     * Añadir una ruta para método DELETE
     */
    public function delete(string $route, array $handler, array $middlewares = []): self
    {
        $this->addRoute('DELETE', $route, $handler, $middlewares);
        return $this;
    }

    /**
     * Añadir una ruta para cualquier método
     */
    public function any(string $route, array $handler, array $middlewares = []): self
    {
        $this->addRoute('ANY', $route, $handler, $middlewares);
        return $this;
    }

    /**
     * Agrupar rutas con un prefijo común
     */
    public function group(string $prefix, callable $callback, array $middlewares = []): self
    {
        $previousPrefix = $this->prefix;
        $previousMiddlewares = $this->middlewares;

        $this->prefix .= $prefix;
        $this->middlewares = array_merge($this->middlewares, $middlewares);

        call_user_func($callback, $this);

        $this->prefix = $previousPrefix;
        $this->middlewares = $previousMiddlewares;

        return $this;
    }

    /**
     * Añadir una ruta
     */
    private function addRoute(string $method, string $route, array $handler, array $middlewares = []): void
    {
        $route = $this->prefix . $route;
        $middlewares = array_merge($this->middlewares, $middlewares);

        // Convertir la ruta con parámetros dinámicos a una expresión regular
        $routeRegex = preg_replace('/{([a-zA-Z0-9_]+)}/', '(?P<$1>[^/]+)', $route);
        $routeRegex = "#^" . $routeRegex . "$#";

        $this->routes[] = [
            'method' => $method,
            'route' => $route,
            'routeRegex' => $routeRegex,
            'handler' => $handler,
            'middlewares' => $middlewares
        ];
    }

    /**
     * Resolver la ruta actual y ejecutar el controlador correspondiente
     */
    public function resolve(string $method, string $uri): void
    {
        // Separar la URI de los query params
        $uriParts = explode('?', $uri);
        $uri = $uriParts[0];

        // Encontrar la ruta coincidente
        foreach ($this->routes as $route) {
            if ($route['method'] !== $method && $route['method'] !== 'ANY') {
                continue;
            }

            // Comprobar si la ruta coincide exactamente
            if ($route['route'] === $uri) {
                $this->executeHandler($route['handler'], []);
                return;
            }

            // Comprobar si la ruta coincide con parámetros dinámicos
            if (preg_match($route['routeRegex'], $uri, $matches)) {
                // Extraer los parámetros dinámicos
                $params = array_filter($matches, function ($key) {
                    return !is_numeric($key);
                }, ARRAY_FILTER_USE_KEY);

                $this->executeHandler($route['handler'], $params);
                return;
            }
        }

        // Si no se encontró ninguna ruta coincidente
        http_response_code(404);
        echo json_encode(['error' => 'Ruta no encontrada']);
    }

    /**
     * Ejecutar el controlador con los parámetros proporcionados
     */
    private function executeHandler(array $handler, array $params): void
    {
        [$controllerClass, $method] = $handler;
        $controller = new $controllerClass($this->entityManager);

        call_user_func_array([$controller, $method], $params);
    }
}
