<?php

namespace app\Day\Application\Command;

use app\Day\Domain\DTO\DayDTO;
use app\System\Application\CQRS\Command\CreateCommand;

class CreateDay extends CreateCommand
{
	public function __construct(public DayDTO $dto)
	{
	}
}