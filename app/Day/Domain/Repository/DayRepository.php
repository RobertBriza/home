<?php

declare(strict_types=1);

namespace app\Day\Domain\Repository;

use app\Day\Application\Helper\DayHelper;
use app\Day\Domain\DTO\DayDTO;
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
			$result[$day->getValue()->format('Y-m-d')] = new DayDTO($day->getValue(), null);
		}

		return $result;
	}
}
