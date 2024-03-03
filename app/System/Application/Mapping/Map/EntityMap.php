<?php

declare(strict_types=1);

namespace app\System\Application\Mapping\Map;

use app\System\Domain\Entity\Entity;

final class EntityMap implements TypeMap
{
	public function isValid(mixed $value): bool
	{
		return $value instanceof Entity;
	}

	public function map(Entity $entity, string $property, mixed $value): void
	{
		if (property_exists($entity, $property)) {
			$entity->{$property} = $value;
		}
	}
}
