<?php

namespace app\Score\UI\Http\Web\Control;

use app\Score\Application\Command\CreateScore;
use app\Score\UI\Http\Web\ScorePresenter;
use app\System\UI\Http\Web\Control\BaseControl;
use DateTimeImmutable;
use Exception;
use Nette\Application\UI\Form;
use Nette\ComponentModel\IComponent;
use Nette\Utils\ArrayHash;

/** @property ScorePresenter $presenter */
class DailyScoreControlForm extends BaseControl
{
	public function __construct(protected DateTimeImmutable $date)
	{
	}

	public function formSucceeded(Form $form, ArrayHash $values): void
	{
		try {
			$this->sendCommand(new CreateScore($values->score1, $values->score2, $this->date));
		} catch (Exception) {
			$this->flashMessage('Nepodařilo se uložit hodnocení', 'error');
		}

		$this->redrawControl();
	}

	protected function createComponentScoreForm(): IComponent
	{
		$form = new Form;
		$form->addSelect('score1', 'Hodnocení 1', [0, 1, 2, 3, 4, 5, 6, 7, 8, 9, 10]);
		$form->addSelect('score2', 'Hodnocení 2', [0, 1, 2, 3, 4, 5, 6, 7, 8, 9, 10]);
		$form->addSubmit('send', 'Uložit');
		$form->onSuccess[] = [$this, 'formSucceeded'];

		return $form;
	}
}