<?php

namespace app\Day\Application\Query;

use app\Day\Domain\DTO\DayDTO;
use app\Day\Domain\Entity\Day;
use app\System\Application\CQRS\Query\QueryHandler;
use Nette\Caching\Cache;
use Symfony\Component\Messenger\Attribute\AsMessageHandler;

#[AsMessageHandler]
final class GetDayDTOByValueHandler extends QueryHandler
{
	public function __construct(
		private Cache $cache,
	) {
	}

	public function __invoke(GetDayDTOByValue $query): ?DayDTO
	{
		return $this->cache->load(
			'dayInfo' . $query->value->format('Y-m-d'),
			function (&$dependencies) use ($query) {
				$dependencies[Cache::Expire] = '30 days';

				/** @var Day $day */
				$day = $this->map($query);

				if ($day === null) {
					return null;
				}

				return DayDTO::fromEntity($day);
			},
		);
	}
}