<?php

declare(strict_types=1);

namespace app\Score\Application\Command;

use app\System\Application\CQRS\Command\CommandHandler;
use Symfony\Component\Messenger\Attribute\AsMessageHandler;

#[AsMessageHandler]
final class CreateScoreHandler extends CommandHandler
{
	public function __invoke(CreateScore $command): void
	{
		$this->persistAndFlush($command);
	}
}
