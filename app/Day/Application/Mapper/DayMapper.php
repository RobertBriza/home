<?php

declare(strict_types=1);

namespace app\Day\Application\Mapper;

use app\Day\Domain\Repository\DayRepository;
use app\System\Application\Mapping\Mapper;

final class DayMapper extends Mapper
{
	public function __construct(DayRepository $repository)
	{
		parent::__construct($repository);
	}
}