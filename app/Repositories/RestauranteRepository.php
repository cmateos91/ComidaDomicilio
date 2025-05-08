<?php

namespace Comida\Domicilio\Repositories;

use Comida\Domicilio\Models\Restaurante;
use Comida\Domicilio\Models\Usuario;
use Doctrine\ORM\EntityRepository;

class RestauranteRepository extends EntityRepository
{
    /**
     * Obtiene restaurantes activos
     * 
     * @return array
     */
    public function getRestaurantesActivos(): array
    {
        return $this->createQueryBuilder('r')
            ->where('r.activo = :activo')
            ->setParameter('activo', true)
            ->orderBy('r.nombre', 'ASC')
            ->getQuery()
            ->getResult();
    }

    /**
     * Obtiene restaurantes populares (ordenados por número de pedidos)
     * 
     * @param int $limit
     * @return array
     */
    public function getRestaurantesPopulares(int $limit = 5): array
    {
        // Usaremos una aproximación más sencilla sin subconsultas en JOIN
        $em = $this->getEntityManager();
        $conn = $em->getConnection();
        
        // Primero obtenemos los IDs de restaurantes ordenados por número de pedidos
        $sql = "SELECT r.id, COUNT(p.id) AS num_pedidos 
               FROM restaurante r 
               LEFT JOIN pedidos p ON r.id = p.restaurante_id 
               WHERE r.activo = :activo 
               GROUP BY r.id 
               ORDER BY num_pedidos DESC 
               LIMIT " . intval($limit);
        
        $stmt = $conn->prepare($sql);
        $stmt->bindValue('activo', true);
        $result = $stmt->executeQuery();
        
        $popularIds = $result->fetchAllAssociative();
        
        // Si no hay resultados, devolver un array vacío
        if (empty($popularIds)) {
            return [];
        }
        
        // Extraer solo los IDs
        $ids = array_map(function($row) { return $row['id']; }, $popularIds);
        
        // Ahora obtenemos los objetos Restaurante completos
        $qb = $this->createQueryBuilder('r');
        $qb->where($qb->expr()->in('r.id', $ids))
           ->andWhere('r.activo = :activo')
           ->setParameter('activo', true);
        
        // Ordenar por el orden original de los IDs populares
        $orderByExpr = 'CASE r.id ';
        foreach ($ids as $i => $id) {
            $orderByExpr .= sprintf('WHEN %d THEN %d ', $id, $i);
        }
        $orderByExpr .= 'ELSE ' . count($ids) . ' END';
        
        $qb->orderBy($orderByExpr);
        
        return $qb->getQuery()->getResult();
    }

    /**
     * Obtiene restaurantes asociados a un usuario
     * 
     * @param Usuario $usuario
     * @return array
     */
    public function getRestaurantesByUsuario(Usuario $usuario): array
    {
        $conn = $this->getEntityManager()->getConnection();
        
        $sql = "SELECT r.* 
               FROM restaurante r
               INNER JOIN usuario_restaurante ur ON r.id = ur.restaurante_id
               WHERE ur.usuario_id = :usuarioId
               AND r.activo = 1
               ORDER BY r.nombre ASC";
        
        $stmt = $conn->prepare($sql);
        $stmt->bindValue('usuarioId', $usuario->getId());
        $result = $stmt->executeQuery();
        $restaurantesData = $result->fetchAllAssociative();
        
        // Convertimos los datos a objetos Restaurante
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
    }

    /**
     * Busca restaurantes por nombre o descripción
     * 
     * @param string $termino
     * @return array
     */
    public function buscarRestaurantes(string $termino): array
    {
        return $this->createQueryBuilder('r')
            ->where('r.nombre LIKE :termino OR r.descripcion LIKE :termino')
            ->andWhere('r.activo = :activo')
            ->setParameter('termino', '%' . $termino . '%')
            ->setParameter('activo', true)
            ->orderBy('r.nombre', 'ASC')
            ->getQuery()
            ->getResult();
    }
}
