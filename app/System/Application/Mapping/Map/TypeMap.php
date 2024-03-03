<?php

declare(strict_types=1);

namespace app\System\Application\Mapping\Map;

use app\System\Application\Wiring\Autowired;
use app\System\Domain\Entity\Entity;

interface TypeMap extends Autowired
{
	public function isValid(mixed $value): bool;

	public function map(Entity $entity, string $property, mixed $value): void;
}
