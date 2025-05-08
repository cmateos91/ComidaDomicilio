<?php
namespace Comida\Domicilio\Models;

use Doctrine\ORM\Mapping as ORM;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;

#[ORM\Entity(repositoryClass: "Comida\Domicilio\Repositories\RestauranteRepository")]
#[ORM\Table(name: "restaurante")]
class Restaurante
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column(type: "integer")]
    private int $id;

    #[ORM\Column(type: "string", length: 120)]
    private string $nombre;

    #[ORM\Column(type: "string", length: 255)]
    private string $direccion;

    #[ORM\Column(type: "string", length: 20, nullable: true)]
    private ?string $telefono = null;

    #[ORM\Column(type: "string", length: 120, nullable: true)]
    private ?string $email = null;

    #[ORM\Column(type: "string", length: 255, nullable: true)]
    private ?string $imagen = null;

    #[ORM\Column(type: "text", nullable: true)]
    private ?string $descripcion = null;

    #[ORM\Column(type: "boolean", options: ["default" => true])]
    private bool $activo = true;

    #[ORM\Column(type: "datetime", name: "fecha_registro")]
    private \DateTime $fechaRegistro;
    
    #[ORM\ManyToMany(targetEntity: Usuario::class, mappedBy: "restaurantes")]
    private Collection $usuarios;
    
    #[ORM\OneToMany(targetEntity: Producto::class, mappedBy: "restaurante", cascade: ["persist", "remove"])]
    private Collection $productos;
    
    #[ORM\OneToMany(targetEntity: Pedido::class, mappedBy: "restaurante")]
    private Collection $pedidos;
    
    // Propiedad para almacenar el número de pedidos de hoy (no persistente en BD)
    private int $pedidosHoy = 0;

    // Getters y setters

    public function getId() {
        return $this->id;
    }

    public function getNombre() {
        return $this->nombre;
    }

    public function setNombre($nombre) {
        $this->nombre = $nombre;
    }

    public function getDireccion() {
        return $this->direccion;
    }

    public function setDireccion($direccion) {
        $this->direccion = $direccion;
    }

    public function getTelefono() {
        return $this->telefono;
    }

    public function setTelefono($telefono) {
        $this->telefono = $telefono;
    }

    public function getEmail() {
        return $this->email;
    }

    public function setEmail($email) {
        $this->email = $email;
    }

    public function getImagen() {
        return $this->imagen;
    }

    public function setImagen($imagen) {
        $this->imagen = $imagen;
    }

    public function getDescripcion() {
        return $this->descripcion;
    }

    public function setDescripcion($descripcion) {
        $this->descripcion = $descripcion;
    }

    public function isActivo() {
        return $this->activo;
    }

    public function setActivo($activo) {
        $this->activo = $activo;
    }

    public function getFechaRegistro() {
        return $this->fechaRegistro;
    }

    public function setFechaRegistro($fechaRegistro) {
        $this->fechaRegistro = $fechaRegistro;
    }
    
    public function getPedidosHoy() {
        return $this->pedidosHoy;
    }
    
    public function setPedidosHoy($pedidosHoy) {
        $this->pedidosHoy = $pedidosHoy;
    }
    
    public function __construct() {
        $this->usuarios = new ArrayCollection();
        $this->productos = new ArrayCollection();
        $this->pedidos = new ArrayCollection();
        $this->fechaRegistro = new \DateTime();
    }
    
    public function getUsuarios(): Collection {
        return $this->usuarios;
    }
    
    public function getProductos(): Collection {
        return $this->productos;
    }
    
    public function addProducto(Producto $producto): self {
        if (!$this->productos->contains($producto)) {
            $this->productos[] = $producto;
            $producto->setRestaurante($this);
        }
        return $this;
    }
    
    public function removeProducto(Producto $producto): self {
        if ($this->productos->removeElement($producto)) {
            if ($producto->getRestaurante() === $this) {
                $producto->setRestaurante(null);
            }
        }
        return $this;
    }
    
    public function getPedidos(): Collection {
        return $this->pedidos;
    }
    
    public function addPedido(Pedido $pedido): self {
        if (!$this->pedidos->contains($pedido)) {
            $this->pedidos[] = $pedido;
            $pedido->setRestaurante($this);
        }
        return $this;
    }
    
    public function removePedido(Pedido $pedido): self {
        if ($this->pedidos->removeElement($pedido)) {
            if ($pedido->getRestaurante() === $this) {
                $pedido->setRestaurante(null);
            }
        }
        return $this;
    }
    
}
