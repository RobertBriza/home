<?php

declare(strict_types=1);

namespace app\Day\Application\Helper;

use DateInterval;
use DateTimeImmutable;

final class DayHelper
{
	/** @return DateTimeImmutable[] */
	public static function getWeekRange(?DateTimeImmutable $date = null): array
	{
		if ($date === null) {
			return [];
		}

		if ($date->format('N') !== "1") {
			$date = $date->modify('last monday');
		}

		$weekDates = [];
		for ($i = 0; $i < 7; $i++) {
			$weekDates[] = $date->add(new DateInterval('P' . $i . 'D'));
		}

		return $weekDates;
	}
}