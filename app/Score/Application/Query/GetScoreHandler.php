<?php

namespace app\Score\Application\Query;

use app\Score\Domain\Entity\Score;
use app\System\Application\CQRS\Query\QueryHandler;
use Symfony\Component\Messenger\Attribute\AsMessageHandler;

#[AsMessageHandler]
final class GetScoreHandler extends QueryHandler
{
	public function __construct()
	{
	}

	public function __invoke(GetScore $query): ?Score
	{
		//TODO:
		return $this->map($query)[0];
	}
}