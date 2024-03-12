<?php

declare(strict_types=1);

namespace app\Day\Application\Helper;

use DateInterval;
use DateTimeImmutable;

final class DayHelper
{
	/** @return DateTimeImmutable[] */
	public static function getMonthRange(?DateTimeImmutable $date = null): array
	{
		$firstDayOfMonth = $date->modify('first day of this month midnight');
		$lastDayOfMonth = $date->modify('last day of this month midnight');

		if ($firstDayOfMonth->format('w') !== '0') {
			$firstDayOfMonth = $firstDayOfMonth->modify('last sunday');
		}

		if ($lastDayOfMonth->format('w') !== '6') {
			$lastDayOfMonth = $lastDayOfMonth->modify('last saturday');
		}

		$dayOfWeek = $date->format('w');

		$weeks = [];

		for (
			$currentDate = $firstDayOfMonth;
			$currentDate <= $lastDayOfMonth;
			$currentDate = $currentDate->modify('+1 week')
		) {
			$weeks[] = [
				'start' => $currentDate,
				'weekDay' => $currentDate->modify(sprintf("+%s days", $dayOfWeek)),
				'end' => $currentDate->modify('+6 days'),
			];
		}

		return $weeks;
	}

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