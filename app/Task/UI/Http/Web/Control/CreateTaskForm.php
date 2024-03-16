<?php

namespace app\Task\UI\Http\Web\Form;

use app\System\UI\Http\Web\Control\BaseControl;
use app\Task\Application\Command\CreateTask;
use app\Task\Domain\Enum\TaskPriority;
use Nette\Application\UI\Form;
use Nette\ComponentModel\IComponent;

final class CreateTaskForm extends BaseControl
{
	public function formSucceeded(Form $form): void
	{
		$this->sendCommand(new CreateTask(TaskDTO::createFromForm($form)));
		$this->presenter->redirect(':Task:Task:default');
	}

	protected function createComponentCreateTaskForm(): IComponent
	{
		$form = new Form;
		$form->addText('title');
		$form->addText('description');
		$form->addText('dueDatetime');
		$form->addInteger('order')->setDefaultValue(1);
		$form->addSelect('priority', 'Priorita', TaskPriority::valuesForSelect())
			->setDefaultValue(TaskPriority::MEDIUM->value);
		$form->addSubmit('send', 'Uložit');
		$form->onSuccess[] = [$this, 'formSucceeded'];

		return $form;
	}
}