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

        
    /* // DEBUG TEMPORAL
    $usuario = $this->em->getRepository(Usuario::class)->findOneBy(['email' => $email]);

    var_dump($password); // 👈 Lo que escribe el usuario
    var_dump($usuario?->getPassword()); // 👈 Lo que hay en la BD
    var_dump(password_verify($password, $usuario?->getPassword())); // 👈 true o false

    exit; */

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

        echo json_encode([
            'success' => true,
            'user' => [
                'id' => $usuario->getId(),
                'name' => $usuario->getNombre(),
                'email' => $usuario->getEmail(),
                'rol' => $usuario->getRol()
            ]
        ]);
    }

    public function dashboard() {
        SessionHelper::check(); // Redirige si no hay sesión válida

        $nombre = SessionHelper::get('usuario_nombre');
        $this->smarty->assign('nombre', $nombre);
        $this->smarty->display('dashboard/index.tpl');
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
