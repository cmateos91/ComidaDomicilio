<?php
namespace Comida\Domicilio\Models;

use Doctrine\ORM\Mapping as ORM;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;

#[ORM\Entity(repositoryClass: "Comida\Domicilio\Repositories\PedidoRepository")]
#[ORM\Table(name: "pedidos")]
class Pedido
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column(type: "integer")]
    private int $id;

    #[ORM\ManyToOne(targetEntity: Restaurante::class, inversedBy: "pedidos")]
    #[ORM\JoinColumn(name: "restaurante_id", referencedColumnName: "id")]
    private ?Restaurante $restaurante = null;

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

    #[ORM\ManyToOne(targetEntity: Usuario::class, inversedBy: "pedidos")]
    #[ORM\JoinColumn(name: "usuario_id", referencedColumnName: "id")]
    private ?Usuario $usuario = null;
    
    #[ORM\OneToMany(targetEntity: ItemPedido::class, mappedBy: "pedido", cascade: ["persist", "remove"])]
    private Collection $items;
    
    // Getters y setters
    
    public function __construct() {
        $this->items = new ArrayCollection();
        $this->fechaPedido = new \DateTime();
        $this->estado = "pendiente";
    }

    public function getId(): int {
        return $this->id;
    }

    public function getRestaurante(): ?Restaurante {
        return $this->restaurante;
    }

    public function setRestaurante(?Restaurante $restaurante): self {
        $this->restaurante = $restaurante;
        return $this;
    }
    
    // Métodos para mantener compatibilidad con código existente
    public function getRestauranteId(): ?int {
        return $this->restaurante ? $this->restaurante->getId() : null;
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

    public function getUsuario(): ?Usuario {
        return $this->usuario;
    }

    public function setUsuario(?Usuario $usuario): self {
        $this->usuario = $usuario;
        return $this;
    }
    
    // Métodos para mantener compatibilidad con código existente
    public function getUsuarioId(): ?int {
        return $this->usuario ? $this->usuario->getId() : null;
    }
    
    public function getItems(): Collection {
        return $this->items;
    }
    
    public function addItem(ItemPedido $item): self {
        if (!$this->items->contains($item)) {
            $this->items[] = $item;
            $item->setPedido($this);
        }
        return $this;
    }
    
    public function removeItem(ItemPedido $item): self {
        if ($this->items->removeElement($item)) {
            if ($item->getPedido() === $this) {
                $item->setPedido(null);
            }
        }
        return $this;
    }
    
    public function calcularTotal(): float {
        $total = 0;
        foreach ($this->items as $item) {
            $total += $item->getSubtotal();
        }
        return $total;
    }
    
    public function actualizarTotal(): self {
        $this->total = $this->calcularTotal();
        return $this;
    }
}