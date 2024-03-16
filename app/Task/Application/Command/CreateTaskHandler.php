<?php

namespace app\Task\Application\Command;

use app\System\Application\CQRS\Command\CommandHandler;
use app\Task\Domain\Repository\TaskRepository;
use Symfony\Component\Messenger\Attribute\AsMessageHandler;

#[AsMessageHandler]
final class CreateTaskHandler extends CommandHandler
{
	public function __construct(private readonly TaskRepository $repository)
	{
	}

	public function __invoke(CreateTask $command): void
	{
		$this->repository->create($command->taskDTO);
	}
}