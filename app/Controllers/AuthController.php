<?php

namespace Comida\Domicilio\Controllers;

use Comida\Domicilio\Models\Usuario;
use Comida\Domicilio\Models\Pedido;
use Comida\Domicilio\Models\Restaurante;
use Comida\Domicilio\Utils\SessionHelper;
use Comida\Domicilio\Core\Controller;

class AuthController extends Controller {

    public function __construct($entityManager) {
        parent::__construct($entityManager);
        SessionHelper::start(); // Siempre iniciamos sesión de forma segura
    }

    public function showLogin() {
        $this->render('auth/login.tpl', ['error' => '']);
    }

    public function login() {
        header('Content-Type: application/json');

        $email = $_POST['email'] ?? '';
        $password = $_POST['password'] ?? '';

        if (empty($email) || empty($password)) {
            $this->json(['error' => 'Correo y contraseña son obligatorios'], 400);
            return;
        }

        $usuario = $this->em->getRepository(Usuario::class)->findOneBy(['email' => $email]);

        if (!$usuario || !password_verify($password, $usuario->getPassword())) {
            $this->json(['error' => 'Credenciales incorrectas'], 401);
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

        $this->json([
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
            $this->redirect('/');
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
        
        $this->render('dashboard/index.tpl', [
            'nombre' => $nombre,
            'totalPedidosHoy' => $totalPedidosHoy,
            'estadisticasRestaurantes' => $estadisticasRestaurantes,
            'seccion_activa' => 'dashboard',
            'titulo' => 'Dashboard'
        ]);
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
        
        $this->render('restaurantes/index.tpl', [
            'nombre' => $nombre,
            'titulo' => 'Restaurantes',
            'seccion_activa' => 'restaurantes'
        ]);
    }

    public function menus() {
        SessionHelper::check(); // Redirige si no hay sesión válida
        $nombre = SessionHelper::get('usuario_nombre');
        
        $this->render('menus/index.tpl', [
            'nombre' => $nombre,
            'titulo' => 'Menús',
            'seccion_activa' => 'menus'
        ]);
    }

    public function pedidos() {
        SessionHelper::check(); // Redirige si no hay sesión válida
        $nombre = SessionHelper::get('usuario_nombre');
        
        $this->render('pedidos/index.tpl', [
            'nombre' => $nombre,
            'titulo' => 'Pedidos',
            'seccion_activa' => 'pedidos'
        ]);
    }

    public function clientes() {
        SessionHelper::check(); // Redirige si no hay sesión válida
        $nombre = SessionHelper::get('usuario_nombre');
        
        $this->render('clientes/index.tpl', [
            'nombre' => $nombre,
            'titulo' => 'Clientes',
            'seccion_activa' => 'clientes'
        ]);
    }

    public function facturacion() {
        SessionHelper::check(); // Redirige si no hay sesión válida
        $nombre = SessionHelper::get('usuario_nombre');
        
        $this->render('facturacion/index.tpl', [
            'nombre' => $nombre,
            'titulo' => 'Facturación',
            'seccion_activa' => 'facturacion'
        ]);
    }

    public function configuracion() {
        SessionHelper::check(); // Redirige si no hay sesión válida
        $nombre = SessionHelper::get('usuario_nombre');
        
        $this->render('configuracion/index.tpl', [
            'nombre' => $nombre,
            'titulo' => 'Configuración',
            'seccion_activa' => 'configuracion'
        ]);
    }

    public function logout() {
        SessionHelper::logout();
        $this->redirect('/');
    }
}
