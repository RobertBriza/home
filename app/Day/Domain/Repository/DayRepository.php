<?php

declare(strict_types=1);

namespace app\Day\Domain\Repository;

use app\Day\Application\Helper\DayHelper;
use app\Day\Domain\DTO\DayDTO;
use app\Day\Domain\DTO\DayInfoDTO;
use app\Day\Domain\Entity\Day;
use app\System\Domain\Repository\BaseRepository;
use DateTimeImmutable;

/**
 * @extends BaseRepository<Day>
 */
final class DayRepository extends BaseRepository
{
	/** @return DayDTO[] */
	public function findDaysForRange(DateTimeImmutable $date): array
	{
		$range = DayHelper::getWeekRange($date);
		$query = $this->createQueryBuilder('d')
			->where('d.value >= :start')
			->andWhere('d.value <= :end')
			->setParameter('start', reset($range))
			->setParameter('end', end($range))
			->getQuery();

		$result = [];
		/** @var Day $day */
		foreach ($query->getResult() as $day) {
			$dayInfoDTO = new DayInfoDTO(
				$day->getDayInfo()->getDayNumber(),
				$day->getDayInfo()->getDayInWeek(),
				$day->getDayInfo()->getMonthNumber(),
				$day->getDayInfo()->getMonth(),
				$day->getDayInfo()->getYear(),
				$day->getDayInfo()->getName(),
				$day->getDayInfo()->isHoliday(),
				$day->getDayInfo()->getHolidayName(),
			);

			$result[$day->getValue()->format('Y-m-d')] = new DayDTO($day->getValue(), $dayInfoDTO);
		}

		return $result;
	}
}
