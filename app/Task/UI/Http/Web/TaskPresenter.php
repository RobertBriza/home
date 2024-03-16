<?php

namespace app\Task\UI\Http\Web;

use app\System\UI\Http\Web\BasePresenter;
use app\Task\Application\Command\DeleteTask;
use app\Task\Application\Command\ReorderTasks;
use app\Task\Application\Query\FindTasks;
use app\Task\UI\Http\Web\Form\CreateTaskFormFactory;
use Nette\Application\Responses\JsonResponse;
use Nette\ComponentModel\IComponent;
use Ramsey\Uuid\Rfc4122\UuidV4;

final class TaskPresenter extends BasePresenter
{
	public function __construct(private CreateTaskFormFactory $formFactory)
	{
	}

	public function actionReorder(): void
	{
		$ids = array_map(static fn (array $data) => UuidV4::fromString($data['id']), $this->getPost());
		$this->sendCommand(new ReorderTasks($ids));

		$this->sendResponse(new JsonResponse(['response' => 'OK']));
	}

	public function createComponentCreateTaskForm(): ?IComponent
	{
		return $this->formFactory->create();
	}

	public function handleSoftDelete(): void
	{
		$this->sendCommand(new DeleteTask(UuidV4::fromString((string) $this->getPost())));
	}

	public function renderDefault(): void
	{
		$this->template->tasks = $this->sendQuery(new FindTasks());
	}
}