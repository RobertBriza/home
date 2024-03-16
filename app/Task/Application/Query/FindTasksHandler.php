<?php

namespace app\Task\Application\Query;

use app\System\Application\CQRS\Query\QueryHandler;
use app\Task\Domain\Entity\Task;
use app\Task\Domain\Repository\TaskRepository;
use Symfony\Component\Messenger\Attribute\AsMessageHandler;

#[AsMessageHandler]
class FindTasksHandler extends QueryHandler
{
	public function __construct(private TaskRepository $repository)
	{
	}

	/** @return Task[] */
	public function __invoke(FindTasks $query): array
	{
		return $this->repository->createQueryBuilder('t')
			->select('t')
			->where('t.deletedAt IS NULL')
			->orderBy("FIELD(t.priority, 'low', 'medium', 'high') ", 'DESC')
			->addOrderBy('t.taskOrder', 'ASC')
			->getQuery()
			->getResult();
	}
}