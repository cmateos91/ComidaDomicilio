<?php

namespace Comida\Domicilio\Core;

use Doctrine\ORM\EntityManager;

class Application
{
    private Router $router;
    private EntityManager $entityManager;

    public function __construct(EntityManager $entityManager)
    {
        $this->entityManager = $entityManager;
        $this->router = new Router($entityManager);
    }

    /**
     * Obtener el router
     */
    public function getRouter(): Router
    {
        return $this->router;
    }

    /**
     * Iniciar la aplicación
     */
    public function run(): void
    {
        $method = $_SERVER['REQUEST_METHOD'];
        $uri = parse_url($_SERVER['REQUEST_URI'], PHP_URL_PATH);

        $this->router->resolve($method, $uri);
    }
}
