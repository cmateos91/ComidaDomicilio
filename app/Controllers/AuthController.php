<?php

namespace Comida\Domicilio\Controllers;

use Comida\Domicilio\Models\Usuario;
use Comida\Domicilio\Models\Pedido;
use Comida\Domicilio\Models\Restaurante;
use Comida\Domicilio\Utils\SessionHelper;
use Smarty\Smarty;

class AuthController {
    private $em;
    private $smarty;

    public function __construct($entityManager) {
        $this->em = $entityManager;

        $this->smarty = new Smarty();
        $this->smarty->setTemplateDir(__DIR__ . '/../Views');
        $this->smarty->setCompileDir(__DIR__ . '/../../templates_c');

        SessionHelper::start(); // Siempre iniciamos sesión de forma segura
    }

    public function showLogin() {
        $this->smarty->assign('error', '');
        $this->smarty->display('auth/login.tpl');
    }

   public function login() {
    header('Content-Type: application/json');

    $email = $_POST['email'] ?? '';
    $password = $_POST['password'] ?? '';

    if (empty($email) || empty($password)) {
        http_response_code(400);
        echo json_encode(['error' => 'Correo y contraseña son obligatorios']);
        return;
    }

    $usuario = $this->em->getRepository(Usuario::class)->findOneBy(['email' => $email]);

    if (!$usuario || !password_verify($password, $usuario->getPassword())) {
        http_response_code(401);
        echo json_encode(['error' => 'Credenciales incorrectas']);
        return;
    }

    // Guardar en sesión con SessionHelper
    SessionHelper::login([
        'id' => $usuario->getId(),
        'nombre' => $usuario->getNombre(),
        'rol' => $usuario->getRol(),
    ]);

    // Determinar la ruta de redirección basada en el rol
    $redirectUrl = '/dashboard'; // Ruta por defecto para propietarios/admin
    
    if ($usuario->getRol() === 'usuario') { // Cambio aquí: "usuario" en lugar de "cliente"
        $redirectUrl = '/cliente/dashboard'; // Mantenemos la ruta /cliente/ por claridad en la arquitectura
    }

    echo json_encode([
        'success' => true,
        'user' => [
            'id' => $usuario->getId(),
            'name' => $usuario->getNombre(),
            'email' => $usuario->getEmail(),
            'rol' => $usuario->getRol()
        ],
        'redirect' => $redirectUrl
    ]);
}

    public function dashboard() {
        SessionHelper::check(); // Redirige si no hay sesión válida

        $usuarioId = SessionHelper::get('usuario_id');
        $nombre = SessionHelper::get('usuario_nombre');
        $rol = SessionHelper::get('usuario_rol');
        
        // Obtener el usuario completo
        $usuario = $this->em->getRepository(Usuario::class)->find($usuarioId);
        
        if (!$usuario) {
            SessionHelper::logout();
            header('Location: /');
            exit;
        }
        
        // Obtener el total de pedidos de hoy
        $totalPedidosHoy = $this->getTotalPedidosHoy();
        
        // Obtener estadísticas de restaurantes si es administrador o propietario
        $estadisticasRestaurantes = [];
        
        if ($rol === 'admin' || $rol === 'propietario') {
            // Obtener restaurantes del usuario
            $restaurantes = $usuario->getRestaurantes();
            
            foreach ($restaurantes as $restaurante) {
                // Contar pedidos de hoy para este restaurante
                $pedidosHoy = $this->contarPedidosHoyRestaurante($restaurante);
                
                $estadisticasRestaurantes[] = [
                    'id' => $restaurante->getId(),
                    'nombre' => $restaurante->getNombre(),
                    'pedidosHoy' => $pedidosHoy,
                ];
            }
        }
        
        $this->smarty->assign('nombre', $nombre);
        $this->smarty->assign('totalPedidosHoy', $totalPedidosHoy);
        $this->smarty->assign('estadisticasRestaurantes', $estadisticasRestaurantes);
        $this->smarty->assign('seccion_activa', 'dashboard');
        $this->smarty->assign('titulo', 'Dashboard');
        $this->smarty->display('dashboard/index.tpl');
    }
    
    /**
     * Obtiene el total de pedidos de hoy
     * @return int Número total de pedidos de hoy
     */
    private function getTotalPedidosHoy() {
        try {
            $pedidoRepo = $this->em->getRepository(Pedido::class);
            return count($pedidoRepo->getPedidosHoy());
        } catch (\Exception $e) {
            // Manejo de errores
            error_log("Error al obtener total de pedidos de hoy: " . $e->getMessage());
            return 0;
        }
    }
    
    /**
     * Cuenta los pedidos de hoy para un restaurante específico
     * 
     * @param Restaurante $restaurante
     * @return int Número de pedidos de hoy
     */
    private function contarPedidosHoyRestaurante(Restaurante $restaurante): int {
        try {
            $pedidoRepo = $this->em->getRepository(Pedido::class);
            return $pedidoRepo->contarPedidosHoyRestaurante($restaurante);
        } catch (\Exception $e) {
            // Manejo de errores
            error_log("Error al contar pedidos por restaurante: " . $e->getMessage());
            return 0;
        }
    }

    public function restaurantes() {
        SessionHelper::check(); // Redirige si no hay sesión válida

        $nombre = SessionHelper::get('usuario_nombre');
        $this->smarty->assign('nombre', $nombre);
        $this->smarty->display('restaurantes/index.tpl');
    }

    public function menus() {
        SessionHelper::check(); // Redirige si no hay sesión válida

        $nombre = SessionHelper::get('usuario_nombre');
        $this->smarty->assign('nombre', $nombre);
        $this->smarty->display('menus/index.tpl');
    }

    public function pedidos() {
        SessionHelper::check(); // Redirige si no hay sesión válida

        $nombre = SessionHelper::get('usuario_nombre');
        $this->smarty->assign('nombre', $nombre);
        $this->smarty->display('pedidos/index.tpl');
    }

    public function clientes() {
        SessionHelper::check(); // Redirige si no hay sesión válida

        $nombre = SessionHelper::get('usuario_nombre');
        $this->smarty->assign('nombre', $nombre);
        $this->smarty->display('clientes/index.tpl');
    }

    public function facturacion() {
        SessionHelper::check(); // Redirige si no hay sesión válida

        $nombre = SessionHelper::get('usuario_nombre');
        $this->smarty->assign('nombre', $nombre);
        $this->smarty->display('facturacion/index.tpl');
    }

    public function configuracion() {
        SessionHelper::check(); // Redirige si no hay sesión válida

        $nombre = SessionHelper::get('usuario_nombre');
        $this->smarty->assign('nombre', $nombre);
        $this->smarty->display('configuracion/index.tpl');
    }

    public function logout() {
        SessionHelper::logout();
        header('Location: /');
        exit;
    }
}
