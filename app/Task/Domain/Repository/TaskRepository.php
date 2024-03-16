<?php

namespace app\Task\Domain\Repository;

use app\System\Domain\Repository\BaseRepository;
use app\Task\Domain\Entity\Task;
use app\Task\UI\Http\Web\Form\TaskDTO;

/**
 * @extends BaseRepository<Task>
 */
class TaskRepository extends BaseRepository
{
	public function create(TaskDTO $dto): void
	{
		$task = new Task();
		$task->setTitle($dto->title);
		$task->setDescription($dto->description);
		$task->setDueDatetime($dto->dueDatetime);
		$task->setTaskOrder($dto->order);
		$task->setPriority($dto->priority);
		$task->setUpdatedAt(new \DateTimeImmutable());
		$this->entityManager()->persist($task);
		$this->entityManager()->flush();
	}
}
