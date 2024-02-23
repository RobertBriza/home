<?php

declare(strict_types=1);

namespace App\System\Application\Mapping\Map;

use App\System\Domain\Entity\Entity;

class IntMap implements TypeMap
{
	public function isValid(array $data): bool
	{
		return is_int($data['value']);
	}

	public function map(Entity $entity, string $property, array $data): void
	{
		$method = 'set' . ucfirst($property);

		if (method_exists($entity, $method)) {
			$entity->$method($data['value']);
		}
	}
}
