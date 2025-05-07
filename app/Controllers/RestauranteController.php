<?php

namespace Comida\Domicilio\Controllers;

use Comida\Domicilio\Models\Restaurante;
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
            // Usamos SQL nativo para unir con la tabla usuario_restaurante
            $conn = $this->em->getConnection();
            $sql = "
                SELECT r.* 
                FROM restaurante r
                INNER JOIN usuario_restaurante ur ON r.id = ur.restaurante_id
                WHERE ur.usuario_id = :usuarioId
                AND r.activo = 1
                ORDER BY r.nombre ASC
            ";
            
            $stmt = $conn->prepare($sql);
            $stmt->bindValue('usuarioId', $usuarioId);
            $result = $stmt->executeQuery();
            $restaurantesData = $result->fetchAllAssociative();
            
            // Convertimos los datos en objetos Restaurante
            $restaurantes = [];
            foreach ($restaurantesData as $data) {
                $restaurante = new Restaurante();
                $restaurante->setNombre($data['nombre']);
                $restaurante->setDireccion($data['direccion']);
                if (isset($data['telefono'])) $restaurante->setTelefono($data['telefono']);
                if (isset($data['email'])) $restaurante->setEmail($data['email']);
                if (isset($data['imagen'])) $restaurante->setImagen($data['imagen']);
                if (isset($data['descripcion'])) $restaurante->setDescripcion($data['descripcion']);
                $restaurante->setActivo($data['activo'] == 1);
                
                // Propiedades privadas que no podemos establecer directamente
                $reflClass = new \ReflectionClass(Restaurante::class);
                
                $idProperty = $reflClass->getProperty('id');
                $idProperty->setAccessible(true);
                $idProperty->setValue($restaurante, $data['id']);
                
                $fechaProperty = $reflClass->getProperty('fechaRegistro');
                $fechaProperty->setAccessible(true);
                $fechaProperty->setValue($restaurante, new \DateTime($data['fecha_registro']));
                
                $restaurantes[] = $restaurante;
            }
            
            return $restaurantes;
        } catch (\Exception $e) {
            // Manejo de errores
            error_log($e->getMessage());
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
        $this->smarty->assign('restaurantes', $restaurantes);
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