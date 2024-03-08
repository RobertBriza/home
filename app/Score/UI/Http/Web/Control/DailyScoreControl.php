<?php

namespace app\Score\UI\Http\Web\Control;

use app\Score\Application\Command\DeleteScore;
use app\Score\UI\Http\Web\ScorePresenter;
use app\System\UI\Http\Web\Control\BaseControl;
use Exception;

/** @property ScorePresenter $presenter */
class DailyScoreControl extends BaseControl
{
	public function handleDelete(int $id): void
	{
		$this->sendCommand(new DeleteScore($id));
		$this->redrawControl();
	}

	public function render(mixed ...$args): void
	{
		try {
			$this->template->score = $args['score'];
		} catch (Exception $e) {
			bdump($e);
			$this->flashMessage('Nepodařilo se načíst hodnocení', 'error');
		}

		parent::render($args);
	}
}