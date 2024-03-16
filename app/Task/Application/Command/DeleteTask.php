<?php

declare(strict_types=1);

namespace app\Task\Application\Command;

use Ramsey\Uuid\UuidInterface;

final readonly class DeleteTask
{
	public function __construct(
		public UuidInterface $id,
		public bool $hard = false,
	) {
	}
}