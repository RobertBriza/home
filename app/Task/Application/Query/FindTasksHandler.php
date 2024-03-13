<?php

namespace app\Task\Application\Query;

use app\System\Application\CQRS\Query\QueryHandler;
use app\Task\Domain\Repository\TaskRepository;
use Symfony\Component\Messenger\Attribute\AsMessageHandler;

#[AsMessageHandler]
class FindTasksHandler extends QueryHandler
{
	public function __construct(private TaskRepository $repository)
	{
	}

	public function __invoke(FindTasks $query): array
	{
		return $this->repository->findAll();
	}
}