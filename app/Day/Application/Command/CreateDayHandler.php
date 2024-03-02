<?php

namespace app\Day\Application\Command;

use app\System\Application\CQRS\Command\CommandHandler;
use Symfony\Component\Messenger\Attribute\AsMessageHandler;

#[AsMessageHandler]
final class CreateDayHandler extends CommandHandler
{
	public function __construct()
	{
	}

	public function __invoke(CreateDay $command): void
	{
		$this->persistAndFlush($command);
	}
}