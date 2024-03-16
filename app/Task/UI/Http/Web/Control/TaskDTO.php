<?php

namespace app\Task\UI\Http\Web\Form;

use app\Task\Domain\Enum\TaskPriority;
use DateTimeImmutable;
use Nette\Application\UI\Form;

final readonly class TaskDTO
{
	private function __construct(
		public string $title,
		public string $description,
		public DateTimeImmutable $dueDatetime,
		public int $order,
		public TaskPriority $priority,
	) {
	}

	public static function createFromForm(Form $form): self
	{
		$values = $form->getValues();

		return new self(
			$values->title,
			$values->description,
			new DateTimeImmutable($values->dueDatetime),
			$values->order,
			TaskPriority::from($values->priority),
		);
	}
}