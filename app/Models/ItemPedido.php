<?php
namespace Comida\Domicilio\Models;

use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity]
#[ORM\Table(name: "items_pedido")]
class ItemPedido
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column(type: "integer")]
    private int $id;

    #[ORM\Column(type: "integer")]
    private int $cantidad;

    #[ORM\Column(type: "decimal", precision: 10, scale: 2, name: "precio_unitario")]
    private float $precioUnitario;

    #[ORM\Column(type: "string", length: 255, name: "notas_producto", nullable: true)]
    private ?string $notasProducto = null;

    #[ORM\ManyToOne(targetEntity: Pedido::class, inversedBy: "items")]
    #[ORM\JoinColumn(name: "pedido_id", referencedColumnName: "id")]
    private ?Pedido $pedido = null;

    #[ORM\ManyToOne(targetEntity: Producto::class, inversedBy: "itemsPedido")]
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
     * Get notas del producto
     */
    public function getNotasProducto(): ?string
    {
        return $this->notasProducto;
    }

    /**
     * Set notas del producto
     */
    public function setNotasProducto(?string $notasProducto): self
    {
        $this->notasProducto = $notasProducto;
        return $this;
    }

    /**
     * Get pedido
     */
    public function getPedido(): ?Pedido
    {
        return $this->pedido;
    }

    /**
     * Set pedido
     */
    public function setPedido(?Pedido $pedido): self
    {
        $this->pedido = $pedido;
        return $this;
    }
    
    /**
     * Get pedido ID (para compatibilidad con código existente)
     */
    public function getPedidoId(): ?int
    {
        return $this->pedido ? $this->pedido->getId() : null;
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
