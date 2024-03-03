<?php

declare(strict_types=1);

namespace app\System\Application\Mapping\Map;

use app\System\Domain\Entity\Entity;
use ReflectionObject;

final class EnumMap implements TypeMap
{
	public function isValid(mixed $value): bool
	{
		return is_object($value) && $this->isEnum($value);
	}

	public function map(Entity $entity, string $property, mixed $value): void
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
