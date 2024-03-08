<?php

declare(strict_types=1);

namespace app\Score\UI\Http\Web;

use app\Day\Application\Query\FindDaysForRange;
use app\Day\Application\Query\GetDayDTOByValue;
use app\Day\Domain\Enum\DateRange;
use app\Score\Application\Query\GetScoreByDate;
use app\Score\Domain\Entity\Score;
use app\Score\UI\Http\Web\Control\DailyScoreControlFactory;
use app\Score\UI\Http\Web\Control\DailyScoreToggleControlFactory;
use app\System\UI\Http\Web\BasePresenter;
use DateInterval;
use DateTimeImmutable;
use Nette\ComponentModel\IComponent;

class ScorePresenter extends BasePresenter
{
	public DateTimeImmutable $date;
	public string $type;
	protected ?Score $score;

	public function __construct(
		private DailyScoreControlFactory $dailyScoreControlFactory,
		private DailyScoreToggleControlFactory $dailyScoreToggleControlFactory,
	) {
	}

	public function actionDefault(?string $id = null): void
	{
		$this->date = $id !== null ? new DateTimeImmutable($id) : new DateTimeImmutable();
		$this->score = $this->sendQuery(new GetScoreByDate($this->date));
		$this->template->dateRange = DateRange::Day;
		$this->template->dayDTO = $this->sendQuery(new GetDayDTOByValue($this->date));
		$this->template->range = $this->sendQuery(new FindDaysForRange($this->date, 'week'));
		$this->template->week = new DateInterval('P7D');
	}

	public function actionListWeek(?string $id = null): void
	{
		$this->date = $id !== null ? new DateTimeImmutable($id) : new DateTimeImmutable();
		$this->template->dateRange = DateRange::Week;
		$this->template->dayDTO = $this->sendQuery(new GetDayDTOByValue($this->date));
		$range = $this->sendQuery(new FindDaysForRange($this->date, 'week'));

		$dateScores = [];
		foreach ($range as $dayDTO) {
			$score = $this->sendQuery(new GetScoreByDate($dayDTO->value));
			if ($score === null) {
				continue;
			}

			$dateScores[] = ["score" => $score, "dayDTO" => $dayDTO];
		}

		$this->template->dateScores = $dateScores;
		$this->template->week = new DateInterval('P7D');

	}

	protected function createComponentDailyScore(): IComponent
	{
		return $this->dailyScoreControlFactory->create();
	}

	protected function createComponentDailyScoreToggle(): IComponent
	{
		return $this->dailyScoreToggleControlFactory->create($this->date, $this->score);
	}
}