<?php

namespace app\Day\Application\Query;

use app\System\Application\CQRS\Query\GetByQuery;
use DateTimeImmutable;

class GetDayDTOByValue extends GetByQuery
{
	public function __construct(public DateTimeImmutable $value)
	{

	}
}