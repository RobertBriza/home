<?php

declare(strict_types=1);

namespace app\Day\Domain\Enum;

use DateInterval;

enum DateRange: string
{
	case Day = 'day';
	case Week = 'week';
	case Month = 'month';
	case Year = 'year';

	public function interval(): DateInterval
	{
		return match ($this) {
			self::Day => new DateInterval('P1D'),
			self::Week => new DateInterval('P7D'),
			self::Month => new DateInterval('P1M'),
			self::Year => new DateInterval('P1Y'),
		};
	}
}
