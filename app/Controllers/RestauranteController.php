<?php

namespace Comida\Domicilio\Controllers;

use Comida\Domicilio\Models\Restaurante;
use Comida\Domicilio\Models\Usuario;
use Comida\Domicilio\Models\Pedido;
use Comida\Domicilio\Utils\BaseEntityUtils;
use Comida\Domicilio\Utils\SessionHelper;
use Doctrine\DBAL\Exception;
use Smarty\Smarty;

class RestauranteController {
    private $em;
    private $smarty;

    public function __construct($entityManager) {
        $this->em = $entityManager;
        
        $this->smarty = new Smarty();
        $this->smarty->setTemplateDir(__DIR__ . '/../Views');
        $this->smarty->setCompileDir(__DIR__ . '/../../templates_c');
    }

    // GET /api/restaurantes
    public function index() {
        SessionHelper::check(); // Redirige si no hay sesión válida
        header('Content-Type: application/json');

        $repo = $this->em->getRepository(Restaurante::class);
        $restaurantes = $repo->findAll();

        $data = array_map([BaseEntityUtils::class, 'toArray'], $restaurantes);

        echo json_encode($data);
    }

    // GET /api/restaurantes/{id}
    public function show($id) {
        header('Content-Type: application/json');

        $repo = $this->em->getRepository(Restaurante::class);
        $restaurante = $repo->find($id);

        if (!$restaurante) {
            http_response_code(404);
            echo json_encode(['error' => 'Restaurante no encontrado']);
            return;
        }

        echo json_encode($this->mapRestaurante($restaurante));
    }

    // Obtiene los restaurantes asociados a un usuario
    public function getRestaurantesByUsuario($usuarioId) {
        try {
            // Buscar el usuario por ID
            $usuario = $this->em->getRepository(Usuario::class)->find($usuarioId);
            
            if (!$usuario) {
                return [];
            }
            
            // Obtener restaurantes utilizando el método del repositorio personalizado
            $restauranteRepo = $this->em->getRepository(Restaurante::class);
            $restaurantes = $restauranteRepo->getRestaurantesByUsuario($usuario);
            
            // Obtener el recuento de pedidos de hoy para cada restaurante
            $pedidoRepo = $this->em->getRepository(Pedido::class);
            
            // Asignar contadores de pedidos
            foreach ($restaurantes as $restaurante) {
                $contadorPedidosHoy = $pedidoRepo->contarPedidosHoyRestaurante($restaurante);
                $restaurante->setPedidosHoy($contadorPedidosHoy);
            }
            
            return $restaurantes;
        } catch (\Exception $e) {
            // Manejo de errores
            error_log($e->getMessage());
            return [];
        }
    }
    
    // Esta función ya no es necesaria porque se usa el repositorio de Pedido
    // La mantenemos por compatibilidad con otras partes del código que puedan usarla
    private function getPedidosHoyPorRestaurante() {
        try {
            // Obtener la fecha de hoy
            $hoy = new \DateTime('today');
            $hoyFin = new \DateTime('today 23:59:59');
            
            // Usar método del repositorio personalizado
            $pedidoRepo = $this->em->getRepository(Pedido::class);
            $result = $pedidoRepo->getEstadisticasPorRestaurante($hoy, $hoyFin);
            
            // Convertir a un array asociativo [restaurante_id => total_pedidos]
            $resultado = [];
            foreach ($result as $row) {
                $resultado[$row['restauranteId']] = (int)$row['totalPedidos'];
            }
            
            return $resultado;
        } catch (\Exception $e) {
            // Manejo de errores
            error_log("Error al obtener pedidos por restaurante: " . $e->getMessage());
            return [];
        }
    }
    
    // Página principal de restaurantes
    public function mostrarRestaurantes() {
        SessionHelper::check(); // Redirige si no hay sesión válida
        
        $usuarioId = SessionHelper::get('usuario_id');
        $nombre = SessionHelper::get('usuario_nombre');
        
        // Obtener restaurantes del usuario
        $restaurantes = $this->getRestaurantesByUsuario($usuarioId);
        
        // Pasar datos a la plantilla
        $this->smarty->assign('nombre', $nombre);
        $this->smarty->assign('titulo', 'Restaurantes');
        $this->smarty->assign('seccion_activa', 'restaurantes');
        $this->smarty->assign('restaurantes', $restaurantes);
        $this->smarty->assign('css_adicional', ['restaurantes.css']);
        // $this->smarty->assign('js_adicional', ['restaurantes.js']); // Si hay JS específico
        $this->smarty->display('restaurantes/index.tpl');
    }

    // 🔁 Utilidad privada para mapear objeto a array JSON
    private function mapRestaurante(Restaurante $r): array {
        return [
            'id' => $r->getId(),
            'nombre' => $r->getNombre(),
            'direccion' => $r->getDireccion(),
            'telefono' => $r->getTelefono(),
            'email' => $r->getEmail(),
            'imagen' => $r->getImagen(),
            'descripcion' => $r->getDescripcion(),
            'activo' => $r->isActivo(),
            'fecha_registro' => $r->getFechaRegistro()->format('Y-m-d H:i:s'),
        ];
    }
}