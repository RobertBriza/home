<?php

declare(strict_types=1);

namespace app\System\Application\Mapping\Map;

use app\System\Domain\Entity\Entity;

class EntityMap implements TypeMap
{
	public function isValid(array $data): bool
	{
		return $data['value'] instanceof Entity;
	}

	public function map(Entity $entity, string $property, array $data): void
	{
		if (property_exists($entity, $property)) {
			$entity->{$property} = $data['value'];
		}
	}
}
