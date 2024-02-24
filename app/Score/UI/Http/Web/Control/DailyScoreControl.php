<?php

namespace app\Score\UI\Http\Web\Control;

use app\Score\Application\Command\CreateScore;
use app\Score\Application\Query\GetScore;
use app\System\UI\Http\Web\Control\BaseControl;
use Nette\Application\UI\Form;
use Nette\ComponentModel\IComponent;
use Nette\Utils\ArrayHash;

class DailyScoreControl extends BaseControl
{
	public function formSucceeded(Form $form, ArrayHash $values): void
	{
		try {
			$this->sendCommand(new CreateScore($values->score1, $values->score2, new \DateTimeImmutable()));
		} catch (\Exception $e) {
			bdump($e);
			$this->flashMessage('Nepodařilo se uložit hodnocení', 'error');
		}

		$this->redrawControl();
	}

	public function render(mixed ...$args): void
	{
		try {
			$this->template->score = $this->sendQuery(new GetScore());
		} catch (\Exception $e) {
			bdump($e);
			$this->flashMessage('Nepodařilo se načíst hodnocení', 'error');
		}

		parent::render($args);
	}

	protected function createComponentScoreForm(): IComponent
	{
		$form = new Form;
		$form->addSelect('score1', 'Hodnocení 1', [1, 2, 3, 4, 5, 6, 7, 8, 9, 10]);
		$form->addSelect('score2', 'Hodnocení 2', [1, 2, 3, 4, 5, 6, 7, 8, 9, 10]);
		$form->addSubmit('send', 'Uložit');
		$form->onSuccess[] = [$this, 'formSucceeded'];

		return $form;
	}
}