<?php
namespace Comida\Domicilio\Utils;

use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Proxy\Proxy;
use DateTimeInterface;
use ReflectionClass;

class BaseEntityUtils {
    public static function toArray(object $entity, array $excluir = []): array {
        $data = [];

        $reflection = new ReflectionClass($entity);

        foreach ($reflection->getProperties() as $property) {
            $name = $property->getName();

            if (in_array($name, $excluir)) continue;

            $getter = 'get' . ucfirst($name);
            $isser = 'is' . ucfirst($name);

            if ($reflection->hasMethod($getter)) {
                $value = $entity->$getter();
            } elseif ($reflection->hasMethod($isser)) {
                $value = $entity->$isser();
            } else {
                continue;
            }

            // Procesar valor
            if ($value instanceof DateTimeInterface) {
                $value = $value->format('Y-m-d H:i:s');
            } elseif ($value instanceof Collection) {
                $value = $value->map(fn($item) => self::toArray($item));
            } elseif (is_object($value) && method_exists($value, 'getId')) {
                // Si es entidad relacionada, mostrar solo su ID
                $value = $value->getId();
            }

            $data[$name] = $value;
        }

        return $data;
    }
}
