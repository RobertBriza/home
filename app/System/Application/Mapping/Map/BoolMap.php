<?php

declare(strict_types=1);

namespace app\System\Application\Mapping\Map;

use app\System\Domain\Entity\Entity;

class BoolMap implements TypeMap
{
	public function isValid(array $data): bool
	{
		return is_bool($data['value']);
	}

	public function map(Entity $entity, string $property, array $data): void
	{
		foreach (['is', 'has', 'can'] as $prefix) {
			$method = $prefix . ucfirst($property);

			if (method_exists($entity, $method)) {
				$entity->$method($data['value']);
			}
		}
	}
}
