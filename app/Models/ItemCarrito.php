<?php
namespace Comida\Domicilio\Models;

use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity]
#[ORM\Table(name: "items_carrito")]
class ItemCarrito
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column(type: "integer")]
    private int $id;

    #[ORM\Column(type: "integer")]
    private int $cantidad;

    #[ORM\Column(type: "decimal", precision: 10, scale: 2, name: "precio_unitario")]
    private float $precioUnitario;

    #[ORM\ManyToOne(targetEntity: Carrito::class, inversedBy: "items")]
    #[ORM\JoinColumn(name: "carrito_id", referencedColumnName: "id")]
    private ?Carrito $carrito = null;

    #[ORM\ManyToOne(targetEntity: Producto::class, inversedBy: "itemsCarrito")]
    #[ORM\JoinColumn(name: "producto_id", referencedColumnName: "id")]
    private ?Producto $producto = null;

    /**
     * Constructor
     */
    public function __construct()
    {
        $this->cantidad = 1; // Por defecto, 1 unidad
    }

    /**
     * Get id
     */
    public function getId(): int
    {
        return $this->id;
    }

    /**
     * Get cantidad
     */
    public function getCantidad(): int
    {
        return $this->cantidad;
    }

    /**
     * Set cantidad
     */
    public function setCantidad(int $cantidad): self
    {
        $this->cantidad = $cantidad;
        return $this;
    }

    /**
     * Get precio unitario
     */
    public function getPrecioUnitario(): float
    {
        return $this->precioUnitario;
    }

    /**
     * Set precio unitario
     */
    public function setPrecioUnitario(float $precioUnitario): self
    {
        $this->precioUnitario = $precioUnitario;
        return $this;
    }

    /**
     * Get carrito
     */
    public function getCarrito(): ?Carrito
    {
        return $this->carrito;
    }

    /**
     * Set carrito
     */
    public function setCarrito(?Carrito $carrito): self
    {
        $this->carrito = $carrito;
        return $this;
    }
    
    /**
     * Get carrito ID (para compatibilidad con código existente)
     */
    public function getCarritoId(): ?int
    {
        return $this->carrito ? $this->carrito->getId() : null;
    }

    /**
     * Get producto
     */
    public function getProducto(): ?Producto
    {
        return $this->producto;
    }

    /**
     * Set producto
     */
    public function setProducto(?Producto $producto): self
    {
        $this->producto = $producto;
        
        // Actualizar el precio unitario con el del producto
        if ($producto) {
            $this->setPrecioUnitario($producto->getPrecio());
        }
        
        return $this;
    }
    
    /**
     * Get producto ID (para compatibilidad con código existente)
     */
    public function getProductoId(): ?int
    {
        return $this->producto ? $this->producto->getId() : null;
    }

    /**
     * Get subtotal (precio * cantidad)
     */
    public function getSubtotal(): float
    {
        return $this->precioUnitario * $this->cantidad;
    }
}
