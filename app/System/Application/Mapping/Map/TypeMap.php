<?php

declare(strict_types=1);

namespace app\System\Application\Mapping\Map;

use app\System\Application\Wiring\Autowired;
use app\System\Domain\Entity\Entity;

interface TypeMap extends Autowired
{
	/** @param array{value: mixed, type: string} $data */
	public function isValid(array $data): bool;

	/** @param array{value: mixed, type: string} $data */
	public function map(Entity $entity, string $property, array $data): void;
}
