<?php

declare(strict_types=1);

namespace App\System\Application\CQRS\Query;

abstract class Query
{
	/** @return array<string, mixed> */
	abstract public function findCriteria(): array;
}
