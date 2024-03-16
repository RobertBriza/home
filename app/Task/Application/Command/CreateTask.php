<?php

namespace app\Task\Application\Command;

use app\Task\UI\Http\Web\Form\TaskDTO;

final readonly class CreateTask
{
	public function __construct(public TaskDTO $taskDTO)
	{
	}
}