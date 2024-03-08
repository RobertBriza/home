<?php

namespace app\Score\UI\Http\Web\Control;

use app\Score\Application\Query\GetScoreByDate;
use app\Score\UI\Http\Web\ScorePresenter;
use app\System\UI\Http\Web\Control\BaseControl;
use DateTimeImmutable;
use Exception;
use Nette\ComponentModel\IComponent;

/** @property ScorePresenter $presenter */
class DailyScoreToggleControl extends BaseControl
{
	public function __construct(
		private DateTimeImmutable $date,
		private DailyScoreControlFormFactory $dailyScoreControlFormFactory,
		private DailyScoreControlFactory $dailyScoreControlFactory,
	) {

	}

	public function render(mixed ...$args): void
	{
		try {
			$this->template->score = $this->sendQuery(new GetScoreByDate($this->date));
		} catch (Exception $e) {
			bdump($e);
			$this->flashMessage('Nepodařilo se načíst hodnocení', 'error');
		}

		parent::render($args);
	}

	protected function createComponentDailyScore(): IComponent
	{
		return $this->dailyScoreControlFactory->create();
	}

	protected function createComponentDailyScoreForm(): IComponent
	{
		return $this->dailyScoreControlFormFactory->create($this->date);
	}
}