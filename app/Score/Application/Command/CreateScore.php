<?php

declare(strict_types=1);

namespace app\Score\Application\Command;

use app\System\Application\CQRS\Command\CreateCommand;
use DateTimeImmutable;

final class CreateScore extends CreateCommand
{
	public function __construct(public int $score1, public $score2, DateTimeImmutable $createdAt)
	{
	}
}