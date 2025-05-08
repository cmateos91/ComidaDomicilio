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
        $em = $this->getEntityManager();

        // Subconsulta para contar pedidos por restaurante
        $subQuery = $em->createQueryBuilder()
            ->select('IDENTITY(p.restaurante) as restId, COUNT(p.id) as numPedidos')
            ->from('Comida\Domicilio\Models\Pedido', 'p')
            ->groupBy('p.restaurante');
            
        // Consulta principal que une restaurantes con la subconsulta
        $query = $em->createQueryBuilder()
            ->select('r, COALESCE(subq.numPedidos, 0) as HIDDEN numPedidos')
            ->from('Comida\Domicilio\Models\Restaurante', 'r')
            ->leftJoin('(' . $subQuery->getDQL() . ')', 'subq', 'WITH', 'r.id = subq.restId')
            ->where('r.activo = :activo')
            ->setParameter('activo', true)
            ->orderBy('numPedidos', 'DESC')
            ->setMaxResults($limit);
            
        return $query->getQuery()->getResult();
    }

    /**
     * Obtiene restaurantes asociados a un usuario
     * 
     * @param Usuario $usuario
     * @return array
     */
    public function getRestaurantesByUsuario(Usuario $usuario): array
    {
        return $this->createQueryBuilder('r')
            ->join('r.usuarios', 'u')
            ->where('u.id = :usuarioId')
            ->andWhere('r.activo = :activo')
            ->setParameter('usuarioId', $usuario->getId())
            ->setParameter('activo', true)
            ->orderBy('r.nombre', 'ASC')
            ->getQuery()
            ->getResult();
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
