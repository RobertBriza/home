<?php

declare(strict_types=1);

namespace app\Task\Application\Command;

use app\System\Application\Wiring\Autowired;
use app\Task\Domain\Repository\TaskRepository;
use Symfony\Component\Messenger\Attribute\AsMessageHandler;

#[AsMessageHandler]
final class ReorderTasksHandler implements Autowired
{
	public function __construct(public TaskRepository $repository)
	{
	}

	public function __invoke(ReorderTasks $command): void
	{
		$tasks = $this->repository->findBy(['id' => $command->ids]);

		foreach ($tasks as $order => $task) {
			$task->setTaskOrder();
		}

		$this->repository->entityManager()->flush();
	}
}