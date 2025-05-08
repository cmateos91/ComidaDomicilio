<?php

namespace Comida\Domicilio\Controllers;

use Comida\Domicilio\Models\Usuario;
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

        $nombre = SessionHelper::get('usuario_nombre');
        
        // Obtener el total de pedidos de hoy
        $totalPedidosHoy = $this->getTotalPedidosHoy();
        
        $this->smarty->assign('nombre', $nombre);
        $this->smarty->assign('totalPedidosHoy', $totalPedidosHoy);
        $this->smarty->display('dashboard/index.tpl');
    }
    
    /**
     * Obtiene el total de pedidos de hoy
     * @return int Número total de pedidos de hoy
     */
    private function getTotalPedidosHoy() {
        try {
            // Obtener la fecha de hoy
            $hoy = new \DateTime('today');
            $hoyFin = new \DateTime('today 23:59:59');
            
            // Usar Query Builder de Doctrine
            $queryBuilder = $this->em->createQueryBuilder();
            
            $queryBuilder
                ->select('COUNT(p.id)')
                ->from('Comida\Domicilio\Models\Pedido', 'p')
                ->where('p.fechaPedido BETWEEN :fechaInicio AND :fechaFin')
                ->setParameter('fechaInicio', $hoy)
                ->setParameter('fechaFin', $hoyFin);
            
            $result = $queryBuilder->getQuery()->getSingleScalarResult();
            
            return (int)$result;
        } catch (\Exception $e) {
            // Manejo de errores
            error_log("Error al obtener total de pedidos de hoy: " . $e->getMessage());
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
