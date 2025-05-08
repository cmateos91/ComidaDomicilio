<?php

namespace Comida\Domicilio\Controllers;

use Comida\Domicilio\Models\Restaurante;
use Comida\Domicilio\Models\Usuario;
use Comida\Domicilio\Models\Pedido;
use Comida\Domicilio\Utils\BaseEntityUtils;
use Comida\Domicilio\Utils\SessionHelper;
use Comida\Domicilio\Core\Controller;
use Doctrine\DBAL\Exception;

class RestauranteController extends Controller {

    public function __construct($entityManager) {
        parent::__construct($entityManager);
        SessionHelper::start();
    }

    // GET /api/restaurantes
    public function index() {
        SessionHelper::check(); // Redirige si no hay sesión válida
        
        $repo = $this->em->getRepository(Restaurante::class);
        $restaurantes = $repo->findAll();

        $data = array_map([BaseEntityUtils::class, 'toArray'], $restaurantes);

        $this->json($data);
    }

    // GET /api/restaurantes/{id}
    public function show($id) {
        $repo = $this->em->getRepository(Restaurante::class);
        $restaurante = $repo->find($id);

        if (!$restaurante) {
            $this->json(['error' => 'Restaurante no encontrado'], 404);
            return;
        }

        $this->json($this->mapRestaurante($restaurante));
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
        $this->render('restaurantes/index.tpl', [
            'nombre' => $nombre,
            'titulo' => 'Restaurantes',
            'seccion_activa' => 'restaurantes',
            'restaurantes' => $restaurantes,
            'css_adicional' => ['restaurantes.css']
        ]);
    }

    // POST /api/restaurantes
    public function create() {
        SessionHelper::check();
        
        $usuarioId = SessionHelper::get('usuario_id');
        $rol = SessionHelper::get('usuario_rol');
        
        // Solo admin o propietario pueden crear restaurantes
        if ($rol !== 'admin' && $rol !== 'propietario') {
            $this->json(['error' => 'No autorizado'], 403);
            return;
        }
        
        // Obtener datos del formulario
        $nombre = $_POST['nombre'] ?? '';
        $direccion = $_POST['direccion'] ?? '';
        $telefono = $_POST['telefono'] ?? '';
        $email = $_POST['email'] ?? '';
        $descripcion = $_POST['descripcion'] ?? '';
        
        // Validación básica
        if (empty($nombre) || empty($direccion)) {
            $this->json(['error' => 'Nombre y dirección son obligatorios'], 400);
            return;
        }
        
        try {
            // Crear el restaurante
            $restaurante = new Restaurante();
            $restaurante->setNombre($nombre);
            $restaurante->setDireccion($direccion);
            $restaurante->setTelefono($telefono);
            $restaurante->setEmail($email);
            $restaurante->setDescripcion($descripcion);
            $restaurante->setFechaRegistro(new \DateTime());
            $restaurante->setActivo(true);
            
            // Guardar en la base de datos
            $this->em->persist($restaurante);
            
            // Asociar el restaurante al usuario
            $usuario = $this->em->getRepository(Usuario::class)->find($usuarioId);
            $usuario->addRestaurante($restaurante);
            
            $this->em->flush();
            
            $this->json([
                'success' => true,
                'restaurante' => $this->mapRestaurante($restaurante)
            ]);
        } catch (\Exception $e) {
            $this->json(['error' => 'Error al crear el restaurante: ' . $e->getMessage()], 500);
        }
    }
    
    // PUT /api/restaurantes/{id}
    public function update($id) {
        SessionHelper::check();
        
        $usuarioId = SessionHelper::get('usuario_id');
        $rol = SessionHelper::get('usuario_rol');
        
        // Obtener el restaurante
        $restaurante = $this->em->getRepository(Restaurante::class)->find($id);
        
        if (!$restaurante) {
            $this->json(['error' => 'Restaurante no encontrado'], 404);
            return;
        }
        
        // Verificar que el usuario tiene permiso para editar este restaurante
        $tienePermiso = false;
        
        if ($rol === 'admin') {
            $tienePermiso = true;
        } else {
            // Verificar si el usuario es propietario del restaurante
            $usuario = $this->em->getRepository(Usuario::class)->find($usuarioId);
            $tienePermiso = $usuario->getRestaurantes()->contains($restaurante);
        }
        
        if (!$tienePermiso) {
            $this->json(['error' => 'No autorizado'], 403);
            return;
        }
        
        // Obtener los datos de la solicitud
        $data = json_decode(file_get_contents("php://input"), true);
        
        if (!$data) {
            $this->json(['error' => 'Datos inválidos'], 400);
            return;
        }
        
        try {
            // Actualizar los campos del restaurante
            if (isset($data['nombre'])) $restaurante->setNombre($data['nombre']);
            if (isset($data['direccion'])) $restaurante->setDireccion($data['direccion']);
            if (isset($data['telefono'])) $restaurante->setTelefono($data['telefono']);
            if (isset($data['email'])) $restaurante->setEmail($data['email']);
            if (isset($data['descripcion'])) $restaurante->setDescripcion($data['descripcion']);
            if (isset($data['activo'])) $restaurante->setActivo((bool)$data['activo']);
            if (isset($data['imagen'])) $restaurante->setImagen($data['imagen']);
            
            $this->em->flush();
            
            $this->json([
                'success' => true,
                'restaurante' => $this->mapRestaurante($restaurante)
            ]);
        } catch (\Exception $e) {
            $this->json(['error' => 'Error al actualizar el restaurante: ' . $e->getMessage()], 500);
        }
    }
    
    // DELETE /api/restaurantes/{id}
    public function delete($id) {
        SessionHelper::check();
        
        $usuarioId = SessionHelper::get('usuario_id');
        $rol = SessionHelper::get('usuario_rol');
        
        // Obtener el restaurante
        $restaurante = $this->em->getRepository(Restaurante::class)->find($id);
        
        if (!$restaurante) {
            $this->json(['error' => 'Restaurante no encontrado'], 404);
            return;
        }
        
        // Verificar que el usuario tiene permiso para eliminar este restaurante
        $tienePermiso = false;
        
        if ($rol === 'admin') {
            $tienePermiso = true;
        } else {
            // Verificar si el usuario es propietario del restaurante
            $usuario = $this->em->getRepository(Usuario::class)->find($usuarioId);
            $tienePermiso = $usuario->getRestaurantes()->contains($restaurante);
        }
        
        if (!$tienePermiso) {
            $this->json(['error' => 'No autorizado'], 403);
            return;
        }
        
        try {
            // En lugar de eliminar, marcamos como inactivo
            $restaurante->setActivo(false);
            $this->em->flush();
            
            $this->json(['success' => true]);
        } catch (\Exception $e) {
            $this->json(['error' => 'Error al eliminar el restaurante: ' . $e->getMessage()], 500);
        }
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
