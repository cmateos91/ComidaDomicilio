<?php
namespace Comida\Domicilio\Models;

use Doctrine\ORM\Mapping as ORM;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;

#[ORM\Entity]
#[ORM\Table(name: "productos")]
class Producto
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column(type: "integer")]
    private int $id;

    #[ORM\Column(type: "string", length: 100)]
    private string $nombre;

    #[ORM\Column(type: "text", nullable: true)]
    private ?string $descripcion = null;

    #[ORM\Column(type: "decimal", precision: 8, scale: 2)]
    private float $precio;

    #[ORM\Column(type: "string", length: 50)]
    private string $categoria;

    #[ORM\Column(type: "string", length: 255, nullable: true)]
    private ?string $imagen = null;

    #[ORM\Column(type: "boolean")]
    private bool $disponible = true;

    #[ORM\Column(type: "string", length: 255, nullable: true)]
    private ?string $alergenos = null;

    #[ORM\Column(type: "integer", nullable: true)]
    private ?int $calorias = null;

    #[ORM\Column(type: "decimal", precision: 6, scale: 2, nullable: true)]
    private ?float $grasas = null;

    #[ORM\Column(type: "decimal", precision: 6, scale: 2, nullable: true)]
    private ?float $proteinas = null;

    #[ORM\Column(type: "decimal", precision: 6, scale: 2, nullable: true)]
    private ?float $hidratos = null;

    #[ORM\Column(type: "decimal", precision: 6, scale: 2, nullable: true)]
    private ?float $azucares = null;

    #[ORM\Column(type: "decimal", precision: 6, scale: 2, nullable: true)]
    private ?float $fibra = null;

    #[ORM\Column(type: "decimal", precision: 6, scale: 2, nullable: true)]
    private ?float $sal = null;

    #[ORM\ManyToOne(targetEntity: Restaurante::class, inversedBy: "productos")]
    #[ORM\JoinColumn(name: "restaurante_id", referencedColumnName: "id")]
    private ?Restaurante $restaurante = null;
    
    #[ORM\OneToMany(targetEntity: ItemPedido::class, mappedBy: "producto")]
    private Collection $itemsPedido;
    
    #[ORM\OneToMany(targetEntity: ItemCarrito::class, mappedBy: "producto")]
    private Collection $itemsCarrito;

    #[ORM\Column(type: "datetime", name: "creado_en", nullable: true)]
    private ?\DateTime $creadoEn = null;

    /**
     * Constructor
     */
    public function __construct()
    {
        $this->disponible = true;
        $this->creadoEn = new \DateTime();
        $this->itemsPedido = new ArrayCollection();
        $this->itemsCarrito = new ArrayCollection();
    }

    /**
     * Get id
     */
    public function getId(): int
    {
        return $this->id;
    }

    /**
     * Get nombre
     */
    public function getNombre(): string
    {
        return $this->nombre;
    }

    /**
     * Set nombre
     */
    public function setNombre(string $nombre): self
    {
        $this->nombre = $nombre;
        return $this;
    }

    /**
     * Get descripcion
     */
    public function getDescripcion(): ?string
    {
        return $this->descripcion;
    }

    /**
     * Set descripcion
     */
    public function setDescripcion(?string $descripcion): self
    {
        $this->descripcion = $descripcion;
        return $this;
    }

    /**
     * Get precio
     */
    public function getPrecio(): float
    {
        return $this->precio;
    }

    /**
     * Set precio
     */
    public function setPrecio(float $precio): self
    {
        $this->precio = $precio;
        return $this;
    }

    /**
     * Get categoria
     */
    public function getCategoria(): string
    {
        return $this->categoria;
    }

    /**
     * Set categoria
     */
    public function setCategoria(string $categoria): self
    {
        $this->categoria = $categoria;
        return $this;
    }

    /**
     * Get imagen
     */
    public function getImagen(): ?string
    {
        return $this->imagen;
    }

    /**
     * Set imagen
     */
    public function setImagen(?string $imagen): self
    {
        $this->imagen = $imagen;
        return $this;
    }

    /**
     * Check if producto is disponible
     */
    public function isDisponible(): bool
    {
        return $this->disponible;
    }

    /**
     * Set disponible
     */
    public function setDisponible(bool $disponible): self
    {
        $this->disponible = $disponible;
        return $this;
    }

    /**
     * Get alergenos
     */
    public function getAlergenos(): ?string
    {
        return $this->alergenos;
    }

    /**
     * Set alergenos
     */
    public function setAlergenos(?string $alergenos): self
    {
        $this->alergenos = $alergenos;
        return $this;
    }

    /**
     * Get calorias
     */
    public function getCalorias(): ?int
    {
        return $this->calorias;
    }

    /**
     * Set calorias
     */
    public function setCalorias(?int $calorias): self
    {
        $this->calorias = $calorias;
        return $this;
    }

    /**
     * Get grasas
     */
    public function getGrasas(): ?float
    {
        return $this->grasas;
    }

    /**
     * Set grasas
     */
    public function setGrasas(?float $grasas): self
    {
        $this->grasas = $grasas;
        return $this;
    }

    /**
     * Get proteinas
     */
    public function getProteinas(): ?float
    {
        return $this->proteinas;
    }

    /**
     * Set proteinas
     */
    public function setProteinas(?float $proteinas): self
    {
        $this->proteinas = $proteinas;
        return $this;
    }

    /**
     * Get hidratos
     */
    public function getHidratos(): ?float
    {
        return $this->hidratos;
    }

    /**
     * Set hidratos
     */
    public function setHidratos(?float $hidratos): self
    {
        $this->hidratos = $hidratos;
        return $this;
    }

    /**
     * Get azucares
     */
    public function getAzucares(): ?float
    {
        return $this->azucares;
    }

    /**
     * Set azucares
     */
    public function setAzucares(?float $azucares): self
    {
        $this->azucares = $azucares;
        return $this;
    }

    /**
     * Get fibra
     */
    public function getFibra(): ?float
    {
        return $this->fibra;
    }

    /**
     * Set fibra
     */
    public function setFibra(?float $fibra): self
    {
        $this->fibra = $fibra;
        return $this;
    }

    /**
     * Get sal
     */
    public function getSal(): ?float
    {
        return $this->sal;
    }

    /**
     * Set sal
     */
    public function setSal(?float $sal): self
    {
        $this->sal = $sal;
        return $this;
    }

    /**
     * Get restaurante
     */
    public function getRestaurante(): ?Restaurante
    {
        return $this->restaurante;
    }

    /**
     * Set restaurante
     */
    public function setRestaurante(?Restaurante $restaurante): self
    {
        $this->restaurante = $restaurante;
        return $this;
    }
    
    /**
     * Get restaurante ID (para compatibilidad con código existente)
     */
    public function getRestauranteId(): ?int
    {
        return $this->restaurante ? $this->restaurante->getId() : null;
    }
    
    /**
     * Get items pedido
     */
    public function getItemsPedido(): Collection
    {
        return $this->itemsPedido;
    }
    
    /**
     * Add item pedido
     */
    public function addItemPedido(ItemPedido $item): self
    {
        if (!$this->itemsPedido->contains($item)) {
            $this->itemsPedido[] = $item;
            $item->setProducto($this);
        }
        return $this;
    }
    
    /**
     * Remove item pedido
     */
    public function removeItemPedido(ItemPedido $item): self
    {
        if ($this->itemsPedido->removeElement($item)) {
            if ($item->getProducto() === $this) {
                $item->setProducto(null);
            }
        }
        return $this;
    }
    
    /**
     * Get items carrito
     */
    public function getItemsCarrito(): Collection
    {
        return $this->itemsCarrito;
    }
    
    /**
     * Add item carrito
     */
    public function addItemCarrito(ItemCarrito $item): self
    {
        if (!$this->itemsCarrito->contains($item)) {
            $this->itemsCarrito[] = $item;
            $item->setProducto($this);
        }
        return $this;
    }
    
    /**
     * Remove item carrito
     */
    public function removeItemCarrito(ItemCarrito $item): self
    {
        if ($this->itemsCarrito->removeElement($item)) {
            if ($item->getProducto() === $this) {
                $item->setProducto(null);
            }
        }
        return $this;
    }

    /**
     * Get fecha de creación
     */
    public function getCreadoEn(): ?\DateTime
    {
        return $this->creadoEn;
    }

    /**
     * Set fecha de creación
     */
    public function setCreadoEn(?\DateTime $creadoEn): self
    {
        $this->creadoEn = $creadoEn;
        return $this;
    }
}
