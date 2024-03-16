<?php

declare(strict_types=1);

namespace app\Task\Application\Command;

use app\System\Application\Wiring\Autowired;
use app\Task\Domain\Repository\TaskRepository;
use Symfony\Component\Messenger\Attribute\AsMessageHandler;

#[AsMessageHandler]
final class DeleteTaskHandler implements Autowired
{
	public function __construct(
		private TaskRepository $repository,
	) {
	}

	public function __invoke(DeleteTask $command): void
	{
		$entity = $this->repository->find($command->id);

		$command->hard
			? $this->repository->entityManager()->remove($entity)
			: $entity->setDeletedAt(new \DateTimeImmutable());

		$this->repository->entityManager()->flush();
	}
}