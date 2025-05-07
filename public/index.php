<?php
require_once __DIR__ . '/../vendor/autoload.php';
require_once __DIR__ . '/../app/Config/enviroment.php';

$uri = parse_url($_SERVER['REQUEST_URI'], PHP_URL_PATH);
$method = $_SERVER['REQUEST_METHOD'];

use Comida\Domicilio\Controllers\AuthController;
use Comida\Domicilio\Controllers\RestauranteController;

// Rutas públicas
if ($uri === '/' && $method === 'GET') {
    (new AuthController($entityManager))->showLogin();
    exit;
}

if ($uri === '/api/login' && $method === 'POST') {
    (new AuthController($entityManager))->login();
    exit;
}

if ($uri === '/logout') {
    (new AuthController($entityManager))->logout();
    exit;
}

if ($uri === '/dashboard' && $method === 'GET') {
    (new AuthController($entityManager))->dashboard();
    exit;
}


// Rutas de las secciones del panel
if ($uri === '/restaurantes' && $method === 'GET') {
    (new RestauranteController($entityManager))->mostrarRestaurantes();
    exit;
}

if ($uri === '/menus' && $method === 'GET') {
    (new AuthController($entityManager))->menus();
    exit;
}

if ($uri === '/pedidos' && $method === 'GET') {
    (new AuthController($entityManager))->pedidos();
    exit;
}

if ($uri === '/clientes' && $method === 'GET') {
    (new AuthController($entityManager))->clientes();
    exit;
}

if ($uri === '/facturacion' && $method === 'GET') {
    (new AuthController($entityManager))->facturacion();
    exit;
}

if ($uri === '/configuracion' && $method === 'GET') {
    (new AuthController($entityManager))->configuracion();
    exit;
}

// Rutas API
if ($uri === '/api/restaurantes' && $method === 'GET') {
    (new RestauranteController($entityManager))->index();
    exit;
}


// 404 por defecto
http_response_code(404);
echo json_encode(['error' => 'Ruta no encontrada']);

//var_dump($uri);
//exit;

