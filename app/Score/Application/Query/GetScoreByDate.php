<?php

namespace app\Score\Application\Query;

use app\System\Application\CQRS\Query\GetByQuery;
use DateTimeImmutable;

final class GetScoreByDate extends GetByQuery
{
	public function __construct(public DateTimeImmutable $createdAt)
	{
	}
}