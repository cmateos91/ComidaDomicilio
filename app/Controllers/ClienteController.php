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
        
        // Obtener pedidos recientes
        $pedidosRecientes = $this->em->getRepository(Pedido::class)
            ->findBy(['usuarioId' => $usuarioId], ['fechaPedido' => 'DESC'], 3);
        
        // Cargar los restaurantes asociados a los pedidos
        $restaurantes = [];
        foreach ($pedidosRecientes as $pedido) {
            $restauranteId = $pedido->getRestauranteId();
            if (!isset($restaurantes[$restauranteId])) {
                $restaurantes[$restauranteId] = $this->em->getRepository(Restaurante::class)->find($restauranteId);
            }
        }
        
        // Restaurantes populares
        $restaurantesPopulares = $this->em->getRepository(Restaurante::class)
            ->findBy(['activo' => true], ['id' => 'DESC'], 6);
        
        $this->smarty->assign('nombre', $nombre);
        $this->smarty->assign('titulo', 'Mi Cuenta');
        $this->smarty->assign('seccion_activa', 'inicio');
        $this->smarty->assign('pedidosRecientes', $pedidosRecientes);
        $this->smarty->assign('restaurantes', $restaurantes); // Pasamos los restaurantes a la vista
        $this->smarty->assign('restaurantesPopulares', $restaurantesPopulares);
        
        // Añadir CSS para la vista de cliente
        $this->smarty->assign('css_adicional', ['cliente.css']);
        
        // Renderizar la vista una sola vez
        $this->smarty->display('cliente/dashboard/index.tpl');
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