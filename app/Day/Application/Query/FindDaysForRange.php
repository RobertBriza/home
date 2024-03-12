<?php

declare(strict_types=1);

namespace app\Day\Application\Query;

use app\Day\Domain\Enum\DateRange;
use DateTimeImmutable;

final readonly class FindDaysForRange
{
	public function __construct(public DateTimeImmutable $date, public DateRange $range)
	{
	}
}