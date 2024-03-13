<?php

namespace app\Task\UI\Http\Web;

use app\System\UI\Http\Web\BasePresenter;
use app\Task\Application\Query\FindTasks;
use Nette\Application\Responses\JsonResponse;

class TaskPresenter extends BasePresenter
{
	public function actionReorder(): void
	{
		if (json_validate($this->getHttpRequest()->getRawBody()) === false) {
			$this->sendResponse(new JsonResponse(['response' => 'Invalid JSON']));
		}

		$data = json_decode($this->getHttpRequest()->getRawBody(), true);
		bdump($data);
		$this->sendResponse(new JsonResponse(['response' => 'OK']));
	}

	public function renderDefault(): void
	{
		$this->template->tasks = $this->sendQuery(new FindTasks());
	}
}