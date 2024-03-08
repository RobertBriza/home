<?php

declare(strict_types=1);

namespace app\Day\Application\Query;

use app\Day\Domain\Repository\DayRepository;
use app\System\Application\Wiring\Autowired;
use Symfony\Component\Messenger\Attribute\AsMessageHandler;

#[AsMessageHandler]
final readonly class FindDaysForRangeHandler implements Autowired
{
	public function __construct(public DayRepository $dayRepository)
	{
	}

	public function __invoke(FindDaysForRange $query): array
	{

		return $this->dayRepository->findDaysForRange($query->date);
	}
}