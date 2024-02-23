<?php

declare(strict_types=1);

namespace app\System\Application\CQRS\Query;

abstract class FindQuery extends Query
{
	/** @param array<int> $ids */
	public function __construct(public array $ids)
	{
	}

	/** @return array<string, array<int>> */
	public function findCriteria(): array
	{
		return [
			"id" => $this->ids,
		];
	}
}
