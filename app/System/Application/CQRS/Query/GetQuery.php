<?php

declare(strict_types=1);

namespace App\System\Application\CQRS\Query;

abstract class GetQuery extends Query
{
	public int $id;

	/** @return array<string, int> */
	public function findCriteria(): array
	{
		return [
			"id" => $this->id,
		];
	}
}
