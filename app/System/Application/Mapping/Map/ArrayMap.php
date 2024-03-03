<?php

namespace app\System\Application\Mapping\Map;

use app\System\Domain\Entity\Entity;

final class ArrayMap implements TypeMap
{
	#[\Override] public function isValid(mixed $value): bool
	{
		return is_array($value);
	}

	#[\Override] public function map(Entity $entity, string $property, mixed $value): void
	{
		$method = 'set' . ucfirst($property);

		if (method_exists($entity, $method)) {
			$entity->$method($value);
		}
	}
}