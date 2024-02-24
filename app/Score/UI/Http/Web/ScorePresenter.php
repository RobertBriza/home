<?php

declare(strict_types=1);

namespace app\Score\UI\Http\Web;

use app\Score\UI\Http\Web\Control\DailyScoreControlFactory;
use app\System\UI\Http\Web\BasePresenter;
use Nette\Application\UI\Form;
use Nette\ComponentModel\IComponent;
use Nette\Utils\ArrayHash;

class ScorePresenter extends BasePresenter
{
	public function __construct(private DailyScoreControlFactory $controlFactory)
	{
	}

	public function beforeRender(): void
	{
		parent::beforeRender();
	}

	public function formSucceeded(Form $form, ArrayHash $values): void
	{
		$this->flashMessage('Skóre uloženo.');
		$this->redirect('this');
	}

	protected function createComponentDailyScore(): IComponent
	{
		return $this->controlFactory->create();
	}
}