<?php

require_once __DIR__ . '/../vendor/autoload.php';
require_once __DIR__ . '/../app/Config/enviroment.php';

use Comida\Domicilio\Core\Application;
use Comida\Domicilio\Controllers\AuthController;
use Comida\Domicilio\Controllers\RestauranteController;
use Comida\Domicilio\Controllers\ClienteController;
use Comida\Domicilio\Utils\SessionHelper;
use Comida\Domicilio\Middleware\RoleMiddleware;

// Iniciar la aplicación
$app = new Application($entityManager);
$router = $app->getRouter();

// Middleware de autenticación
$authMiddleware = function () {
    SessionHelper::check();
};

// Middleware de roles
$adminMiddleware = RoleMiddleware::check(['admin']);
$propietarioMiddleware = RoleMiddleware::check(['admin', 'propietario']);
$usuarioMiddleware = RoleMiddleware::check(['usuario']);

// Rutas públicas
$router->get('/', [AuthController::class, 'showLogin']);
$router->post('/api/login', [AuthController::class, 'login']);
$router->get('/logout', [AuthController::class, 'logout']);

// Rutas para el panel de administración
$router->get('/dashboard', [AuthController::class, 'dashboard'], [$authMiddleware]);

// Rutas para restaurantes (panel de administración)
$router->group('/restaurantes', function ($router) {
    $router->get('', [RestauranteController::class, 'mostrarRestaurantes']);
    $router->get('/{id}', [RestauranteController::class, 'show']);
    $router->get('/nuevo', [RestauranteController::class, 'mostrarFormularioCrear']);
    $router->get('/{id}/editar', [RestauranteController::class, 'mostrarFormularioEditar']);
}, [$authMiddleware, $propietarioMiddleware]);

// API Restaurantes
$router->group('/api/restaurantes', function ($router) {
    $router->get('', [RestauranteController::class, 'index']);
    $router->get('/{id}', [RestauranteController::class, 'show']);
    $router->post('', [RestauranteController::class, 'create']);
    $router->put('/{id}', [RestauranteController::class, 'update']);
    $router->delete('/{id}', [RestauranteController::class, 'delete']);
}, [$authMiddleware, $propietarioMiddleware]);

// Rutas para otras secciones del panel
$router->get('/menus', [AuthController::class, 'menus'], [$authMiddleware]);
$router->get('/pedidos', [AuthController::class, 'pedidos'], [$authMiddleware]);
$router->get('/clientes', [AuthController::class, 'clientes'], [$authMiddleware]);
$router->get('/facturacion', [AuthController::class, 'facturacion'], [$authMiddleware]);
$router->get('/configuracion', [AuthController::class, 'configuracion'], [$authMiddleware]);

// Rutas para el área de cliente
$router->group('/cliente', function ($router) {
    $router->get('/dashboard', [ClienteController::class, 'inicio']);
    $router->get('/inicio', [ClienteController::class, 'inicio']);
    $router->get('/restaurantes', [ClienteController::class, 'restaurantes']);
    $router->get('/pedidos', [ClienteController::class, 'pedidos']);
}, [$authMiddleware, $usuarioMiddleware]);

// Ejecutar la aplicación
$app->run();
