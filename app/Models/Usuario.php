<?php

namespace Comida\Domicilio\Models;

use Doctrine\ORM\Mapping as ORM;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;

#[ORM\Entity]
#[ORM\Table(name: "usuario")]
class Usuario
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column(type: "integer")]
    private int $id;

    #[ORM\Column(type: "string", length: 100)]
    private string $nombre;

    #[ORM\Column(type: "string", length: 120, unique: true)]
    private string $email;

    #[ORM\Column(type: "string", length: 255)]
    private string $password;

    #[ORM\Column(type: "string", length: 20, nullable: true)]
    private ?string $telefono = null;

    #[ORM\Column(type: "string", length: 255, nullable: true)]
    private ?string $direccion = null;

    #[ORM\Column(name: "fecha_registro", type: "datetime")]
    private \DateTime $fechaRegistro;

    #[ORM\Column(type: "boolean", options: ["default" => false])]
    private bool $verificado = false;

    #[ORM\Column(name: "token_verificacion", type: "string", length: 255, nullable: true)]
    private ?string $tokenVerificacion = null;

    #[ORM\Column(name: "reset_token", type: "string", length: 255, nullable: true)]
    private ?string $resetToken = null;
    
    #[ORM\Column(name: "reset_token_expira", type: "datetime", nullable: true)]
    private ?\DateTime $resetTokenExpira = null;

    #[ORM\Column(type: "string", length: 50)]
    private string $rol;

    #[ORM\Column(type: "boolean", options: ["default" => true])]
    private bool $activo = true;

    #[ORM\ManyToMany(targetEntity: Restaurante::class, inversedBy: "usuarios")]
    #[ORM\JoinTable(name: "usuario_restaurante",
        joinColumns: [new ORM\JoinColumn(name: "usuario_id", referencedColumnName: "id")],
        inverseJoinColumns: [new ORM\JoinColumn(name: "restaurante_id", referencedColumnName: "id")]
    )]
    private Collection $restaurantes;
    
    #[ORM\OneToMany(targetEntity: Pedido::class, mappedBy: "usuario")]
    private Collection $pedidos;
    
    #[ORM\OneToMany(targetEntity: Carrito::class, mappedBy: "usuario")]
    private Collection $carritos;

    // Getters y Setters

    public function getId(): int { return $this->id; }

    public function getNombre(): string { return $this->nombre; }
    public function setNombre(string $nombre): void { $this->nombre = $nombre; }

    public function getEmail(): string { return $this->email; }
    public function setEmail(string $email): void { $this->email = $email; }

    public function getPassword(): string { return $this->password; }
    public function setPassword(string $password): void { $this->password = $password; }

    public function getTelefono(): ?string { return $this->telefono; }
    public function setTelefono(?string $telefono): void { $this->telefono = $telefono; }

    public function getDireccion(): ?string { return $this->direccion; }
    public function setDireccion(?string $direccion): void { $this->direccion = $direccion; }

    public function getFechaRegistro(): \DateTime { return $this->fechaRegistro; }
    public function setFechaRegistro(\DateTime $fecha): void { $this->fechaRegistro = $fecha; }

    public function isVerificado(): bool { return $this->verificado; }
    public function setVerificado(bool $verificado): void { $this->verificado = $verificado; }

    public function getTokenVerificacion(): ?string { return $this->tokenVerificacion; }
    public function setTokenVerificacion(?string $token): void { $this->tokenVerificacion = $token; }

    public function getResetToken(): ?string { return $this->resetToken; }
    public function setResetToken(?string $token): void { $this->resetToken = $token; }

    public function getResetTokenExpira(): ?\DateTime { return $this->resetTokenExpira; }
    public function setResetTokenExpira(?\DateTime $fecha): void { $this->resetTokenExpira = $fecha; }

    public function getRol(): string { return $this->rol; }
    public function setRol(string $rol): void { $this->rol = $rol; }

    public function isActivo(): bool { return $this->activo; }
    public function setActivo(bool $activo): void { $this->activo = $activo; }
    
    public function __construct() {
        $this->restaurantes = new ArrayCollection();
        $this->pedidos = new ArrayCollection();
        $this->carritos = new ArrayCollection();
        $this->fechaRegistro = new \DateTime();
    }
    
    public function getRestaurantes(): Collection {
        return $this->restaurantes;
    }
    
    public function addRestaurante(Restaurante $restaurante): self {
        if (!$this->restaurantes->contains($restaurante)) {
            $this->restaurantes[] = $restaurante;
        }
        return $this;
    }
    
    public function removeRestaurante(Restaurante $restaurante): self {
        $this->restaurantes->removeElement($restaurante);
        return $this;
    }
    
    public function getPedidos(): Collection {
        return $this->pedidos;
    }
    
    public function addPedido(Pedido $pedido): self {
        if (!$this->pedidos->contains($pedido)) {
            $this->pedidos[] = $pedido;
            $pedido->setUsuario($this);
        }
        return $this;
    }
    
    public function removePedido(Pedido $pedido): self {
        if ($this->pedidos->removeElement($pedido)) {
            if ($pedido->getUsuario() === $this) {
                $pedido->setUsuario(null);
            }
        }
        return $this;
    }
    
    public function getCarritos(): Collection {
        return $this->carritos;
    }
    
    public function getCarritoActivo(): ?Carrito {
        foreach ($this->carritos as $carrito) {
            if ($carrito->isActivo()) {
                return $carrito;
            }
        }
        return null;
    }
    
    public function addCarrito(Carrito $carrito): self {
        if (!$this->carritos->contains($carrito)) {
            $this->carritos[] = $carrito;
            $carrito->setUsuario($this);
        }
        return $this;
    }
    
    public function removeCarrito(Carrito $carrito): self {
        if ($this->carritos->removeElement($carrito)) {
            if ($carrito->getUsuario() === $this) {
                $carrito->setUsuario(null);
            }
        }
        return $this;
    }
}
