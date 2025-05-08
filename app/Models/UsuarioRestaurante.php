<?php
namespace Comida\Domicilio\Models;

use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity]
#[ORM\Table(name: "usuario_restaurante")]
class UsuarioRestaurante
{
    #[ORM\Id]
    #[ORM\Column(type: "integer", name: "usuario_id")]
    private int $usuarioId;

    #[ORM\Id]
    #[ORM\Column(type: "integer", name: "restaurante_id")]
    private int $restauranteId;

    #[ORM\Column(type: "string", length: 30, options: ["default" => "propietario"])]
    private string $rol = "propietario";

    /**
     * Constructor
     */
    public function __construct(int $usuarioId = 0, int $restauranteId = 0, string $rol = "propietario")
    {
        $this->usuarioId = $usuarioId;
        $this->restauranteId = $restauranteId;
        $this->rol = $rol;
    }

    /**
     * Get usuario ID
     */
    public function getUsuarioId(): int
    {
        return $this->usuarioId;
    }

    /**
     * Set usuario ID
     */
    public function setUsuarioId(int $usuarioId): self
    {
        $this->usuarioId = $usuarioId;
        return $this;
    }

    /**
     * Get restaurante ID
     */
    public function getRestauranteId(): int
    {
        return $this->restauranteId;
    }

    /**
     * Set restaurante ID
     */
    public function setRestauranteId(int $restauranteId): self
    {
        $this->restauranteId = $restauranteId;
        return $this;
    }

    /**
     * Get rol
     */
    public function getRol(): string
    {
        return $this->rol;
    }

    /**
     * Set rol
     */
    public function setRol(string $rol): self
    {
        $this->rol = $rol;
        return $this;
    }
}
