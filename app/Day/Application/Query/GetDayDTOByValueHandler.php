<?php

namespace app\Day\Application\Query;

use app\Day\Domain\DTO\DayDTO;
use app\System\Application\CQRS\Query\QueryHandler;
use Symfony\Component\Messenger\Attribute\AsMessageHandler;

#[AsMessageHandler]
final class GetDayDTOByValueHandler extends QueryHandler
{
	public function __construct()
	{
	}

	public function __invoke(GetDayDTOByValue $query): ?DayDTO
	{
		return $this->map($query);
	}
}