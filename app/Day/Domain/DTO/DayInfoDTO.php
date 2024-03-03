<?php

declare(strict_types=1);

namespace app\Day\Domain\DTO;

use app\Day\Domain\Entity\DayInfo;

final readonly class DayInfoDTO
{
	/** @param array{nominative: string, genitive: string} $month */
	private function __construct(
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

	public static function fromEntity(DayInfo $dayInfo): self
	{
		return new DayInfoDTO(
			$dayInfo->getDayNumber(),
			$dayInfo->getDayInWeek(),
			$dayInfo->getMonthNumber(),
			$dayInfo->getMonth(),
			$dayInfo->getYear(),
			$dayInfo->getName(),
			$dayInfo->isHoliday(),
			$dayInfo->getHolidayName(),
		);
	}

	public function toArray(): array
	{
		return [
			'dayNumber' => $this->dayNumber,
			'dayInWeek' => $this->dayInWeek,
			'monthNumber' => $this->monthNumber,
			'month' => $this->month,
			'year' => $this->year,
			'name' => $this->name,
			'isHoliday' => $this->isHoliday,
			'holidayName' => $this->holidayName,
		];
	}
}