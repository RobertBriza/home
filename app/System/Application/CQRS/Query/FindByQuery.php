<?php

declare(strict_types=1);

namespace app\System\Application\CQRS\Query;

abstract class FindByQuery extends Query
{
	/** @inheritDoc */
	public function findCriteria(): array
	{
		return get_object_vars($this);
	}
}
