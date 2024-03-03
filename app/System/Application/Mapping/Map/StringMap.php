<?php

declare(strict_types=1);

namespace app\System\Application\Mapping\Map;

use app\System\Domain\Entity\Entity;

final class StringMap implements TypeMap
{
	public function isValid(mixed $value): bool
	{
		return is_string($value);
	}

	public function map(Entity $entity, string $property, $value): void
	{
		$method = 'set' . ucfirst($property);

		if (method_exists($entity, $method)) {
			$entity->$method($value);
		}
	}
}
