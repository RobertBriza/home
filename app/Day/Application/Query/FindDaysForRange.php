<?php

declare(strict_types=1);

namespace app\Day\Application\Query;

use DateTimeImmutable;

final readonly class FindDaysForRange
{
	public function __construct(public DateTimeImmutable $date, public string $range)
	{
	}
}