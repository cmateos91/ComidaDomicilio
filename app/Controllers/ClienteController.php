<?php

namespace Comida\Domicilio\Controllers;

use Comida\Domicilio\Models\Usuario;
use Comida\Domicilio\Models\Restaurante;
use Comida\Domicilio\Models\Pedido;
use Comida\Domicilio\Utils\SessionHelper;
use Comida\Domicilio\Core\Controller;

class ClienteController extends Controller {
    
    public function __construct($entityManager) {
        parent::__construct($entityManager);
        SessionHelper::start();
    }
    
    /**
     * Verificar que el usuario tiene rol 'usuario'
     */
    private function checkClienteRole() {
        SessionHelper::check(); // Redirige si no hay sesión
        
        $rol = SessionHelper::get('usuario_rol');
        if ($rol !== 'usuario') { // Cambio aquí: "usuario" en lugar de "cliente"
            $this->redirect('/dashboard');
        }
    }
    
    /**
     * Dashboard principal del cliente
     */
    public function inicio() {
        $this->checkClienteRole();
        
        $usuarioId = SessionHelper::get('usuario_id');
        $nombre = SessionHelper::get('usuario_nombre');
        
        // Obtener el usuario completo
        $usuario = $this->em->getRepository(Usuario::class)->find($usuarioId);
        
        if (!$usuario) {
            SessionHelper::logout();
            $this->redirect('/');
        }
        
        // Vamos a simplificar el código para localizar el error
        // Obtener pedidos recientes utilizando una consulta directa para evitar problemas con los repositorios
        $usuarioIdInt = (int)$usuarioId;
        $conn = $this->em->getConnection();
        
        $sql = "SELECT p.* FROM pedidos p WHERE p.usuario_id = {$usuarioIdInt} ORDER BY p.fecha_pedido DESC LIMIT 3";
        $result = $conn->executeQuery($sql);
        $pedidosRecientes = $result->fetchAllAssociative();
        
        // Obtener restaurantes populares con una consulta simple
        $sql = "SELECT r.* FROM restaurante r WHERE r.activo = 1 ORDER BY r.id DESC LIMIT 6";
        $result = $conn->executeQuery($sql);
        $restaurantesPopulares = $result->fetchAllAssociative();
        
        // Simplificar los datos para mostrar en la vista
        $pedidosSimples = [];
        foreach ($pedidosRecientes as $pedido) {
            $pedidosSimples[] = [
                'id' => $pedido['id'],
                'fecha' => $pedido['fecha_pedido'],
                'total' => $pedido['total'],
                'estado' => $pedido['estado'],
            ];
        }
        
        $restaurantesSimples = [];
        foreach ($restaurantesPopulares as $restaurante) {
            $restaurantesSimples[] = [
                'id' => $restaurante['id'],
                'nombre' => $restaurante['nombre'],
                'direccion' => $restaurante['direccion'],
                'imagen' => $restaurante['imagen'] ?? null,
            ];
        }
        
        $this->render('cliente/dashboard/index.tpl', [
            'nombre' => $nombre,
            'titulo' => 'Mi Cuenta',
            'seccion_activa' => 'inicio',
            'pedidosRecientes' => $pedidosSimples,
            'restaurantesPopulares' => $restaurantesSimples,
            'css_adicional' => ['cliente.css']
        ]);
    }
    
    /**
     * Ver pedidos del cliente
     */
    public function pedidos() {
        $this->checkClienteRole();
        
        $usuarioId = SessionHelper::get('usuario_id');
        $nombre = SessionHelper::get('usuario_nombre');
        
        // Vamos a simplificar el código para localizar el error
        // Obtener pedidos utilizando una consulta directa para evitar problemas con los repositorios
        $usuarioIdInt = (int)$usuarioId;
        $conn = $this->em->getConnection();
        
        $sql = "SELECT p.* FROM pedidos p WHERE p.usuario_id = {$usuarioIdInt} ORDER BY p.fecha_pedido DESC";
        $result = $conn->executeQuery($sql);
        $pedidosData = $result->fetchAllAssociative();
        
        // Simplificar los datos para mostrar en la vista
        $pedidosSimples = [];
        foreach ($pedidosData as $pedido) {
            $pedidosSimples[] = [
                'id' => $pedido['id'],
                'fecha' => $pedido['fecha_pedido'],
                'total' => $pedido['total'],
                'estado' => $pedido['estado'],
                'direccion' => $pedido['direccion_entrega'],
                'telefono' => $pedido['telefono_contacto'],
                'notas' => $pedido['notas'],
            ];
        }
        
        $this->render('cliente/pedidos/index.tpl', [
            'nombre' => $nombre,
            'titulo' => 'Mis Pedidos',
            'seccion_activa' => 'pedidos',
            'pedidos' => $pedidosSimples
        ]);
    }
    
    /**
     * Ver restaurantes disponibles para realizar pedidos
     */
    public function restaurantes() {
        $this->checkClienteRole();
        
        $nombre = SessionHelper::get('usuario_nombre');
        
        // Vamos a simplificar el código para localizar el error
        // Obtener restaurantes activos usando una consulta directa
        $conn = $this->em->getConnection();
        
        $sql = "SELECT r.* FROM restaurante r WHERE r.activo = 1 ORDER BY r.nombre ASC";
        $result = $conn->executeQuery($sql);
        $restaurantesData = $result->fetchAllAssociative();
        
        // Simplificar los datos para mostrar en la vista
        $restaurantesSimples = [];
        foreach ($restaurantesData as $restaurante) {
            $restaurantesSimples[] = [
                'id' => $restaurante['id'],
                'nombre' => $restaurante['nombre'],
                'direccion' => $restaurante['direccion'],
                'imagen' => $restaurante['imagen'] ?? null,
                'telefono' => $restaurante['telefono'] ?? '',
                'email' => $restaurante['email'] ?? '',
                'descripcion' => $restaurante['descripcion'] ?? '',
            ];
        }
        
        $this->render('cliente/restaurantes/index.tpl', [
            'nombre' => $nombre,
            'titulo' => 'Restaurantes',
            'seccion_activa' => 'restaurantes',
            'restaurantes' => $restaurantesSimples
        ]);
    }
}
