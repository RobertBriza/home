<?php

declare(strict_types=1);

namespace app\System\Application\Mapping\Map;

use app\System\Domain\Entity\Entity;

final class BoolMap implements TypeMap
{
	public function isValid(mixed $value): bool
	{
		return is_bool($value);
	}

	public function map(Entity $entity, string $property, mixed $value): void
	{
		$method = 'set' . ucfirst($property);

		if (method_exists($entity, $method)) {
			$entity->$method($value);
		}
	}
}
