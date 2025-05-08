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
        return $this->createQueryBuilder('p')
            ->where('p.fechaPedido BETWEEN :desde AND :hasta')
            ->setParameter('desde', $desde)
            ->setParameter('hasta', $hasta)
            ->orderBy('p.fechaPedido', 'DESC')
            ->getQuery()
            ->getResult();
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
     * Cuenta los pedidos de hoy para un restaurante específico
     * 
     * @param Restaurante $restaurante
     * @return int
     */
    public function contarPedidosHoyRestaurante(Restaurante $restaurante): int
    {
        $hoy = new \DateTime('today');
        $hoyFin = new \DateTime('today 23:59:59');
        
        return $this->createQueryBuilder('p')
            ->select('COUNT(p.id)')
            ->where('p.restaurante = :restaurante')
            ->andWhere('p.fechaPedido BETWEEN :fechaInicio AND :fechaFin')
            ->setParameter('restaurante', $restaurante)
            ->setParameter('fechaInicio', $hoy)
            ->setParameter('fechaFin', $hoyFin)
            ->getQuery()
            ->getSingleScalarResult();
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
        $qb = $this->createQueryBuilder('p')
            ->where('p.usuario = :usuario')
            ->setParameter('usuario', $usuario)
            ->orderBy('p.fechaPedido', 'DESC');
            
        if ($limit > 0) {
            $qb->setMaxResults($limit);
        }
        
        return $qb->getQuery()->getResult();
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
        return $this->createQueryBuilder('p')
            ->select('IDENTITY(p.restaurante) as restauranteId, COUNT(p.id) as totalPedidos, SUM(p.total) as montoTotal')
            ->where('p.fechaPedido BETWEEN :desde AND :hasta')
            ->groupBy('p.restaurante')
            ->setParameter('desde', $desde)
            ->setParameter('hasta', $hasta)
            ->getQuery()
            ->getResult();
    }
}
