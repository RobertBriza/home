<?php

declare(strict_types=1);

namespace app\Day\Domain\DTO;

use DateTimeImmutable;

final readonly class DayDTO
{
	public function __construct(
		public DateTimeImmutable $value,
		public ?DayInfoDTO $dayInfo,
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
}