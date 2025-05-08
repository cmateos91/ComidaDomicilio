<?php
namespace Comida\Domicilio\Models;

use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity]
#[ORM\Table(name: "pedidos")]
class Pedido
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column(type: "integer")]
    private int $id;

    #[ORM\Column(type: "integer", name: "restaurante_id")]
    private int $restauranteId;

    #[ORM\Column(type: "datetime", name: "fecha_pedido")]
    private \DateTime $fechaPedido;

    #[ORM\Column(type: "string", length: 20, name: "estado", nullable: true)]
    private ?string $estado = null;

    #[ORM\Column(type: "decimal", precision: 10, scale: 2, name: "total")]
    private float $total;

    #[ORM\Column(type: "string", length: 255, name: "direccion_entrega", nullable: true)]
    private ?string $direccionEntrega = null;

    #[ORM\Column(type: "string", length: 20, name: "telefono_contacto", nullable: true)]
    private ?string $telefonoContacto = null;

    #[ORM\Column(type: "text", name: "notas", nullable: true)]
    private ?string $notas = null;

    #[ORM\Column(type: "integer", name: "usuario_id")]
    private int $usuarioId;
    
    // Getters y setters

    public function getId(): int {
        return $this->id;
    }

    public function getRestauranteId(): int {
        return $this->restauranteId;
    }

    public function setRestauranteId(int $restauranteId): void {
        $this->restauranteId = $restauranteId;
    }

    public function getFechaPedido(): \DateTime {
        return $this->fechaPedido;
    }

    public function setFechaPedido(\DateTime $fechaPedido): void {
        $this->fechaPedido = $fechaPedido;
    }

    public function getEstado(): ?string {
        return $this->estado;
    }

    public function setEstado(?string $estado): void {
        $this->estado = $estado;
    }

    public function getTotal(): float {
        return $this->total;
    }

    public function setTotal(float $total): void {
        $this->total = $total;
    }

    public function getDireccionEntrega(): ?string {
        return $this->direccionEntrega;
    }

    public function setDireccionEntrega(?string $direccionEntrega): void {
        $this->direccionEntrega = $direccionEntrega;
    }

    public function getTelefonoContacto(): ?string {
        return $this->telefonoContacto;
    }

    public function setTelefonoContacto(?string $telefonoContacto): void {
        $this->telefonoContacto = $telefonoContacto;
    }

    public function getNotas(): ?string {
        return $this->notas;
    }

    public function setNotas(?string $notas): void {
        $this->notas = $notas;
    }

    public function getUsuarioId(): int {
        return $this->usuarioId;
    }

    public function setUsuarioId(int $usuarioId): void {
        $this->usuarioId = $usuarioId;
    }
}