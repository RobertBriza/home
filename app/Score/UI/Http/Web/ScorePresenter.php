<?php

declare(strict_types=1);

namespace app\Score\UI\Http\Web;

use app\Score\Application\Query\GetScoreByDate;
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
		$this->score = $this->sendQuery(new GetScoreByDate($this->date));
		$this->template->score = $this->score;
	}

	protected function createComponentDailyScore(): IComponent
	{
		return $this->controlFactory->create();
	}
}