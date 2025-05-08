<?php

namespace Comida\Domicilio\Controllers;

use Comida\Domicilio\Models\Usuario;
use Comida\Domicilio\Models\Restaurante;
use Comida\Domicilio\Models\Pedido;
use Comida\Domicilio\Utils\SessionHelper;
use Smarty\Smarty;

class ClienteController {
    private $em;
    private $smarty;

    public function __construct($entityManager) {
        $this->em = $entityManager;
        
        $this->smarty = new Smarty();
        $this->smarty->setTemplateDir(__DIR__ . '/../Views');
        $this->smarty->setCompileDir(__DIR__ . '/../../templates_c');
        
        SessionHelper::start();
    }
    
    /**
 * Verificar que el usuario tiene rol 'usuario'
 */
private function checkClienteRole() {
    SessionHelper::check(); // Redirige si no hay sesión
    
    $rol = SessionHelper::get('usuario_rol');
    if ($rol !== 'usuario') { // Cambio aquí: "usuario" en lugar de "cliente"
        header('Location: /dashboard');
        exit;
    }
}
    
    /**
     * Dashboard principal del cliente
     */
    public function inicio() {
        $this->checkClienteRole();
        
        $usuarioId = SessionHelper::get('usuario_id');
        $nombre = SessionHelper::get('usuario_nombre');
        
        // Obtener pedidos recientes, restaurantes populares, etc.
        $pedidosRecientes = $this->em->getRepository(Pedido::class)
            ->findBy(['usuario' => $usuarioId], ['fechaPedido' => 'DESC'], 3);
        
        // Restaurantes populares o últimos visitados
        $restaurantesPopulares = $this->em->getRepository(Restaurante::class)
            ->findBy(['activo' => true], ['id' => 'DESC'], 6);
        
        $this->smarty->assign('nombre', $nombre);
        $this->smarty->assign('titulo', 'Mi Cuenta');
        $this->smarty->assign('seccion_activa', 'inicio');
        $this->smarty->assign('pedidosRecientes', $pedidosRecientes);
        $this->smarty->assign('restaurantesPopulares', $restaurantesPopulares);
        $this->smarty->display('cliente/dashboard/index.tpl');
    }
    
    /**
     * Listado de restaurantes para el cliente
     */
    public function restaurantes() {
        $this->checkClienteRole();
        
        $nombre = SessionHelper::get('usuario_nombre');
        
        // Obtener todos los restaurantes activos
        $restaurantes = $this->em->getRepository(Restaurante::class)
            ->findBy(['activo' => true], ['nombre' => 'ASC']);
        
        $this->smarty->assign('nombre', $nombre);
        $this->smarty->assign('titulo', 'Restaurantes');
        $this->smarty->assign('seccion_activa', 'restaurantes');
        $this->smarty->assign('restaurantes', $restaurantes);
        $this->smarty->display('cliente/restaurantes/index.tpl');
    }
    
    /**
     * Ver pedidos del cliente
     */
    public function pedidos() {
        $this->checkClienteRole();
        
        $usuarioId = SessionHelper::get('usuario_id');
        $nombre = SessionHelper::get('usuario_nombre');
        
        // Obtener todos los pedidos del usuario
        $pedidos = $this->em->getRepository(Pedido::class)
            ->findBy(['usuario' => $usuarioId], ['fechaPedido' => 'DESC']);
        
        $this->smarty->assign('nombre', $nombre);
        $this->smarty->assign('titulo', 'Mis Pedidos');
        $this->smarty->assign('seccion_activa', 'pedidos');
        $this->smarty->assign('pedidos', $pedidos);
        $this->smarty->display('cliente/pedidos/index.tpl');
    }
    
    // Más métodos para las demás secciones del área de cliente...
}