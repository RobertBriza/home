<?php

namespace app\Day\Domain;

use DateTimeImmutable;

final readonly class DayInfoDTO
{
	/** @param array{nominative: string, genitive: string} $month */
	private function __construct(
		public DateTimeImmutable $date,
		public string $dayNumber,
		public string $dayInWeek,
		public string $monthNumber,
		public array $month,
		public string $year,
		public string $name,
		public bool $isHoliday,
		public ?string $holidayName,
	) {
	}

	/** @param array{
	 *   date: string,
	 *   dayNumber: string,
	 *   dayInWeek: string,
	 *   monthNumber: string,
	 *   month: array,
	 *   year: string,
	 *   name: string,
	 *   isHoliday: bool,
	 *   holidayName: string
	 * } $data
	 */
	public static function fromArray(array $data): self
	{
		return new DayInfoDTO(
			new DateTimeImmutable($data['date']),
			$data['dayNumber'],
			$data['dayInWeek'],
			$data['monthNumber'],
			$data['month'],
			$data['year'],
			$data['name'],
			$data['isHoliday'],
			$data['holidayName'],
		);
	}

	/** @return DateTimeImmutable[] */
	public function last7Days(): array
	{
		$last7Days = [];
		$day = $this->date;
		for ($i = 0; $i < 7; $i++) {
			$day = $day->modify('-1 day');
			array_unshift($last7Days, $day);
		}

		return $last7Days;
	}
}