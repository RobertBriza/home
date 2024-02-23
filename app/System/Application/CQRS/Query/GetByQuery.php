<?php

declare(strict_types=1);

namespace App\System\Application\CQRS\Query;

abstract class GetByQuery extends Query
{
	/** @inheritDoc */
	public function findCriteria(): array
	{
		return get_object_vars($this);
	}
}
