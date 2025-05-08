<?php
namespace Comida\Domicilio\Models;

use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity]
#[ORM\Table(name: "carritos")]
class Carrito
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column(type: "integer")]
    private int $id;

    #[ORM\Column(type: "datetime", name: "fecha_creacion")]
    private \DateTime $fechaCreacion;

    #[ORM\Column(type: "boolean")]
    private bool $activo = true;

    #[ORM\Column(type: "integer", name: "usuario_id")]
    private int $usuarioId;

    /**
     * Constructor
     */
    public function __construct()
    {
        $this->fechaCreacion = new \DateTime();
        $this->activo = true;
    }

    /**
     * Get id
     */
    public function getId(): int
    {
        return $this->id;
    }

    /**
     * Get fecha de creación
     */
    public function getFechaCreacion(): \DateTime
    {
        return $this->fechaCreacion;
    }

    /**
     * Set fecha de creación
     */
    public function setFechaCreacion(\DateTime $fechaCreacion): self
    {
        $this->fechaCreacion = $fechaCreacion;
        return $this;
    }

    /**
     * Check if carrito is active
     */
    public function isActivo(): bool
    {
        return $this->activo;
    }

    /**
     * Set active status
     */
    public function setActivo(bool $activo): self
    {
        $this->activo = $activo;
        return $this;
    }

    /**
     * Get usuario
     */
    public function getUsuario(): ?Usuario
    {
        return $this->usuario;
    }

    /**
     * Set usuario
     */
    public function setUsuario(?Usuario $usuario): self
    {
        $this->usuario = $usuario;
        return $this;
    }
    
    /**
     * Get usuario ID (para compatibilidad con código existente)
     */
    public function getUsuarioId(): ?int
    {
        return $this->usuario ? $this->usuario->getId() : null;
    }
    
    /**
     * Get items
     */
    public function getItems(): Collection
    {
        return $this->items;
    }
    
    /**
     * Add item
     */
    public function addItem(ItemCarrito $item): self
    {
        if (!$this->items->contains($item)) {
            $this->items[] = $item;
            $item->setCarrito($this);
        }
        return $this;
    }
    
    /**
     * Remove item
     */
    public function removeItem(ItemCarrito $item): self
    {
        if ($this->items->removeElement($item)) {
            if ($item->getCarrito() === $this) {
                $item->setCarrito(null);
            }
        }
        return $this;
    }
    
    /**
     * Calcular total del carrito
     */
    public function calcularTotal(): float
    {
        $total = 0;
        foreach ($this->items as $item) {
            $total += $item->getSubtotal();
        }
        return $total;
    }
}
