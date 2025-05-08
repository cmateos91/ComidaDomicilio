<?php

namespace Comida\Domicilio\Repositories;

use Comida\Domicilio\Models\Pedido;
use Comida\Domicilio\Models\Restaurante;
use Comida\Domicilio\Models\Usuario;
use Doctrine\ORM\EntityRepository;

class PedidoRepository extends EntityRepository
{
    /**
     * Obtiene pedidos entre dos fechas
     *
     * @param \DateTime $desde
     * @param \DateTime $hasta
     * @return array
     */
    public function getPedidosEntreFechas(\DateTime $desde, \DateTime $hasta): array
    {
        $conn = $this->getEntityManager()->getConnection();
        
        $sql = "SELECT p.* 
               FROM pedidos p 
               WHERE p.fecha_pedido BETWEEN :desde AND :hasta 
               ORDER BY p.fecha_pedido DESC";
        
        $stmt = $conn->prepare($sql);
        $stmt->bindValue('desde', $desde->format('Y-m-d H:i:s'));
        $stmt->bindValue('hasta', $hasta->format('Y-m-d H:i:s'));
        $result = $stmt->executeQuery();
        
        return $this->hidratarPedidosDesdeResultado($result->fetchAllAssociative());
    }
    
    /**
     * Obtiene pedidos de hoy
     * 
     * @return array
     */
    public function getPedidosHoy(): array
    {
        $hoy = new \DateTime('today');
        $hoyFin = new \DateTime('today 23:59:59');
        
        return $this->getPedidosEntreFechas($hoy, $hoyFin);
    }
    
    /**
     * Convierte un array de datos en objetos Pedido
     *
     * @param array $pedidosData
     * @return array
     */
    private function hidratarPedidosDesdeResultado(array $pedidosData): array
    {
        $em = $this->getEntityManager();
        $pedidos = [];
        
        foreach ($pedidosData as $data) {
            // Crear objeto Pedido manualmente
            $pedido = new Pedido();
            
            // Utilizar reflexión para establecer el ID
            $reflClass = new \ReflectionClass(Pedido::class);
            $idProperty = $reflClass->getProperty('id');
            $idProperty->setAccessible(true);
            $idProperty->setValue($pedido, $data['id']);
            
            // Establecer valores directos
            $pedido->setFechaPedido(new \DateTime($data['fecha_pedido']));
            $pedido->setEstado($data['estado']);
            $pedido->setTotal($data['total']);
            $pedido->setDireccionEntrega($data['direccion_entrega'] ?? null);
            $pedido->setTelefonoContacto($data['telefono_contacto'] ?? null);
            $pedido->setNotas($data['notas'] ?? null);
            
            // Cargar usuario y restaurante
            $usuario = $em->getReference(Usuario::class, $data['usuario_id']);
            $restaurante = $em->getReference(Restaurante::class, $data['restaurante_id']);
            $pedido->setUsuario($usuario);
            $pedido->setRestaurante($restaurante);
            
            $pedidos[] = $pedido;
        }
        
        return $pedidos;
    }

    /**
     * Cuenta los pedidos de hoy para un restaurante específico
     * 
     * @param Restaurante $restaurante
     * @return int
     */
    public function contarPedidosHoyRestaurante(Restaurante $restaurante): int
    {
        $conn = $this->getEntityManager()->getConnection();
        
        $hoy = new \DateTime('today');
        $hoyFin = new \DateTime('today 23:59:59');
        
        $sql = "SELECT COUNT(id) as total 
               FROM pedidos 
               WHERE restaurante_id = :restauranteId 
               AND fecha_pedido BETWEEN :fechaInicio AND :fechaFin";
        
        $stmt = $conn->prepare($sql);
        $stmt->bindValue('restauranteId', $restaurante->getId());
        $stmt->bindValue('fechaInicio', $hoy->format('Y-m-d H:i:s'));
        $stmt->bindValue('fechaFin', $hoyFin->format('Y-m-d H:i:s'));
        $result = $stmt->executeQuery();
        
        return (int) $result->fetchOne();
    }

    /**
     * Obtiene pedidos pendientes
     * 
     * @return array
     */
    public function getPedidosPendientes(): array
    {
        return $this->createQueryBuilder('p')
            ->where('p.estado = :estado')
            ->setParameter('estado', 'pendiente')
            ->orderBy('p.fechaPedido', 'ASC')
            ->getQuery()
            ->getResult();
    }
    
    /**
     * Obtiene pedidos de un usuario con productos y restaurantes precargados
     * 
     * @param Usuario $usuario
     * @param int $limit Límite de resultados (0 = sin límite)
     * @return array
     */
    public function getPedidosUsuarioConDetalles(Usuario $usuario, int $limit = 0): array
    {
        $conn = $this->getEntityManager()->getConnection();
        
        $sql = "SELECT p.* 
               FROM pedidos p 
               WHERE p.usuario_id = :usuarioId 
               ORDER BY p.fecha_pedido DESC";
               
        if ($limit > 0) {
            $sql .= " LIMIT " . intval($limit);
        }
        
        $stmt = $conn->prepare($sql);
        $stmt->bindValue('usuarioId', $usuario->getId());
        $result = $stmt->executeQuery();
        $pedidosData = $result->fetchAllAssociative();
        
        $em = $this->getEntityManager();
        $pedidos = [];
        
        foreach ($pedidosData as $data) {
            // Crear objeto Pedido manualmente
            $pedido = new Pedido();
            
            // Utilizar reflexión para establecer el ID
            $reflClass = new \ReflectionClass(Pedido::class);
            $idProperty = $reflClass->getProperty('id');
            $idProperty->setAccessible(true);
            $idProperty->setValue($pedido, $data['id']);
            
            // Establecer valores directos
            $pedido->setFechaPedido(new \DateTime($data['fecha_pedido']));
            $pedido->setEstado($data['estado']);
            $pedido->setTotal($data['total']);
            $pedido->setDireccionEntrega($data['direccion_entrega'] ?? null);
            $pedido->setTelefonoContacto($data['telefono_contacto'] ?? null);
            $pedido->setNotas($data['notas'] ?? null);
            
            // Cargar usuario y restaurante
            $usuario = $em->getReference(Usuario::class, $data['usuario_id']);
            $restaurante = $em->getReference(Restaurante::class, $data['restaurante_id']);
            $pedido->setUsuario($usuario);
            $pedido->setRestaurante($restaurante);
            
            // Cargar items del pedido (opcional - solo si es necesario)
            // Por ahora no cargamos los items para evitar consultas adicionales
            
            $pedidos[] = $pedido;
        }
        
        return $pedidos;
    }
    
    /**
     * Obtiene estadísticas de pedidos por restaurante
     * 
     * @param \DateTime $desde
     * @param \DateTime $hasta
     * @return array
     */
    public function getEstadisticasPorRestaurante(\DateTime $desde, \DateTime $hasta): array
    {
        $conn = $this->getEntityManager()->getConnection();
        
        $sql = "SELECT restaurante_id as restauranteId, COUNT(id) as totalPedidos, SUM(total) as montoTotal 
               FROM pedidos 
               WHERE fecha_pedido BETWEEN :desde AND :hasta 
               GROUP BY restaurante_id";
        
        $stmt = $conn->prepare($sql);
        $stmt->bindValue('desde', $desde->format('Y-m-d H:i:s'));
        $stmt->bindValue('hasta', $hasta->format('Y-m-d H:i:s'));
        $result = $stmt->executeQuery();
        
        return $result->fetchAllAssociative();
    }
}
