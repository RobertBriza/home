<?php

declare(strict_types=1);

namespace app\Day\Domain\DTO;

final readonly class DayInfoDTO
{
	/** @param array{nominative: string, genitive: string} $month */
	public function __construct(
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
}