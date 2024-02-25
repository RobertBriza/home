<?php

declare(strict_types=1);

namespace app\System\Application\Mapping\Map;

use app\System\Domain\Entity\Entity;
use DateTimeImmutable;

class DatetimeImmutableMap implements TypeMap
{
	public function isValid(array $data): bool
	{
		return $data['value'] instanceof DateTimeImmutable;
	}

	public function map(Entity $entity, string $property, array $data): void
	{
		$method = 'set' . ucfirst($property);

		if (method_exists($entity, $method)) {
			$entity->$method($data['value']);
		}
	}
}
