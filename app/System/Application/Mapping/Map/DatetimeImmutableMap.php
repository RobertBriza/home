<?php

declare(strict_types=1);

namespace app\System\Application\Mapping\Map;

use app\System\Domain\Entity\Entity;
use DateTimeImmutable;

final class DatetimeImmutableMap implements TypeMap
{
	public function isValid(mixed $value): bool
	{
		return $value instanceof DateTimeImmutable;
	}

	public function map(Entity $entity, string $property, mixed $value): void
	{
		$method = 'set' . ucfirst($property);

		if (method_exists($entity, $method)) {
			$entity->$method($value);

			return;
		}

		if (property_exists($entity, $property)) {
			$entity->$property = $value;
		}
	}
}
