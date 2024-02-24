<?php

declare(strict_types=1);

namespace app\Score\Application\Mapper;

use app\Score\Domain\Repository\ScoreRepository;
use app\System\Application\Mapping\Mapper;

final class ScoreMapper extends Mapper
{
	public function __construct(ScoreRepository $repository)
	{
		parent::__construct($repository);
	}
}