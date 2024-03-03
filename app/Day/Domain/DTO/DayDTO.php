<?php

declare(strict_types=1);

namespace app\Day\Domain\DTO;

use app\Day\Domain\Entity\Day;
use DateTimeImmutable;

final readonly class DayDTO
{
	private function __construct(
		public DateTimeImmutable $value,
		public DayInfoDTO $dayInfo,
	) {
	}

	/** @param array{
	 *    date: DateTimeImmutable,
	 *    dayNumber: string,
	 *    dayInWeek: string,
	 *    monthNumber: string,
	 *    month: array,
	 *    year: string,
	 *    name: string,
	 *    isHoliday: bool,
	 *    holidayName: string
	 * } $data
	 */
	public static function fromArray(array $data): self
	{
		return new self(
			new DateTimeImmutable($data['date']),
			DayInfoDTO::fromArray($data),
		);
	}

	public static function fromEntity(Day $day): self
	{
		return new self(
			$day->getValue(),
			DayInfoDTO::fromEntity($day->getDayInfo()),
		);
	}

	/** @return DateTimeImmutable[] */
	public function last7Days(): array
	{
		$last7Days = [];
		$day = $this->value;
		for ($i = 0; $i < 7; $i++) {
			$day = $day->modify('-1 day');
			array_unshift($last7Days, $day);
		}

		return $last7Days;
	}
}