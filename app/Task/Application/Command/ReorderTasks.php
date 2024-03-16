<?php

declare(strict_types=1);

namespace app\Task\Application\Command;

use Ramsey\Uuid\UuidInterface;

final readonly class ReorderTasks
{
	/** @param UuidInterface[] $ids */
	public function __construct(public array $ids)
	{
	}
}