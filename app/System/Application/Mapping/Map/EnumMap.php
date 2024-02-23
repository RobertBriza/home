<?php

declare(strict_types=1);

namespace App\System\Application\Mapping\Map;

use App\System\Domain\Entity\Entity;
use ReflectionObject;

class EnumMap implements TypeMap
{
	public function isValid(array $data): bool
	{
		return is_object($data['value']) && $this->isEnum($data['value']);
	}

	public function map(Entity $entity, string $property, array $data): void
	{
		$method = 'set' . ucfirst($property);

		if (method_exists($entity, $method)) {
			$entity->$method($data['value']);
		}
	}

	private function isEnum(object $value): bool
	{
		return (new ReflectionObject($value))->isEnum();
	}
}
