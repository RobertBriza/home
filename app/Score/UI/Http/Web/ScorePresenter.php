<?php

declare(strict_types=1);

namespace app\Score\UI\Http\Web;

use app\Day\Application\Query\GetDayDTOByValue;
use app\Score\Application\Query\GetScoreByDate;
use app\Score\UI\Http\Web\Control\DailyScoreControlFactory;
use app\System\UI\Http\Web\BasePresenter;
use DateInterval;
use DateTimeImmutable;
use Nette\ComponentModel\IComponent;

class ScorePresenter extends BasePresenter
{
	public DateTimeImmutable $date;

	public function __construct(private DailyScoreControlFactory $controlFactory)
	{
	}

	public function actionDefault(?string $id = null): void
	{
		$this->date = $id !== null ? new DateTimeImmutable($id) : new DateTimeImmutable();
		$this->template->dayDTO = $this->sendQuery(new GetDayDTOByValue($this->date));
		$this->template->score = $this->sendQuery(new GetScoreByDate($this->date));
		$this->template->week = new DateInterval('P7D');
	}

	protected function createComponentDailyScore(): IComponent
	{
		return $this->controlFactory->create();
	}
}