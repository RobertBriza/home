<?php

declare(strict_types=1);

namespace app\Score\Application\Command;

use app\System\Application\CQRS\Command\CommandHandler;
use Symfony\Component\Messenger\Attribute\AsMessageHandler;

#[AsMessageHandler]
final class DeleteScoreHandler extends CommandHandler
{
	public function __invoke(DeleteScore $command): void
	{
		$this->em->remove($this->map($command));
		$this->em->flush();
	}
}
