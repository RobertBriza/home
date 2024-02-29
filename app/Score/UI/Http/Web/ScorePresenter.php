<?php

declare(strict_types=1);

namespace app\Score\UI\Http\Web;

use app\Score\Application\Query\GetScore;
use app\Score\Domain\Entity\Score;
use app\Score\UI\Http\Web\Control\DailyScoreControlFactory;
use app\System\UI\Http\Web\BasePresenter;
use Nette\ComponentModel\IComponent;

class ScorePresenter extends BasePresenter
{
	public Score $score;

	public function __construct(private DailyScoreControlFactory $controlFactory)
	{
	}

	public function render(): void
	{
		$this->score = $this->sendQuery(new GetScore());
		$this->template->score = $this->score;
	}

	protected function createComponentDailyScore(): IComponent
	{
		$this->flashMessage("yes");

		return $this->controlFactory->create();
	}
}